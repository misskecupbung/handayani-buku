<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tbl_invoice';

    // protected primaryKey = 'id_invoice';

    protected $fillable = [
    	'id_invoice', 'id_pesanan', 'id_pengguna'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Pesanan
    public function pesanan()
    {
    	return $this->belongsTo('App\Pesanan', 'id_pesanan');
    }
}
