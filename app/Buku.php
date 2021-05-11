<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'tbl_buku';

    // protected $primaryKey = 'id_buku';

    protected $fillable = [
    	'id_buku', 'judul_buku', 'penulis_buku', 'id_kategori', 'id_penerbit', 'deskripsi_buku', 'jumlah_halaman', 'tanggal_terbit', 'ISBN', 'bahasa_buku', 'format_buku', 'berat_buku', 'dimensi_buku', 'harga_satuan', 'stok_buku', 'foto_buku', 'sampel_buku'
	];

    public $timestamps = false;

    // Membuat relasi dengan Kategori
    public function kategori()
    {
    	return $this->belongsTo('App\Kategori', 'id_kategori');
    }

    // Membuat relasi dengan Penerbit
    public function penerbit()
    {
    	return $this->belongsTo('App\Penerbit', 'id_penerbit');
    }

    // Membuat relasi dengan Keranjang
    public function keranjang()
    {
    	return $this->hasMany('App\Keranjang', 'id_buku');
    }

    // Membuat relasi dengan DetailPesanan
    public function detailPesanan()
    {
    	return $this->hasMany('App\DetailPesanan', 'id_buku');
    }
}
