<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'tbl_penerbit';

    // protected $primaryKey = 'id_pengguna';

    protected $fillable = [
    	'id_penerbit', 'nama_penerbit'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Buku
    public function buku()
    {
    	return $this->hasMany('App\Buku', 'id_penerbit');
    }
}
