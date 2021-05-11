<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Pesanan;
use App\Pembayaran;
use DateTime;
use validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengirimanController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('email_admin')) {

            $data = Pesanan::select(
                    'id_pesanan', 'nama_penerima', 'alamat_tujuan', 'layanan', 'tanggal_diterima',
                    'no_telepon', 'no_resi', 'status_pesanan', 'tanggal_dikirim'
                )->get();

            return view('admin.transaksi.pengiriman', ['data_pengiriman' => $data]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');

        }
    }

    public function batalkan_pesanan(Request $request, $id_pesanan) {

        if ($request->has('simpan') == true) {

            $data = Pesanan::where('id_pesanan', $id_pesanan);

            $status = $data->first()->dibatalkan;

            if($data->exists()) {

                $data->update([
                    'dibatalkan'        => 1,
                    'status_pesanan'    => 1,
                    'no_resi'           => NULL,
                    'tanggal_dikirim'   => NULL
                ]);

                return redirect()->route('pengiriman_admin')->with('success',
                    $status == 0 ? 'Pesanan Berhasil Di Batalkan' : 'Pembatalan pesanan berhasil di cabut !');

            } else {

                return back()->withErrors('Terjadi kesalahan saat membatalkan pesanan !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat membatalkan pesanan !');

        }

    }

    public function selesai(Request $request, $id_pesanan) {

        if ($request->session()->exists('email_admin')) {

            $data = Pesanan::where([
                'id_pesanan'        => $id_pesanan,
                'status_pesanan'    => 4
            ]);

            if(!empty($data->first())) {

                $data->update(['status_pesanan' => 5]);

                Pembayaran::where('id_pesanan', $id_pesanan)->update(['selesai' => 1]);
            }

            return back()->with('success', 'Pesanan dengan ID '.$id_pesanan.' telah selesai !');

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');

        }

    }
}
