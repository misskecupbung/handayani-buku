<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admin';

    // protected $primaryKey = 'id_admin';
    // public $incrementing = false;

	protected $fillable = [
		'id_admin', 'nama_lengkap', 'email', 'password', 'foto', 'superadmin', 'diblokir'
	];    

	protected $hidden = [
		'password'
	];

	public $timestamps = false;
}
