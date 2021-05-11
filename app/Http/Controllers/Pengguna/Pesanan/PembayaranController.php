<?php

namespace App\Http\Controllers\Pengguna\Pesanan;

use App\Buku;
use App\DetailPesanan;
use App\Pembayaran;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class PembayaranController extends Controller
{
    public function index(Request $request) {
        $data = Pembayaran::join('tbl_pesanan as pesanan', 'pesanan.id_pesanan', 'tbl_pembayaran.id_pesanan')
            ->select('tbl_pembayaran.*', 'pesanan.total_bayar')
            ->where([
                ['tbl_pembayaran.id_pengguna', session('id_pengguna')],
                ['tbl_pembayaran.selesai', '0'],
                ['tbl_pembayaran.foto_bukti', '<>', 'NULL']
            ])
            ->get();
        return view('pengguna.pesanan.pembayaran', ['data_pembayaran' => $data]);
    }

    public function upload_bukti(Request $request, $id_pesanan) {
        if (session()->has('email_pengguna')) {
            $data = Pembayaran::where('id_pesanan', $id_pesanan);

            if (Carbon::parse(explode(' ', Carbon::now())[0])->gt(Carbon::parse($data->first()->batas_pembayaran))) {
                return back()->withErrors('Pesanan "'.$id_pesanan.'" Sudah melampui batas waktu.');
            }

            if ($data->first()->foto_bukti != NULL ) {
                return redirect()->route('pesanan');
            }

            return view('pengguna.pesanan.upload_bukti', ['id_pesanan' => $id_pesanan]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    // public function sendPhoto()
    // {
    //     return view('photo');
    // }

    public function save_bukti(Request $request, $id_pesanan) {
        if (session()->has('email_pengguna') && $request->has('simpan')) {
            $validasi = Validator::make($request->all(), [
                'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            $data = Pembayaran::where('id_pesanan', $id_pesanan);

            // membuat batas waktu pembayaran
            if (Carbon::parse(explode(' ', Carbon::now())[0])->gt(Carbon::parse($data->first()->batas_pembayaran))) {
                return back()->withErrors('Sudah melampui batas waktu.');
            }

            $data_buku = DetailPesanan::select('id_buku')->where('id_pesanan', $id_pesanan)->get();

            foreach ($data_buku as $item) {
                $stok1 = Buku::where('id_buku', $item->id_buku)->first();

                if ($stok1->stok_buku <= 0) {
                    return back()->withErrors('stok "'.$stok1->judul_buku.'" kosong / telah habis.');
                }
            }

            if ($data->exists() && $data->first()->foto_bukti == NULL) {
                $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();

                $photo = $request->file('bukti_pembayaran');

                Telegram::sendPhoto([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
                    'photo' => InputFile::createFromContents(file_get_contents($photo->getRealPath()), $id_pesanan . '.' . $extension),
                    'caption' => '[PEMBAYARAN] Pembayaran dengan ID pesanan "'.$id_pesanan.'" telah masuk !'
                ]);

                // menentukan dimana file foto bukti di simpan
                $foto_bukti = Storage::putFileAs(
                    'public/pembayaran/',
                    $request->file('bukti_pembayaran'),
                    $id_pesanan.'.'.$extension
                );

                Pembayaran::where('id_pesanan', $id_pesanan)->update([
                    'foto_bukti'        => $id_pesanan.'.'.$extension,
                    'tanggal_upload'    => Carbon::now(),
                ]);

                $data_buku = DetailPesanan::select('id_buku', 'jumlah_beli')->where('id_pesanan', $id_pesanan)->get();

                foreach ($data_buku as $item) {
                    $detail = Buku::where('id_buku', $item->id_buku);

                    $stok_buku = $detail->first()->stok_buku - $item->jumlah_beli;

                    $detail->update(['stok_buku' => $stok_buku]);
                }

                return redirect()->route('pesanan')->with('success', 'Bukti pembayaran berhasil di upload, menunggu pembayaan diverifikasi.');
            } else {
                return back()->withErrors('Terjadi kesalahan saat menyimpan foto');
            }
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }
}
