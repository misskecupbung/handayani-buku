<?php

namespace App\Http\Controllers\Pengguna\Autentikasi;

use App\Pengguna;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;

class RegisterController extends Controller
{
    public function index(Request $request) {
        (!$request->session()->exists('email') ? true : redirect()->route('beranda'));

        return view('pengguna.autentikasi.register');
    }

    public function sendMessage()
    {
        return view('message');
    }

    public function register(Request $request) {
        if ($request->input('simpan')) {
            $validasi = Validator::make($request->all(), [
                'nama_lengkap'          =>  'required|regex:/^[a-zA-Z\s]*$/|max:50',
                'jenis_kelamin'         =>  'required|alpha',
                'alamat_rumah'          =>  'required',
                'no_telepon'            =>  'required',
                'email'                 =>  'required|email|unique:tbl_pengguna|max:30',
                'password'              =>  'required|alpha_num|max:18|confirmed',
                'password_confirmation' =>  'required|alpha_num|max:18',
                'foto_pengguna'         =>  'nullable|image|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            if ($request->hasFile('foto_pengguna')) {

                $id_pengguna = $this->store_id();

                $extension = $request->file('foto_pengguna')->getClientOriginalExtension();

                $foto_pengguna = Storage::putFileAs(
                    'public/avatars/pengguna/',
                    $request->file('foto_pengguna'), $id_pengguna.'.'.$extension
                );

            }

            Pengguna::insert([
                'id_pengguna'       =>  $this->store_id(),
                'email'             =>  $request->input('email'),
                'password'          =>  Hash::make($request->input('password')),
                'nama_lengkap'      =>  $request->input('nama_lengkap'),
                'jenis_kelamin'     =>  $request->input('jenis_kelamin'),
                'alamat_rumah'      =>  $request->input('alamat_rumah'),
                'no_telepon'        =>  $request->input('no_telepon'),
                'foto_pengguna'     =>  $request->hasFile('foto_pengguna') ? basename($foto_pengguna) : 'default.png',
                'tanggal_bergabung' =>  Carbon::now(),
            ]);

            $notif = "<b>[REGISTRASI] Pengguna baru terdaftar</b>\n\n"
                . "<b>ID Pengguna : </b>" . "$id_pengguna\n"
                . "<b>Nama Pengguna : </b>" . "$request->nama_lengkap\n"
                . "<b>Email Pengguna : </b>" . "$request->email\n"
                . "<b>Alamat Pengguna : </b>" . "$request->alamat_rumah\n"
                . "<b>No Telepon : </b>" . "$request->no_telepon\n"
                . "<b>Jenis Kelamin : </b>" . "$request->jenis_kelamin\n";

            Telegram::sendMessage([
                'chat_id'       => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
                'parse_mode'    => 'HTML',
                'text'          => $notif
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil !');
        } else {
            return back()->withErrors('Terjadi kesalahan saat mendaftar akun !');
        }
    }

    protected function store_id() {
        $data = Pengguna::max('id_pengguna');

        if (!empty($data)) {
            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'PGN'.sprintf("%03s", $no_urut);
        } else {
            return 'PGN'.'001';
        }

    }
}
