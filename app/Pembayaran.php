<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'tbl_pembayaran';

    protected $fillable = [
    	'id_pesanan', 'id_pengguna', 'bank', 'atas_nama', 'no_rekening', 'foto_bukti', 'status_pembayaran', 'batas_pembayaran', 'selesai'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Pesanan
    public function pesanan()
    {
    	return $this->belongsTo('App\Pesanan', 'id_pesanan');
    }
}
