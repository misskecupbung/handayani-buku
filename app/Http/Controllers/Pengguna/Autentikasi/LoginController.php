<?php

namespace App\Http\Controllers\Pengguna\Autentikasi;

use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Telegram\Bot\Laravel\Facades\Telegram;

class LoginController extends Controller
{
    public function index(Request $request) {
        (!$request->session()->exists('email_pengguna') ? true : redirect()->route('beranda'));

        return view('pengguna.autentikasi.login');
    }

    public function sendMessage()
    {
        return view('message');
    }

    public function login(Request $request) {
        if ($request->has('simpan')) {

            $data = Pengguna::where('email', $request->input('email'))->first();

            if (!empty($data) && Hash::check($request->input('password'), $data->password)) {
                if ($data->diblokir) {
                    return back()->withErrors('Akun anda telah di blokir !');
                }else {
                    session([
                        'id_pengguna'       => $data->id_pengguna,
                        'email_pengguna'    => $data->email,
                        'nama_lengkap'      => $data->nama_lengkap,
                        'foto_pengguna'     => $data->foto_pengguna,
                    ]);

                    $notif = "<b>[LOGIN] Pengguna Login</b>\n\n"
                        . "<b>Email Pengguna : </b>" . "$request->email";

                    Telegram::sendMessage([
                        'chat_id'       => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
                        'parse_mode'    => 'HTML',
                        'text'          => $notif
                    ]);
                    return redirect()->route('beranda');
                }
            } else {
                return back()->withErrors('Email atau Password salah !');
            }

        } else {
            return back()->withErrors('Terjadi kesalahan saat masuk !');
        }
    }

    public function logout(Request $request) {
        if ($request->session()->exists('email_pengguna')) {
            $request->session()->forget([
                'id_pengguna',
                'email_pengguna',
                'nama_lengkap',
                'foto_pengguna',
            ]);

            return redirect()->route('beranda');
        }
    }
}
