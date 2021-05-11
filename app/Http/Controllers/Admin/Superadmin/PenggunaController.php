<?php

namespace App\Http\Controllers\Admin\Superadmin;

use Validator;
use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->exists('email_admin') && session('superadmin') == true) {
            $data = Pengguna::all();
            return view('admin.superadmin.pengguna.pengguna', ['data_pengguna' => $data]);
        } else {
            return redirect()->route('beranda_admin');
        }
    }

    public function blokir_pengguna(Request $request, $id_pengguna) {

        if (session('superadmin') == true) {

            $data = Pengguna::where('id_pengguna', $id_pengguna);

            $data->update([ 'diblokir' => $data->first()->diblokir ? 0 : 1]);

            $data->first()->diblokir == 1 ? $status = 'Akun berhasil di blokir !' : $status = 'Status blokir akun berhasil di cabut';

            return redirect()->route('superadmin_pengguna')->with('success', '' .$status);

        } else  {

            return back()->withErrors('Terjadi kesalahan saat memblokir akun !');

        }

    }

    public function get(Request $request, $id_pengguna)
    {
         if($request->session()->exists('email_admin') && session('superadmin') == true) {

            $data = Pengguna::where('id_pengguna', $id_pengguna)
                ->first();

            return response()->json($data);

        } else {

            return redirect()->route('beranda_admin');

        }
    }
}
