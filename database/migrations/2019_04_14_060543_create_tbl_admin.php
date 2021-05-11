<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->string('id_admin', 20)->primary();
            $table->string('nama_lengkap', 50);
            $table->string('email', 30)->unique();
            $table->string('password', 100);
            $table->string('foto', 30)->nullable();
            $table->boolean('superadmin')->default(0);
            $table->boolean('diblokir')->default(0);
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
        Schema::dropIfExists('tbl_admin');
    }
}
