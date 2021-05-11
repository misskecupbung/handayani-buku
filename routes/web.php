<?php

use Illuminate\Http\Request;
use App\Kategori;
use App\Keranjang;
use App\Pesanan;
use App\Pembayaran;
/**
 * --------------------------------------------------------------------------
 * ROUTE HALAMAN PENGGUNA
 * --------------------------------------------------------------------------
 *
 */

/** Telegram bot */
    Route::post('/send-message', 'TelegramBotController@storeMessage');

/** Halaman Beranda Utama */

# METHOD GET
Route::get('/', 'Pengguna\BerandaController@index')->name('beranda');
Route::get('get_kategori', function() {

    $kategori = [];

    foreach (Kategori::select('nama_kategori')->get() as $key => $value) {
        $kategori[] = $value->nama_kategori;
    }

    return response()->json($kategori);

})->name('get_kategori');
Route::get('get_data_counter', function() {

    $pembayaran = Pembayaran::where([
        ['id_pengguna', session('id_pengguna')],
    ]);

    $list = [
        'keranjang' => Keranjang::where('id_pengguna', session('id_pengguna'))->count(),
        'pesanan'   => Pesanan::where([['id_pengguna', '=', session('id_pengguna')], ['status_pesanan', '<=', 4]])->count(),
        'pembayaran'=> !empty($pembayaran->first()->foto_bukti) && $pembayaran->first()->selesai != 1  ? $pembayaran->count() : '0',
    ];

    return response()->json($list);

})->name('data_counter');



# METHOD POST
Route::post('hubungi', 'Pengguna\EmailController@kontak')->name('hubungi_kami');


/** Halaman Autentikasi Pengguna */

# METHOD GET
Route::get('masuk', 'Pengguna\Autentikasi\LoginController@index')->name('login');
Route::get('daftar', 'Pengguna\Autentikasi\RegisterController@index')->name('register');
Route::get('keluar', 'Pengguna\Autentikasi\LoginController@logout')->name('logout');

# METHOD POST
Route::post('masuk', 'Pengguna\Autentikasi\LoginController@login')->name('proses_login');
Route::post('daftar', 'Pengguna\Autentikasi\RegisterController@register')->name('proses_regis');


/** Halaman Lupa Password Pengguna */

# METHOD GET
Route::get('lupa-password', 'Pengguna\Autentikasi\ResetPasswordController@index')->name('lupa_password');
Route::get('lupa-password/reset', 'Pengguna\Autentikasi\ResetPasswordController@reset_page')->name('reset_page');

# METHOD POST
Route::post('lupa-password/send', 'Pengguna\Autentikasi\ResetPasswordController@send_token')->name('send_token');

# METHOD PUT
Route::put('lupa-password/proses', 'Pengguna\Autentikasi\ResetPasswordController@reset_password')->name('proses_password');


/** Halaman Akun Pengguna */

# METHOD GET
Route::get('info_akun', 'Pengguna\Akun\AkunController@index')->name('info_akun');
Route::get('info_akun/edit', 'Pengguna\Akun\InformasiAkunController@index')->name('edit_info_akun');
Route::get('info_akun/ganti_password', 'Pengguna\Akun\GantiPasswordController@index')->name('ganti_password');

# METHOD PUT
Route::put('info_akun/edit', 'Pengguna\Akun\InformasiAkunController@update')->name('simpan_info_akun');
Route::put('info_akun/ganti_password', 'Pengguna\Akun\GantiPasswordController@update')->name('simpan_password');


/** Halaman Buku*/

# METHOD GET
Route::get('buku', 'Pengguna\Buku\BukuController@index')->name('buku');
Route::get('buku/detail/{id_buku}', 'Pengguna\Buku\DetailBukuController@index')->name('detail_buku');

# METHOD POST
Route::post('buku/tambah-keranjang/{id_buku}', 'Pengguna\Buku\DetailBukuController@keranjang')->name('tambah_keranjang');




/** Halaman Keranjang */

# METHOD GET
Route::get('keranjang', 'Pengguna\Keranjang\KeranjangController@index')->name('keranjang');

# METHOD PUT
Route::put('keranjang/update/{id_buku}', 'Pengguna\Keranjang\KeranjangController@update')->name('update_keranjang');

# METHOD DELETE
Route::delete('keranjang/delete/{id_buku}', 'Pengguna\Keranjang\KeranjangController@destroy')->name('delete_keranjang');

# METHOD POST
Route::post('keranjang/method', 'Pengguna\Keranjang\KeranjangController@method')->name('checkout_method');


/** Halaman Checkout */

# METHOD GET
Route::get('checkout/{method}', 'Pengguna\Keranjang\CheckoutController@index')->name('checkout_keranjang');
Route::get('selesai', function(){
    return view('pengguna.keranjang.terimakasih');
});
Route::get('get_provinsi', function() {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "UTF-8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "key: fb8588b3e8558c1ebdf16c4c93997b09"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});
Route::get('get_kota', function(Request $request) {
    $curl = curl_init();

    $id = $request->input('provinsi');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "UTF-8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "key: fb8588b3e8558c1ebdf16c4c93997b09"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});

# METHOD POST
Route::post('get_cost', function(Request $request) {
    $curl = curl_init();

    $id_city     = $request->input('kota');
    $berat       = $request->input('berat');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=135&destination=".$id_city."&weight=".$berat."&courier=jne",
        CURLOPT_HTTPHEADER => [
            'content-type: application/x-www-form-urlencoded',
            "key: fb8588b3e8558c1ebdf16c4c93997b09"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});
Route::post('checkout', 'Pengguna\Keranjang\CheckoutController@store')->name('save_checkout');


/** Halaman Pesanan*/

# METHOD GET
Route::get('pesanan', 'Pengguna\Pesanan\PesananController@index')->name('pesanan');
Route::get('pesanan/detail_pesanan/{id_pesanan}', 'Pengguna\Pesanan\PesananController@detail_pesanan')->name('detail_pesanan');
Route::get('pesanan/riwayat', 'Pengguna\Pesanan\PesananController@riwayat_pesanan')->name('riwayat_pesanan');

# METHOD put
Route::put('pesanan/dibatalkan/{id_pesanan}', 'Pengguna\Pesanan\PesananController@dibatalkan')->name('pesanan_dibatalkan');
Route::put('pesanan/konfirmasi/{id_pesanan}', 'Pengguna\Pesanan\PesananController@konfirmasi_pesanan')->name('konfirmasi_pesanan');



/** Halaman Pembayaran*/

# METHOD GET
Route::get('pembayaran', 'Pengguna\Pesanan\PembayaranController@index')->name('pembayaran');
Route::get('pembayaran/upload-bukti/{id_pesanan}', 'Pengguna\Pesanan\PembayaranController@upload_bukti')->name('upload_bukti');


# METHOD POST
Route::put('pembayaran/upload-bukti/{id_pesanan}/save', 'Pengguna\Pesanan\PembayaranController@save_bukti')->name('save_bukti');


/** Halaman Invoice*/

Route::get('invoice/{id_invoice}', 'Pengguna\Pesanan\PesananController@invoice')->name('invoice');



/**
 * --------------------------------------------------------------------------
 * ROUTE HALAMAN ADMIN
 * --------------------------------------------------------------------------
 *
 */
Route::group(['prefix' => 'admin'], function(){

    /** Halaman Beranda Utama */

    # METHOD GET
    Route::get('/', 'Admin\BerandaController@index')->name('beranda_admin');
    Route::get('sidebar_counter', function() {

        $table = ['buku', 'kategori', 'penerbit', 'pengguna', 'admin', 'pesanan', 'pembayaran', 'pengiriman'];

        $data = [];

        foreach($table as $key) {

            if ($key == 'pengiriman') {

                $data[] = DB::table('tbl_pesanan')->select('id_pesanan')
                    ->where('status_pesanan', 3)->count();

            } else if ($key == 'pesanan') {

                $data[] = DB::table('tbl_pesanan')->select('id_pesanan')
                    ->whereBetween('status_pesanan', [1, 2])->count();

            } else if($key == 'pembayaran') {

                $data[] = DB::table('tbl_pembayaran')->select('id_pesanan')
                    ->where('selesai', 0)->count();

            } else {

                $data[] = DB::table('tbl_'.$key)->count();

            }
        }

        return response()->json($data);

    }); // AJAX



    /** Halaman Beranda Utama */

    # METHOD GET
    Route::get('profile/{id_admin}', 'Admin\ProfileController@index')->name('profile_admin');

    # METHOD PUT
    Route::put('profile/ganti_password/{id_admin}', 'Admin\ProfileController@ganti_password')->name('ganti_password_admin');



    /** Halaman Autentikasi */

    # METHOD GET
    Route::get('login', 'Admin\Autentikasi\LoginController@index')->name('login_admin');
    Route::get('logout', 'Admin\Autentikasi\LoginController@logout')->name('logout_admin');

    # METHOD POST
    Route::post('login', 'Admin\Autentikasi\LoginController@login')->name('proses_login_admin');



    /** Halaman Buku */

    # METHOD GET
    Route::get('buku', 'Admin\Buku\BukuController@index')->name('list_buku');
    Route::get('get_buku/{id_buku}', 'Admin\Buku\BukuController@get');

    # METHOD POST
    Route::post('buku', 'Admin\Buku\BukuController@store')->name('tambah_buku');

    # METHOD PUT
    Route::put('edit_buku/{id_buku}', 'Admin\Buku\BukuController@update');

    # METHOD DELETE
    Route::delete('hapus_buku/{id_buku}', 'Admin\Buku\BukuController@destroy');



    /** Halaman Kategori */

    # METHOD GET
    Route::get('kategori', 'Admin\Buku\KategoriController@index')->name('kategori_buku');
    Route::get('check_kategori', 'Admin\Buku\KategoriController@check'); // AJAX

    # METHOD POST
    Route::post('kategori', 'Admin\Buku\KategoriController@store')->name('tambah_kategori');

    # METHOD PUT
    Route::put('edit_kategori/{id_kategori}', 'Admin\Buku\KategoriController@update');

    # METHOD DELETE
    Route::delete('hapus_kategori/{id_kategori}', 'Admin\Buku\KategoriController@destroy');



    /** Halaman Penerbit */

    # METHOD GET
    Route::get('penerbit', 'Admin\Buku\PenerbitController@index')->name('penerbit_buku');
    Route::get('check_penerbit', 'Admin\Buku\PenerbitController@check'); // AJAX

    # METHOD POST
    Route::post('tambah_penerbit', 'Admin\Buku\PenerbitController@store')->name('tambah_penerbit');

    # METHOD PUT
    Route::put('edit_penerbit/{id_penerbit}', 'Admin\Buku\PenerbitController@update');

    # METHOD DELETE
    Route::delete('hapus_penerbit/{id_penerbit}', 'Admin\Buku\PenerbitController@destroy');



    /** Halaman Superadmin : Admin */

    # METHOD GET
    Route::get('superadmin/admin', 'Admin\Superadmin\AdminController@index')->name('superadmin_admin');
    Route::get('superadmin/blokir_admin/{id_admin}', 'Admin\Superadmin\AdminController@blokir_admin')->name('blokir_admin');
    Route::get('superadmin/get_admin/{id_admin}', 'Admin\Superadmin\AdminController@get'); // AJAX

    # METHOD POST
    Route::post('superadmin/tambah_admin', 'Admin\Superadmin\AdminController@store')->name('tambah_admin');

    # METHOD PUT
    Route::put('superadmin/edit_admin/}id_admin}', 'Admin\Superadmin\AdminController@edit_admin');
    Route::put('superadmin/ubah_status_admin/{id_admin}', 'Admin\Superadmin\AdminController@update');

    # METHOD DELETE
    Route::delete('superadmin/hapus_admin/{id_admin}', 'Admin\Superadmin\AdminController@destroy');



    /** Halaman Superadmin : Pengguna */

    # METHOD GET
    Route::get('superadmin/pengguna', 'Admin\Superadmin\PenggunaController@index')->name('superadmin_pengguna');
    Route::get('superadmin/blokir_pengguna/{id_pengguna}', 'Admin\Superadmin\PenggunaController@blokir_pengguna')->name('blokir_pengguna');
    Route::get('superadmin/get_pengguna/{id_pengguna}', 'Admin\Superadmin\PenggunaController@get'); // AJAX

    # METHOD DELETE
    Route::delete('superadmin/hapus_pengguna/{id_pengguna}', 'Admin\Superadmin\PenggunaController@hapus_pengguna');



    /** Halaman Transaksi : Pembayaran */

    # METHOD GET
    Route::get('transaksi/pembayaran', 'Admin\Transaksi\PembayaranController@index')->name('pembayaran_admin');
    Route::get('transaksi/get_pembayaran/{id_pesanan}', 'Admin\Transaksi\PembayaranController@get'); // AJAX

    # METHOD PUT
    Route::put('transaksi/pembayaran/status/{id_pesanan}', 'Admin\Transaksi\PembayaranController@update')->name('rubah_status_pembayaran');



    /** Halaman Transaksi : Pesanan */

    # METHOD GET
    Route::get('transaksi/pesanan', 'Admin\Transaksi\PesananController@index')->name('pesanan_admin');
    Route::get('transaksi/pesanan/detail/{id_pesanan}', 'Admin\Transaksi\PesananController@detail_pesanan')->name('detail_pesanan_admin');
    Route::get('transaksi/get_penerima/{id_pesanan}', 'Admin\Transaksi\PesananController@get_info_penerima'); // AJAX

    # METHOD PUT
    Route::put('transaksi/proses_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@proses_pesanan');
    Route::put('transaksi/kirim_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@kirim_pesanan');
    Route::put('transaksi/batalkan_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@batalkan_pesanan');
    Route::put('transaksi/edit_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@edit_pesanan');

    # METHOD DELETE
    Route::delete('transaksi/hapus_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@hapus_pesanan');

    /** Halaman Transaksi : Pengiriman */

    # METHOD GET
    Route::get('transaksi/pengiriman', 'Admin\Transaksi\PengirimanController@index')->name('pengiriman_admin');

    # METHOD PUT
    Route::put('transaksi/selesai/{id_pesanan}', 'Admin\Transaksi\PengirimanController@selesai');
    Route::put('transaksi/dibatalkan/{id_pesanan}', 'Admin\Transaksi\PengirimanController@batalkan_pesanan');


    /** Halaman Laporan : Transaksi */

    # METHOD GET
    Route::get('laporan/transaksi', 'Admin\Laporan\TransaksiController@index')->name('laporan_transaksi');

    # METHOD POST
    Route::post('laporan/transaksi/print', 'Admin\Laporan\TransaksiController@print_transaksi')->name('print_transaksi');

});
