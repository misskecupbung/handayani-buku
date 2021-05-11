<?php

namespace App\Http\Controllers\Pengguna\Keranjang;

use App\Keranjang;
use App\Pengguna;
use App\Buku;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Crypt;

class KeranjangController extends Controller
{
    public function index(Request $request) {
        if (session()->has('id_pengguna')) {

            $data = Keranjang::join('tbl_buku as buku', 'buku.id_buku', 'tbl_keranjang.id_buku')
                ->select('buku.*', 'tbl_keranjang.*')->where('id_pengguna', session('id_pengguna'))->get();

            $alamat = Pengguna::where('id_pengguna', session('id_pengguna'));

            return view('pengguna.keranjang.keranjang', [
                'data_keranjang' => $data,
                'alamat'         => $alamat,
            ]);

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');

        }
    }

    public function update(Request $request, $id_buku) {
        if ($request->has('simpan')) {

            if($request->input('jumlah_beli') == 0){

                return back()->withErrors('Jumlah pembelian minimal 1 Pcs !');

            }

            $data = Keranjang::where([
                ['id_buku', $id_buku],
                ['id_pengguna', session('id_pengguna')]
            ]);

            if ($data->exists()){

                $barang = Buku::where([
                    'id_buku' => $id_buku
                ])->first();

                if($barang->stok_buku < $request->input('jumlah_beli')){
                    return back()->withErrors('Jumlah beli melebihi stok !');
                }

                $subtotal = $barang->harga_satuan * $request->input('jumlah_beli');

                $data->update([
                    'jumlah_beli'    => $request->input('jumlah_beli'),
                    'subtotal_biaya' => $subtotal,
                ]);

                return back()->with('success', 'Perubahan jumlah beli berhasil di proses !');

            } else {

                return back()->withErrors('Terjadi kesalahan, buku tidak ditemukan !');

            }

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');

        }
    }

    public function destroy(Request $request, $id_buku) {
        if ($request->has('simpan')) {

            $data = Keranjang::where([
                ['id_buku', $id_buku],
                ['id_pengguna', session('id_pengguna')]
            ]);

            if ($data->exists()){

                $data->delete();

                return back()->with('success', 'Buku berhasil di hapus dari keranjang !');

            } else {

                return back()->withErrors('Terjadi kesalahan, buku tidak ditemukan !');

            }

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }
    }

    public function method(Request $request) {

        if ($request->has('simpan') && session()->has('email_pengguna')) {

            $validasi = Validator::make($request->all(), [
                'pilih_alamat' => 'required|integer|max:2'
            ]);

            if($validasi->fails()){
                return back()->withErrors($validasi);
            }

            $method = Crypt::encrypt($request->input('pilih_alamat'));

            return redirect()->route('checkout_keranjang', ['method' => $method]);

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }
}
