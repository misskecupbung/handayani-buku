<?php

namespace App\Http\Controllers\Pengguna\Akun;

use App\Pengguna;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AkunController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('email_pengguna')) {

            $data = Pengguna::where('id_pengguna', session('id_pengguna'))->first();

            return view('pengguna.akun.akunpengguna', ['data_pengguna' => $data]);

        } else {
            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');
        }
    }
}
