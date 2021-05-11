<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'tbl_keranjang';

    protected $fillable = [
    	'id_pengguna', 'id_buku', 'jumlah_beli', 'subtotal_biaya'
    ];

    public $timestamps = false;

    // Membuat felasi dengan Pengguna
    public function pengguna()
    {
    	return $this->belongsTo('App\Pengguna', 'id_pengguna');
    }

    // Membuat relasi dengan Buku
    public function buku()
    {
    	return $this->belongsTo('App\Buku', 'id_buku');
    }
}
