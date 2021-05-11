<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Penerbit;
use DateTime;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('email_admin')) {

            $data = Penerbit::all();

            return view('admin.produk.penerbit', ['data_penerbit' => $data]);

        } else {

            return redirect()->route('login_admin');

        }
    }

    public function store(Request $request)
    {
        if ($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_penerbit' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if (Penerbit::where('nama_penerbit', $request->input('nama_penerbit'))->exists() == false) {

                Penerbit::insert([
                    'id_penerbit'   => $this->store_id(),
                    'nama_penerbit' => $request->input('nama_penerbit'),
                ]);

                return redirect()->route('penerbit_buku')->with('success', 'Penerbit buku berhasil di tambah !');

            } else {

                return redirect()->route('penerbit_buku')->withErrors('Penerbit tidak dapat di gunakan karena telah tersedia !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menyimpan penerbit !');

        }
    }

    public function get(Request $request)
    {
        $id_penerbit = $request->input('id_penerbit');

        $data = Penerbit::where('id_penerbit', $id_penerbit)->first();

        echo response()->json($data);
    }

    public function update(Request $request, $id_penerbit)
    {
        if ($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_penerbit' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if (Penerbit::where('nama_penerbit', $request->input('nama_penerbit'))->exists() == false) {

                Penerbit::where('id_penerbit', $id_penerbit)
                    ->update(['nama_penerbit' => $request->input('nama_penerbit')]);

                return redirect()->route('penerbit_buku')->with('success', 'Penerbit buku berhasil di ubah !');

            } else {

                return back()->withErrors('Penerbit tidak dapat di gunakan karena telah tersedia !');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat mengubah penerbit !');

        }
    }

    public function destroy(Request $request, $id_penerbit)
    {
        if($request->has('simpan')) {

            Penerbit::where('id_penerbit', $id_penerbit)->delete();

            return redirect()->route('penerbit_buku')->with('success', 'Penerbit buku berhasil di dapus !');

        } else {

            return back()->withErrors('Terjadi kesalahan saat menghapus penerbit !');

        }
    }

    public function check() 
    {

        $nama_penerbit = str_replace('%20', ' ', $_GET['nama_penerbit']);

        $data = Penerbit::where('nama_penerbit', $nama_penerbit)->exists();

        return response()->json($data);
    }

    protected function store_id() {
        $data = Penerbit::max('id_penerbit');

        if(!empty($data)) {

            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'PNB'.sprintf("%03s", $no_urut);
        } else {
            return 'PNB'.'001';
        }
    }
}
