<?php

namespace App\Http\Controllers\Pengguna\Akun;

use App\Pengguna;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class GantiPasswordController extends Controller
{
    public function index(Request $request) {
        if(session()->has('email_pengguna')) {
            return view('pengguna.akun.ganti_password');
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function update(Request $request) {
        if (session()->has('email_pengguna') && $request->has('simpan')) {
            $validasi = Validator::make($request->all(), [
                'password_lama'                 => 'required|alpha_num|max:50',
                'password_baru'                 => 'required|alpha_num|max:50|confirmed',
                'password_baru_confirmation'    => 'required|alpha_num|max:50'
            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = Pengguna::where('id_pengguna', session('id_pengguna'))->first();

            if (Hash::check($request->input('password_lama'), $data->password) && !Hash::check($request->input('password_baru'), $data->password)) {

                Pengguna::where('id_pengguna', session('id_pengguna'))->update([
                    'password'  => Hash::make($request->password_baru),
                ]);

                $request->session()->forget([
                    'id_pengguna',
                    'email_pengguna',
                    'nama_lengkap',
                ]);

                return redirect()->route('login')->with('success', 'Silahkan login kembali !');
            } else {
                return back()->withErrors('Password lama tidak cocok atau password baru sama dengan password lama !');
            }
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }
}
