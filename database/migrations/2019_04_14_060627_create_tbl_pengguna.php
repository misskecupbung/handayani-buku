<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPengguna extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pengguna', function (Blueprint $table) {
            $table->string('id_pengguna', 20)->primary();
            $table->string('email', 30)->unique();
            $table->string('password', 100);
            $table->string('nama_lengkap', 50);
            $table->string('jenis_kelamin', 15)->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->boolean('diblokir')->default(0);
            $table->string('foto_pengguna', 30)->nullable();
            $table->dateTime('tanggal_bergabung')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pengguna');
    }
}
