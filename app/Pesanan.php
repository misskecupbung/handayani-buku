<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'tbl_pesanan';

    // protected $primaryKey = 'id_pesanan';

    protected $fillable = 
    [
    	'id_pesanan', 'id_pengguna', 'nama_penerima', 'no_telepon', 'alamat_tujuan', 'keterangan', 'layanan', 'ongkos_kirim', 'total_bayar', 'no_resi', 'status_pesanan', 'dibatalkan', 'tanggal_dikirim', 'tanggal_dikirim', 'tanggal_diterima'
    ];

    public $timestamps = false;

    // Membuat relasi dengan Pengguna
    public function pengguna() 
    {
        return $this->belongsTo('App\Pengguna', 'id_pengguna');
    }

    // Membuat relasi dengan DetailPesanan
    public function detailPesanan()
    {
    	return $this->hasMany('App\DetailPesanan', 'id_pesanan');
    }

    // Membuat relasi dengan Pembayaran
    public function pembayaran()
    {
    	return $this->hasOne('App\Pembayaran', 'id_pesanan');
    }

    // Membuat relasi dengan Invoice
    public function invoice()
    {
    	return $this->hasOne('App\Invoice', 'id_pesanan');
    }
}
