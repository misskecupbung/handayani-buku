<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Pengguna;
use App\Kategori;
use App\Penerbit;
use App\Buku;
use App\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->exists('email_admin')) {
            $content = [
                'pengguna'              => Pengguna::count(),
                'kategori'              => Kategori::count(),
                'penerbit'              => Penerbit::count(),
                'buku'                  => Buku::where('stok_buku', '>', 0)->count(),
                'pendapatan_sekarang'   => Pesanan::where([
                                                ['tanggal_pesanan', 'LIKE', '%'.explode(' ', Carbon::now())[0].'%'],
                                                ['status_pesanan', '>', '3']
                                            ])->sum('total_bayar'),
                'pendapatan_kemarin'    => Pesanan::where([
                                                ['tanggal_pesanan', 'LIKE', '%'.explode(' ', Carbon::yesterday())[0].'%'],
                                                ['status_pesanan', '>', '3']
                                            ])->sum('total_bayar'),
                'admin'                 => Admin::where('superadmin', 1)->count(),
                'kasir'                 => Admin::where('superadmin', 0)->count(),
            ];
            return view('admin.beranda', $content);
        } else {
            return redirect()->route('login_admin')->withErrors('Harus login terlebih dahulu');
        }
    }
}
