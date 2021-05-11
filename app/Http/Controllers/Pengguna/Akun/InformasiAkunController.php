<?php

namespace App\Http\Controllers\Pengguna\Akun;

use App\Pengguna;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class InformasiAkunController extends Controller
{
    public function index(Request $request){
        if (session()->has('email_pengguna')) {
            $data = Pengguna::where('id_pengguna', session('id_pengguna'))->first();

            return view('pengguna.akun.edit_informasi_akun', ['data_informasi' => $data]);
        } else {
            return redirect()->route('login')->withErrors('Harus login terlebih dahulu !');
        }
    }

    public function update(Request $request){
        if (session()->has('email_pengguna') && $request->has('simpan')) {
            $validasi = Validator::make($request->all(),[
                'nama_lengkap'  =>  'required|string|max:50',
                'jenis_kelamin' =>  'required|alpha',
                'alamat_rumah'  =>  'required|string',
                'email'         =>  'required|email|max:30',
                'no_telepon'    =>  'required|regex:/^[0-9\s\-\+]*$/|max:20',
                'password'      =>  'required|alpha_num|max:50',
                'foto_pengguna' =>  'nullable|image|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            $data = Pengguna::where('id_pengguna', session('id_pengguna'))->first();

            if ($request->hasFile('foto_pengguna')) {

                Storage::delete('public/avatars/pengguna/'.$data->foto_pengguna);

                $extension = $request->file('foto_pengguna')->getClientOriginalExtension();

                $save_foto = Storage::putFileAs(
                    'public/avatars/pengguna/',
                    $request->file('foto_pengguna'), session('id_pengguna').'.'.$extension
                );

                $foto_pengguna = basename($save_foto);
            }

            $data = Pengguna::where('id_pengguna', session('id_pengguna'));

            if ($data->exists() && Hash::check($request->input('password'), $data->first()->password)) {

                $data->update([
                    'email'         => $request->input('email'),
                    'nama_lengkap'  => $request->input('nama_lengkap'),
                    'jenis_kelamin' => $request->input('jenis_kelamin'),
                    'alamat_rumah'  => $request->input('alamat_rumah'),
                    'no_telepon'    => $request->input('no_telepon'),
                    'foto_pengguna' => $request->hasFile('foto_pengguna') ? $foto_pengguna : $data->foto_pengguna,
                ]);

                return redirect()->route('info_akun')->with('success', 'Informasi Akun Berhasil Di Simpan');

            } else {
                return redirect()->route('info_akun')->withErrors('Password konfirmasi salah !');
            }
        }
    }
}
