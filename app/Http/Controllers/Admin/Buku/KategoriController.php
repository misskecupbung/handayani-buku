<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Kategori;
use DateTime;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('email_admin')) {
            $data = Kategori::All();
            return view('admin.produk.kategori', ['data_kategori' => $data]);
        } else {
            return redirect()->route('login_admin');
        }
    }

    public function store(Request $request)
    {
        if ($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_kategori' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if (Kategori::where('nama_kategori', $request->input('nama_kategori'))->exists() == false) {

                Kategori::insert([
                    'id_kategori'   => $this->store_id(),
                    'nama_kategori' => $request->input('nama_kategori'),
                ]);

                return redirect()->route('kategori_buku')->with('success', 'Kategori buku berhasil di tambah !');

            } else {

                return back()->withErrors('Kategori tidak dapat di gunakan karena telah tersedia');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menyimpan kategori !');

        }
    }

    public function update(Request $request, $id_kategori)
    {
        if ($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_kategori' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if (Kategori::where('nama_kategori', $request->input('nama_kategori'))->exists() == false) {

                Kategori::where('id_kategori', $id_kategori)
                    ->update(['nama_kategori' => $request->input('nama_kategori')]);

                return redirect()->route('kategori_buku')->with('success', 'Kategori buku berhasil di ubah !');

            } else {

                return redirect()->route('kategori_buku')->withErrors('Kategori tidak dapat di gunakan karena telah tersedia');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat mengubah kategori !');

        }
    }

    public function destroy(Request $request, $id_kategori)
    {
        if ($request->has('simpan')) {

            Kategori::where('id_kategori', $id_kategori)->delete();

            return redirect()->route('kategori_buku')->with('success', 'Kategori Buku Berhasil Di Hapus');

        } else {

            return back()->withErrors('Terjadi kesalahan saat mengapus kategori !');

        }
    }

    public function check() 
    {

        $nama_kategori = str_replace('%20', ' ', $_GET['nama_kategori']);

        $data = Kategori::where('nama_kategori', $nama_kategori)->exists();

        return response()->json($data);
    }

    public function get(Request $request)
    {
        $id_kategori = $request->input('id_kategori');

        $data = Kategori::where('id_kategori', $id_kategori)->first();

        return response()->json($data);
    }

    protected function store_id() 
    {
        $data = Kategori::max('id_kategori');

        if (!empty($data)) {

            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'KTG'.sprintf("%03s", $no_urut);
        } else {
            return 'KTG'.'001';
        }
    }
}
