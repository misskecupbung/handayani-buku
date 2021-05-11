<?php

namespace App\Http\Controllers\Pengguna\Pesanan;

use App\Pesanan;
use App\DetailPesanan;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class PesananController extends Controller
{
    // keterangan status pesanan
    // =========================
    // 0 => Belum di proses
    // 1 => Telah di verifikasi
    // 2 => Sedang di proses
    // 3 => Telah di kirim
    // 4 => telah di terima
    // 5 => selesai

    public function index(Request $request) {
        if (session()->has('email_pengguna')) {
            $data = Pesanan::join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'tbl_pesanan.id_pesanan')
                ->select('pembayaran.*', 'tbl_pesanan.*')
                ->where([
                    ['tbl_pesanan.id_pengguna', session('id_pengguna')],
                    ['tbl_pesanan.status_pesanan', '<=', 5]
                ])
                ->get();

            return view('pengguna.pesanan.pesanan', ['data_pesanan' => $data]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function sendMessage()
    {
        return view('message');
    }

    public function dibatalkan(Request $request, $id_pesanan) {
        if (session()->has('email_pengguna') && $request->has('simpan') == true) {
            $data = Pesanan::where([
                    ['id_pengguna', session('id_pengguna')],
                    ['id_pesanan', $id_pesanan]
                ]);

            if ($data->first()->status_pesanan < 3) {
                $data->update([
                    'dibatalkan'        => 1,
                    'status_pesanan'    => 1,
                    'no_resi'           => NULL,
                    'tanggal_dikirim'   => NULL
                ]);

                return redirect()->route('pesanan')->with('success', 'Pesanan berhasil di batalkan !');
            } else {
                return back()->withErrors('Terjadi kesalahan saat membatalkan pesanan !');
            }

        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function invoice(Request $request, $id_invoice) {
        if (session()->has('email_pengguna')) {
            $data = Invoice::join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'tbl_invoice.id_pesanan')
                ->join('tbl_pesanan as pesanan', 'pesanan.id_pesanan', 'tbl_invoice.id_pesanan')
                ->select('tbl_invoice.*', 'pembayaran.*', 'pesanan.*')
                ->where([
                    ['tbl_invoice.id_pengguna', session('id_pengguna')],
                    ['tbl_invoice.id_invoice', $id_invoice]
                ])
                ->first();

            $detail_pesanan = DetailPesanan::join('tbl_buku as buku', 'buku.id_buku', 'tbl_detail_pesanan.id_buku')
                ->select('tbl_detail_pesanan.*', 'buku.*')
                ->where('tbl_detail_pesanan.id_pesanan', $data->id_pesanan)
                ->get();

            return view('pengguna.pesanan.invoice', ['data_invoice' => $data, 'detail_pesanan' => $detail_pesanan]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function detail_pesanan(Request $request, $id_pesanan) {
        if (session()->has('email_pengguna')) {
            $data = Pesanan::join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'tbl_pesanan.id_pesanan')
                ->select('pembayaran.*', 'tbl_pesanan.*')
                ->where([
                    ['tbl_pesanan.id_pengguna', session('id_pengguna')],
                    ['tbl_pesanan.id_pesanan', $id_pesanan]
                ])
                ->first();

            $detail_pesanan = DetailPesanan::join('tbl_buku as buku', 'buku.id_buku', 'tbl_detail_pesanan.id_buku')
                ->select('tbl_detail_pesanan.*', 'buku.*')
                ->where('tbl_detail_pesanan.id_pesanan', $data->id_pesanan)
                ->get();

            return view('pengguna.pesanan.detail_pesanan', ['data_detail' => $data, 'detail_pesanan' => $detail_pesanan]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function konfirmasi_pesanan(Request $request, $id_pesanan) {
        if (session()->has('email_pengguna') && $request->has('simpan')) {
            Pesanan::where('id_pesanan', $id_pesanan)->update([
                'status_pesanan'    => 4,
                'tanggal_diterima'  => Carbon::now(),
            ]);

            $notif = "<b>[DITERIMA] Pesanan telah diterima</b>\n\n"
                . "<b>Pesanan dengan ID Pesanan : </b>" ."$request->id_pesanan". " Telah diterima oleh pengguna !";

            Telegram::sendMessage([
                'chat_id'       => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
                'parse_mode'    => 'HTML',
                'text'          => $notif
            ]);

            return redirect()->route('pesanan')->with('success', 'Pesanan '.$id_pesanan.' berhasil dikonfirmasi.');
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function riwayat_pesanan(Request $request) {
        if (session()->has('email_pengguna')) {
            $data = Pesanan::join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'tbl_pesanan.id_pesanan')
                ->select('pembayaran.*', 'tbl_pesanan.*')
                ->where([
                    ['tbl_pesanan.id_pengguna', session('id_pengguna')],
                    ['tbl_pesanan.status_pesanan', 5]
                ])
                ->get();

            return view('pengguna.pesanan.riwayat_pesanan', ['data_pesanan' => $data, 'inv' => NULL]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }
}
