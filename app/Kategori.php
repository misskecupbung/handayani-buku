<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'tbl_kategori';

    // protected $primaryKey = 'id_kategori';

    protected $fillable = [
    	'id_kategori', 'nama_kategori'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Buku
    public function buku()
    {
    	return $this->hasMany('App\Buku', 'id_kategori');
    }
}
