<?php

namespace App\Http\Controllers\Pengguna\Buku;

use App\Kategori;
use App\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request) {
        $data = [];

        foreach (Kategori::get() as $item) {
            $data[] = [
                'nama_kategori' => $item->nama_kategori,
                'jumlah_buku' => Buku::where('id_kategori', $item->id_kategori)->count()
            ];
        }

        if ($request->has('kategori')) {
            $nama_kategori = str_replace('-', ' ', ucwords($request->input('kategori'), '-'));

            $kategori = Kategori::where('nama_kategori', $nama_kategori);

            if ($request->has('search')) {

                $search = '%'.$request->input('search').'%';

                $data_buku = Buku::where([
                    ['id_kategori', $kategori->exists() ? $kategori->first()->id_kategori : ''],
                    ['judul_buku', 'LIKE', $search]
                ])->orderBy('tanggal_masuk', 'desc');

            } else {

                $data_buku = Buku::where('id_kategori',
                    $kategori->exists() ? $kategori->first()->id_kategori : ''
                )->orderBy('tanggal_masuk', 'desc');

            }

            return view('pengguna.buku.buku', [
                'buku'          => $data_buku->paginate(9),
                'kategori'      => $data,
                'data_filter'   => $nama_kategori,
                'jumlah_buku'   => Buku::all()
            ], compact('buku'));
        } else {
            if ($request->has('search')) {

                $search = '%'.$request->input('search').'%';

                return view('pengguna.buku.buku', [
                    'buku'          => Buku::where('judul_buku', 'LIKE', $search)->paginate(9),
                    'kategori'      => $data,
                    'jumlah_buku'   => Buku::all()
                ], compact('buku'));

            } else {

                return view('pengguna.buku.buku', [
                    'buku'        => Buku::orderBy('tanggal_masuk', 'desc')->paginate(9),
                    'kategori'    => $data,
                    'jumlah_buku' => Buku::all()
                ], compact('buku'));

            }
        }
    }

    public function filter() {
        return false;
    }
}
