<?php

namespace App\Http\Controllers\Admin\Superadmin;

use App\Admin;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->exists('email_admin') && session('superadmin') == true) {

            $data = Admin::all();

            return view('admin.superadmin.admin.admin', ['data_admin' => $data]);

        } else {
            return redirect()->route('beranda_admin');
        }
    }

    public function store(Request $request)
    {
        if ($request->has('simpan') && session('superadmin') == true) {

            $validasi = Validator::make($request->all(), [
                'nama_lengkap'  => 'required|regex:/^[a-zA-Z\s]*$/|max:40',
                'email'         => 'required|email|unique:tbl_admin|max:30',
                'password'      => 'required|alpha_num|max:18',
                'foto'          => 'nullable|image|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if ($request->hasFile('foto')) {

                $id_admin = $this->store_id();

                $extension = $request->file('foto')->getClientOriginalExtension();

                $foto_admin = Storage::putFileAs(
                    'public/avatars/admin/',
                    $request->file('foto'), $id_admin.'.'.$extension
                );

            }

            Admin::create([
                'id_admin'      => $this->store_id(),
                'nama_lengkap'  => $request->input('nama_lengkap'),
                'email'         => $request->input('email'),
                'password'      => Hash::make($request->input('password'), [
                                        'memory' => 1024,
                                        'time' => 2,
                                        'threads' => 2,
                                    ]),
                'foto'          => $request->hasFile('foto') ? basename($foto_admin) : 'default.png',
                'tanggal_bergabung' =>  Carbon::now(),
            ]);

            return redirect()->route('superadmin_admin')->with('success', 'Akun baru berhasil di buat !');

        } else  {

            return back()->withErrors('Terjadi kesalahan saat menyimpan data !');

        }
    }

    public function blokir_admin(Request $request, $id_admin) {

        if (session('superadmin') == true) {

            $data = Admin::where('id_admin', $id_admin);

            $data->update([ 'diblokir' => $data->first()->diblokir ? 0 : 1]);

            $data->first()->diblokir == 1 ? $status = 'Akun berhasil di blokir !' : $status = 'Status blokir akun berhasil di cabut';

            return redirect()->route('superadmin_admin')->with('success', '' .$status);

        } else  {

            return back()->withErrors('Terjadi kesalahan saat memblokir akun !');

        }

    }


    public function get(Request $request, $id_admin)
    {
        $data = Admin::where('id_admin', $id_admin)->first();

        return response()->json($data);
    }

    public function update(Request $request, $id_admin)
    {
        if ($request->has('simpan') && session('superadmin') == true) {

            $validasi = Validator::make($request->all(), [
                'superadmin'  => 'required|boolean',
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            Admin::where('id_admin', $id_admin)->update([
                'superadmin' => $request->input('superadmin'),
            ]);

            return redirect()->route('superadmin_admin')->with('success', 'Status akun berhasil di ubah !');

        } else  {

            return back()->withErrors('Terjadi kesalahan saat mengubah akun !');

        }
    }

    public function destroy(Request $request, $id_admin)
    {
        if ($request->has('simpan') && session('superadmin') == true) {

            $data = Admin::where('id_admin', $id_admin);

            if($data->first()->foto != 'default.png') {

                Storage::delete('public/avatars/admin/'.$data->first()->foto);

            }

            $data->delete();

            return redirect()->route('superadmin_admin')->with('success', 'Akun berhasil di hapus !');

        } else  {

            return back()->withErrors('Terjadi kesalahan saat menghapus akun !');

        }
    }

    protected function store_id() 
    {

        $data = Admin::max('id_admin');

        if(!empty($data)) {

            $no_urut = substr($data, 3, 3);

            $no_urut++;

            return 'ADM'.sprintf("%03s", $no_urut);

        } else {

            return 'ADM'.'001';

        }
    }
}
