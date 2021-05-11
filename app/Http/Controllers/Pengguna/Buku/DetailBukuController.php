<?php

namespace App\Http\Controllers\Pengguna\Buku;

use App\Buku;
use App\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailBukuController extends Controller
{
    public function index(Request $request, $id_buku) {
        $data = Buku::join('tbl_kategori as kategori', 'kategori.id_kategori', 'tbl_buku.id_kategori' )
            ->join('tbl_penerbit as penerbit', 'penerbit.id_penerbit', 'tbl_buku.id_penerbit')
            ->select('tbl_buku.*', 'kategori.*', 'penerbit.*')
            ->where('tbl_buku.id_buku', $id_buku);

        if ($data->exists()) {

            return view('pengguna.buku.detailbuku', ['detail' => $data->first()]);

        } else {

            return redirect()->route('buku')->withErrors('Gagal melihat buku !');

        }
    }

    public function keranjang(Request $request, $id_buku) {
        if ($request->has('simpan')) {

            if (!session()->has('id_pengguna')) {

                return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');

            }

            if ($request->input('jumlah_beli') == 0){

                return back()->withErrors('Jumlah pembelian minimal 1 pcs !');

            }

            $data = Buku::where('id_buku', $id_buku);

            if ($data->exists() && $data->first()->stok_buku != 0) {

                $total = [
                    'biaya' => $data->first()->harga_satuan * $request->input('jumlah_beli'),
                    'stok'  => $data->first()->stok_buku - $request->input('jumlah_beli')
                ];

                if ($total['stok'] == 0 || $data->first()->stok_buku < $request->input('jumlah_beli')) {

                    return back()->withErrors('Stok buku tidak mencukupi !');

                }

                $keranjang = Keranjang::where([
                    'id_pengguna'   => session('id_pengguna'),
                    'id_buku'       => $id_buku
                ]);

                if ($keranjang->exists()) {

                    $data_keranjang = $keranjang->first();

                    $total_baru = [
                        'biaya'       => $data_keranjang->subtotal_biaya + $total['biaya'],
                        'jumlah_beli' => $data_keranjang->jumlah_beli + $request->input('jumlah_beli')
                    ];

                    Keranjang::where([
                        'id_pengguna'       => session('id_pengguna'),
                        'id_buku'           => $id_buku
                    ])->update([
                        'jumlah_beli'       => $total_baru['jumlah_beli'],
                        'subtotal_biaya'    => $total_baru['biaya']
                    ]);

                    return redirect()->route('keranjang')->with('success', $data->first()->judul_buku.' berhasil di tambahkan ke keranjang !');

                } else {

                    Keranjang::insert([
                        'id_pengguna'       => session('id_pengguna'),
                        'id_buku'           => $id_buku,
                        'jumlah_beli'       => $request->input('jumlah_beli'),
                        'subtotal_biaya'    => $total['biaya']
                    ]);

                    return redirect()->route('keranjang')->with('success', $data->first()->judul_buku.' berhasil di tambahkan ke keranjang !');
                }

            } else {

                return back()->withErrors('Buku tidak ditemukan atau stok buku kosong !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menyimpan buku ke keranjang !');

        }
    }
}
