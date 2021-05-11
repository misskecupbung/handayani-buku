<?php

namespace App\Http\Controllers\Admin\Transaksi;

// use Illuminate\Support\Facades\DB;
use App\Pesanan;
use App\DetailPesanan;
use App\Pembayaran;
use DateTime;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        if ($request->session()->exists('email_admin')) {

            $stat_label = [
                'bg-gray', 'label-info', 'bg-blue',
            ];

            $stat_notif = [
                'Belum Di Proses', 'Sedang Di Proses', 'Siap Dikirim',
            ];

            $data = Pesanan::join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'tbl_pesanan.id_pesanan')
                ->select('tbl_pesanan.*', 'pembayaran.*')
                ->get();

            return view('admin.transaksi.pesanan', [
                'data_pesanan'  => $data,
                'stat_label'    => $stat_label,
                'stat_notif'    => $stat_notif
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');

        }
    }

    public function detail_pesanan(Request $request, $id_pesanan) {

        if($request->session()->exists('email_admin')) {

            $status = [
                'Belum Di Proses',
                'Telah Di Verifikasi',
                'Sedang Di Proses',
                'Telah Di Kirim',
                'Telah Di Terima',
                'Selesai'
            ];

            $data_pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
            $data_pembayaran = Pembayaran::where('id_pesanan', $id_pesanan)->first();
            $data_detail  = DetailPesanan::join('tbl_buku', 'tbl_buku.id_buku', 'tbl_detail_pesanan.id_buku')
                ->select('tbl_buku.*', 'tbl_detail_pesanan.*')
                ->where('tbl_detail_pesanan.id_pesanan', $id_pesanan)->get();

            return view('admin.transaksi.detail_pesanan', [
                'data_pesanan'  => $data_pesanan,
                'pembayaran'    => $data_pembayaran,
                'data_detail'   => $data_detail,
                'status'        => $status,
                'invoice'       => true
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function proses_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $data = Pesanan::where('id_pesanan', $id_pesanan);

            $status = $data->first()->status_pesanan;

            if($status <= 2) {

                $data->update([
                    'status_pesanan'    => $status == 1 ? 2 : 1,
                ]);

                return redirect()->route('pesanan_admin')->with('success', 'Status Berhasil DI Rubah');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }
    }

    public function kirim_pesanan(Request $request, $id_pesanan) {

        if ($request->has('simpan') == true) {

            $validasi = Validator::make($request->all(), [

                'resi'  => 'required|alpha_num|max:20'

            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = Pesanan::where('id_pesanan', $id_pesanan);

            $status = $data->first()->status_pesanan;

            if ($status <= 3 && $status > 1) {

                $data->update([
                    'no_resi'           => $status == 2 ? $request->input('resi') : NULL,
                    'status_pesanan'    => $status == 2 ? 3 : 2,
                    'tanggal_dikirim'   => $status == 2 ? (new DateTime)->format('Y-m-d H:m:s') : NULL
                ]);

                return redirect()->route('pengiriman_admin')->with('success',
                    $status == 2 ? 'Pesanan berhasil di proses, menunggu konfirmasi penerimaan pesanan oleh pengguna !' : 'Proses pesanan berhasil di batalkan !');

            } else {

                return back()->withErrors('Terjadi kesalahan saat memproses pesanan !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat memproses pesanan !');

        }
    }

    public function batalkan_pesanan(Request $request, $id_pesanan) {

        if ($request->has('simpan') == true) {

            $data = Pesanan::where('id_pesanan', $id_pesanan);

            $status = $data->first()->dibatalkan;

            if($data->first()->status_pesanan < 3) {

                $data->update([
                    'dibatalkan' => $status == 0 ? 1 : 0,
                ]);

                return redirect()->route('pesanan_admin')->with('success',
                    $status == 0 ? 'Pesanan berhasil di batalkan !' : 'Pembatalan pesanan berhasil di cabut !');

            } else {

                return back()->withErrors('Terjadi kesalahan saat membatalkan pesanan !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat membatalkan pesanan !');

        }

    }

    public function hapus_pesanan(Request $request, $id_pesanan) {

        if ($request->has('simpan') == true) {

            $data = Pesanan::where('id_pesanan', $id_pesanan);

            if ($data->first()->status_pesanan < 3) {

                $data->delete();

                return redirect()->route('pesanan_admin')->with('success', 'Pesanan berhasil di hapus !');

            } else {

                return back()->withErrors('Terjadi kesalahan saat menghapus pesanan !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menghapus pesanan !');

        }

    }

    public function get_info_penerima(Request $request, $id_pesanan) {

        if($request->session()->exists('email_admin')) {

            $data = Pesanan::where('id_pesanan', $id_pesanan)->first();

            return response()->json($data);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }
}
