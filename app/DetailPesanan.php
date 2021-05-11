<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'tbl_detail_pesanan';

    protected $fillable = [
    	'id_pesanan', 'id_buku', 'jumlah_beli', 'subtotal_berat', 'subtotal_biaya'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Pesanan
    public function pesanan()
    {
    	return $this->belongsTo('App\Pesanan', 'id_pesanan');
    }

    // Membuat relasi dengan Buku
    public function buku()
    {
    	return $this->belongsTo('App\Buku', 'id_buku');
    }
}
