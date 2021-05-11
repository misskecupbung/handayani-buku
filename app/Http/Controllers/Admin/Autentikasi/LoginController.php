<?php

namespace App\Http\Controllers\Admin\Autentikasi;

use App\Admin;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->session()->exists('email')) {

            return view('admin.autentikasi.login');
        } else {
            return redirect()->route('beranda_admin');
        }
    }

    public function login(Request $request)
    {
        if ($request->has('simpan')) {
            $validasi = Validator::make($request->all(), [
                'email'     => 'required|email',
                'password'  => 'required|alpha_num'
            ]);

            if ($validasi->fails()) {
                return redirect()->route('login_admin')->with('fail', 'Email atau Password Salah !');
            }

            $data = Admin::where('email', $request->input('email'))->first();

            if (!empty($data) && Hash::check($request->input('password'), $data->password)) {
                if ($data->diblokir) {
                    return redirect()->route('login_admin')->with('fail', 'Akun anda telah di blokir !');
                } else {
                    session([
                        'id_admin'      => $data->id_admin,
                        'email_admin'   => $data->email,
                        'nama_admin'    => $data->nama_lengkap,
                        'foto_admin'    => $data->foto,
                        'superadmin'    => $data->superadmin
                    ]);
                    return redirect()->route('beranda_admin');
                }
            } else {
                return redirect()->route('login_admin')->with('fail', 'Email atau Password salah !');
            }
        } else {
            return back()->withErrors('Terjadi kesalahan saat login !');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'id_admin',
            'email_admin',
            'nama_admin',
            'foto_admin',
            'superadmin'
        ]);

        return redirect()->route('login_admin')->with('success', 'Anda telah logout !');
    }
}
