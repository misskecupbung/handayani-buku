<?php

namespace App\Http\Controllers\Pengguna\Keranjang;

use App\Keranjang;
use App\Pengguna;
use App\Buku;
use App\Pesanan;
use App\DetailPesanan;
use App\Pembayaran;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Telegram\Bot\Laravel\Facades\Telegram;

class CheckoutController extends Controller
{
    public function index(Request $request, $method) {
        if (session()->has('email_pengguna')) {

            $data = Keranjang::join('tbl_buku as buku', 'buku.id_buku', 'tbl_keranjang.id_buku')
                ->where('tbl_keranjang.id_pengguna', session('id_pengguna'));

            if ($data->exists()) {

                $d_method = Crypt::decrypt($method);

                if($d_method == "1") {

                    $detail_pengirim = Pengguna::where('id_pengguna', session('id_pengguna'))->first();

                    return view('pengguna.keranjang.checkout', [
                        'data_checkout' => $data->get(),
                        'default'       => $detail_pengirim
                    ]);

                } else if ($d_method == "2") {

                    return view('pengguna.keranjang.checkout', [
                        'data_checkout' => $data->get()
                    ]);

                }

            }

        }
    }

    public function sendMessage()
    {
        return view('message');
    }

    public function store(Request $request) {
        if (session()->has('email_pengguna') && $request->input('simpan')) {

            $id_pengguna = session('id_pengguna');
            $id_pesanan  = $this->store_id();
            $req = $request->all();

            $validasi = Validator::make($req, [
                'nama_penerima' => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'alamat_tujuan' => 'required|string',
                'no_telepon'    => 'required|regex:/^[0-9\-\w\+]*$/|max:20',
                'keterangan'    => 'nullable|string',
                'service'       => 'required|alpha',
                'destinasi'     => 'required|regex:/^[a-zA-Z\,\.\s]*$/',
                'layanan'       => 'required|integer',
                'bank'          => 'required|alpha',
                'atas_nama'     => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'no_rekening'   => 'required|regex:/^[0-9\-\s]*$/'
            ]);

            if ($validasi->fails()){

                return back()->withErrors($validasi);

            }

            $keranjang = Keranjang::where('id_pengguna', $id_pengguna);

            if ($keranjang->exists()){

                $save_pesanan = Pesanan::insert([
                    'id_pesanan'        => $id_pesanan,
                    'id_pengguna'       => $id_pengguna,
                    'nama_penerima'     => $req['nama_penerima'],
                    'alamat_tujuan'     => $req['alamat_tujuan'].'|'.$req['destinasi'],
                    'no_telepon'        => $req['no_telepon'],
                    'keterangan'        => !is_null($req['keterangan']) ? $req['keterangan'] : NULL,
                    'layanan'           => $req['service'],
                    'ongkos_kirim'      => $req['layanan'],
                    'total_bayar'       => $keranjang->sum('subtotal_biaya'),
                    'tanggal_pesanan'   => Carbon::now(),
                ]);

                Pembayaran::insert([
                    'id_pesanan'        => $id_pesanan,
                    'id_pengguna'       => $id_pengguna,
                    'bank'              => $req['bank'],
                    'atas_nama'         => $req['atas_nama'],
                    'no_rekening'       => $req['no_rekening'],
                    'batas_pembayaran'  => Carbon::tomorrow(),
                    'tanggal_upload'    => Carbon::now(),
                ]);

                if ($save_pesanan == True) {

                    foreach ($keranjang->get() as $item) {

                        $buku = Buku::where('id_buku', $item->id_buku)->first();

                        DetailPesanan::insert([
                            'id_pesanan'     => $id_pesanan,
                            'id_buku'        => $item->id_buku,
                            'jumlah_beli'    => $item->jumlah_beli,
                            'subtotal_berat' => ($item->jumlah_beli * $buku->berat_buku),
                            'subtotal_biaya' => $item->subtotal_biaya
                        ]);

                    }

                    $total_bayarnya = ($item->subtotal_biaya + $request->layanan);

                    $notif = "<b>[PESANAN] Anda mendapat pesanan baru</b>\n\n"
                        . "<b>ID Pesanan : </b>" . "$id_pesanan\n"
                        . "<b>Nama Penerima : </b>" . "$request->nama_penerima\n"
                        . "<b>Alamat Tujuan : </b>" . "$request->alamat_tujuan"." | ".  "$request->destinasi\n"
                        . "<b>No Telepon : </b>" . "$request->no_telepon\n"
                        . "<b>keterangan : </b>" . "$request->keterangan\n"
                        . "<b>Total Bayar : </b>" . "$total_bayarnya\n";

                    Telegram::sendMessage([
                        'chat_id'       => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
                        'parse_mode'    => 'HTML',
                        'text'          => $notif
                    ]);

                    Keranjang::where('id_pengguna', $id_pengguna)->delete();

                    return redirect()->route('pesanan')->with('success', 'Pesanan berhasil di simpan !');

                } else {

                    Pesanan::where('id_pesanan', $id_pesanan)->delete();

                    return back()->withErrors('Terjadi kesalahan saat memproses checkout !');

                }

            } else {

                return back()->withErrors('Data keranjang tidak ditemukan !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menyimpan !');

        }
    }

    protected function store_id() {

        $data = Pesanan::max('id_pesanan');

        if (!empty($data)) {

            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'PSN'.sprintf("%03s", $no_urut);
        } else {
            return 'PSN'.'001';
        }
    }
}
