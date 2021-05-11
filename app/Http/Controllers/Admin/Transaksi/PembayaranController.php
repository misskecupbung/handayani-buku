<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Pesanan;
use App\Pembayaran;
use App\Invoice;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Transaksi\InvoiceController;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('email_admin')) {

            $data = Pembayaran::join('tbl_pesanan as pesanan', 'pesanan.id_pesanan', 'tbl_pembayaran.id_pesanan')
                ->select('tbl_pembayaran.*', 'pesanan.status_pesanan')
                ->where('tbl_pembayaran.selesai', 0)
                ->get();

            return view('admin.transaksi.pembayaran', ['data_pembayaran' => $data]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');

        }
    }

    public function update(Request $request, $id_pesanan)
    {
        // Status pembayaran
        // - 0 => menunggun verifikasi
        // - 1 => telah di terima

        if ($request->has('simpan') == true) {
            $pesanan = Pesanan::where('id_pesanan', $id_pesanan);
            $pembayaran = Pembayaran::where('id_pesanan', $id_pesanan);

            $invoice = new InvoiceController();

            if ($pembayaran->first()->status_pembayaran == 0) {
                $invoice->save_invoice($id_pesanan, $pesanan->first()->id_pengguna);
            } else {
                $inv = Invoice::where('id_pesanan', $id_pesanan)->first();

                $invoice->delete_invoice($inv->id_invoice);
            }

            $data = $pesanan->update(['status_pesanan' => $pesanan->first()->status_pesanan == 0 ? 1 : 0]);
            $pembayaran->update(['status_pembayaran' => $pembayaran->first()->status_pembayaran == 0 ? 1 : 0]);

            return redirect()->route('pesanan_admin')->with('success', 'Pembayaran dengan ID '.$id_pesanan.' berhasil di update !');

        } else {
            return back()->withErrors('Terjadi kesalahan saat memproses pembayaran !');
        }
    }

    public function get(Request $request, $id_pesanan)
    {
        if ($request->session()->exists('email_admin')) {

            $data = Pembayaran::where('id_pesanan', $id_pesanan)->first();

            return response()->json($data);
        } else {
            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');
        }

    }
}
