<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Kategori;
use App\Penerbit;
use App\Buku;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('email_admin')) {
            if (!empty($request->input('penerbit')) && !empty($request->input('kategori'))) {

                $id_kategori = Kategori::where('nama_kategori', ucfirst($request->input('kategori')))->first();

                $id_penerbit = Penerbit::where('nama_penerbit', ucfirst($request->input('penerbit')))->first();

                $data = Buku::where([
                        ['tbl_penerbit.id_penerbit', $id_penerbit->id_penerbit],
                        ['tbl_kategori.id_kategori', $id_kategori->id_kategori]
                    ])
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_buku.id_kategori')
                    ->join('tbl_penerbit', 'tbl_penerbit.id_penerbit', 'tbl_buku.id_penerbit')
                    ->select('tbl_buku.*', 'tbl_kategori.*', 'tbl_penerbit.*')
                    ->get();

            } else if (!empty($request->input('kategori'))) {
                $id_kategori = Kategori::where('nama_kategori', ucfirst($request->input('kategori')))->first();

                $data = Buku::where('tbl_kategori.id_kategori', $id_kategori->id_kategori)
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_buku.id_kategori')
                    ->join('tbl_penerbit', 'tbl_penerbit.id_penerbit', 'tbl_buku.id_penerbit')
                    ->select('tbl_buku.*', 'tbl_kategori.*', 'tbl_penerbit.*')
                    ->get();
            } else if (!empty($request->input('penerbit'))) {

                $id_penerbit = Penerbit::where('nama_penerbit', ucfirst($request->input('penerbit')))->first();

                $data = Buku::where('tbl_penerbit.id_penerbit', $id_penerbit->id_penerbit)
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_buku.id_kategori')
                    ->join('tbl_penerbit', 'tbl_penerbit.id_penerbit', 'tbl_buku.id_penerbit')
                    ->select('tbl_buku.*', 'tbl_kategori.nama_kategori', 'tbl_penerbit.*')
                    ->get();
            } else {
                $data = Buku::join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_buku.id_kategori')
                ->join('tbl_penerbit', 'tbl_penerbit.id_penerbit', 'tbl_buku.id_penerbit')
                ->select('tbl_buku.*', 'tbl_kategori.nama_kategori', 'tbl_penerbit.nama_penerbit')
                ->get();
            }

            $penerbit = Penerbit::get();
            $kategori = Kategori::get();

            return view('admin.produk.buku', [
                'data_buku'     => $data,
                'data_penerbit' => $penerbit,
                'data_kategori' => $kategori
            ]);

        } else {
            return redirect()->route('login_admin')->with('fail', 'Harap login terlebih dahulu !');
        }
    }

    public function store(Request $request)
    {
        if ($request->has('simpan')) {
            $validasi = Validator::make($request->all(), [
                'judul_buku'        => 'required|max:50',
                'penulis_buku'      => 'required|max:50',
                'deskripsi_buku'    => 'required',
                'jumlah_halaman'    => 'required|integer',
                'tanggal_terbit'    => 'required',
                'ISBN'              => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:13',
                'bahasa_buku'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:30',
                'format_buku'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:30',
                'berat_buku'        => 'required|integer',
                'dimensi_buku'      => 'required',
                'harga_satuan'      => 'required|integer',
                'stok_buku'         => 'required|integer',
                'foto_buku'         => 'required|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            if (Buku::where('judul_buku', $request->input('judul_buku'))->exists() == false) {

                $id_buku = $this->store_id();

                $extension = $request->file('foto_buku')->getClientOriginalExtension();

                $foto_buku = Storage::putFileAs(
                    'public/buku/',
                    $request->file('foto_buku'), $id_buku.'.'.$extension
                );

                Buku::insert([
                    'id_buku'           => $id_buku,
                    'judul_buku'        => $request->input('judul_buku'),
                    'penulis_buku'      => $request->input('penulis_buku'),
                    'id_kategori'       => $request->input('id_kategori'),
                    'id_penerbit'       => $request->input('id_penerbit'),
                    'deskripsi_buku'    => $request->input('deskripsi_buku'),
                    'jumlah_halaman'    => $request->input('jumlah_halaman'),
                    'tanggal_terbit'    => $request->input('tanggal_terbit'),
                    'ISBN'              => $request->input('ISBN'),
                    'bahasa_buku'       => $request->input('bahasa_buku'),
                    'format_buku'       => $request->input('format_buku'),
                    'berat_buku'        => $request->input('berat_buku'),
                    'dimensi_buku'      => $request->input('dimensi_buku'),
                    'harga_satuan'      => $request->input('harga_satuan'),
                    'stok_buku'         => $request->input('stok_buku'),
                    'foto_buku'         => basename($foto_buku),
                    'tanggal_masuk'     => Carbon::now(),
                ]);

                return redirect()->route('list_buku')->with('success', 'Buku berhasil di simpan !');
            } else {
                return back()->withErrors('Buku tidak dapat di simpan karna telah tersedia !');
            }

        } else {
            return back()->withErrors('Terjadi kesalahan saat menyimpan buku !');
        }
    }

    public function update(Request $request, $id_buku)
    {
        if ($request->has('simpan')) {
            $validasi = Validator::make($request->all(), [
                'judul_buku'        => 'required|max:50',
                'penulis_buku'      => 'required|max:50',
                'deskripsi_buku'    => 'required',
                'jumlah_halaman'    => 'required|integer',
                'tanggal_terbit'    => 'required',
                'ISBN'              => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:13',
                'bahasa_buku'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:30',
                'format_buku'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:30',
                'berat_buku'        => 'required|integer',
                'dimensi_buku'      => 'required',
                'harga_satuan'      => 'required|integer',
                'stok_buku'         => 'required|integer',
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            $data = Buku::select('foto_buku')->where('id_buku', $id_buku)->first();

            if ($request->hasFile('foto_buku')) {

                Storage::delete('public/buku/'.$data->foto_buku);

                $extension = $request->file('foto_buku')->getClientOriginalExtension();

                $save_foto = Storage::putFileAs(
                    'public/buku/',
                    $request->file('foto_buku'), $id_buku.'.'.$extension
                );

                $foto_buku = basename($save_foto);
            }

            Buku::where('id_buku', $id_buku)
                ->update([
                    'judul_buku'        => $request->input('judul_buku'),
                    'penulis_buku'      => $request->input('penulis_buku'),
                    'id_kategori'       => $request->input('id_kategori'),
                    'id_penerbit'       => $request->input('id_penerbit'),
                    'deskripsi_buku'    => $request->input('deskripsi_buku'),
                    'jumlah_halaman'    => $request->input('jumlah_halaman'),
                    'tanggal_terbit'    => $request->input('tanggal_terbit'),
                    'ISBN'              => $request->input('ISBN'),
                    'bahasa_buku'       => $request->input('bahasa_buku'),
                    'format_buku'       => $request->input('format_buku'),
                    'berat_buku'        => $request->input('berat_buku'),
                    'dimensi_buku'      => $request->input('dimensi_buku'),
                    'harga_satuan'      => $request->input('harga_satuan'),
                    'stok_buku'         => $request->input('stok_buku'),
                    'foto_buku'         => $request->hasFile('foto_buku') ? $foto_buku : $data->foto_buku,
                    'tanggal_masuk'     => Carbon::now(),
                ]);

                return redirect()->route('list_buku')->with('success', 'Buku berhasil di ubah !');
        } else {
            return back()->withErrors('Terjadi kesalahan saat mengubah buku !');
        }
    }

    public function destroy(Request $request, $id_buku)
    {
        $data = Buku::where('id_buku', $id_buku);

        Storage::delete('public/buku/'.$data->first()->foto_buku);

        $data->delete();

        return redirect()->route('list_buku')->with('success', 'Buku berhasil di hapus !');
    }

    public function get($id_buku)
    {
        $data = Buku::join('tbl_kategori as kategori', 'kategori.id_kategori', 'tbl_buku.id_kategori' )
        ->join('tbl_penerbit as penerbit', 'penerbit.id_penerbit', 'tbl_buku.id_penerbit')
        ->select('tbl_buku.*', 'kategori.*', 'penerbit.*')
        ->where('tbl_buku.id_buku', $id_buku)
        ->first();

        return response()->json($data);
    }

    protected function store_id()
    {
        $data = Buku::max('id_buku');

        if (!empty($data)) {

            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'BKU'.sprintf("%03s", $no_urut);
        } else {
            return 'BKU'.'001';
        }
    }
}
