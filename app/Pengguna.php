<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'tbl_pengguna';

    protected $fillable =
    [
    	'id_pengguna', 'email', 'password', 'nama_lengkap', 'jenis_kelamin', 'alamat_rumah', 'no_telepon', 'diblokir', 'foto_pengguna'
    ];

    protected $hidden =
    [
    	'password'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Pesanan
    public function pesanan()
    {
        return $this->hasMany('App\Pesanan', 'id_pengguna');
    }

    // Membuat relasi dengan Keranjang
    public function keranjang()
    {
    	return $this->hasMany('App\Keranjang', 'id_pengguna');
    }
}
