<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblKeranjang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_keranjang', function (Blueprint $table) {
            $table->string('id_pengguna', 20);

            // relasi ke tbl_pengguna
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('tbl_pengguna')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('id_buku', 20);

            // relasi ke tbl_buku
            $table->foreign('id_buku')
                ->references('id_buku')
                ->on('tbl_buku')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('jumlah_beli');
            $table->double('subtotal_biaya');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_keranjang');
    }
}
