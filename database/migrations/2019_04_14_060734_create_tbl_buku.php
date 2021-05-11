<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_buku', function (Blueprint $table) {
            $table->string('id_buku', 20)->primary();
            $table->string('judul_buku', 50);
            $table->string('penulis_buku', 50);

            // relasi ke tbl_kategori
            $table->string('id_kategori', 20);
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('tbl_kategori')
                ->onUpdate('cascade');

            // relasi ke tbl_penerbit
            $table->string('id_penerbit', 20);
            $table->foreign('id_penerbit')
                ->references('id_penerbit')
                ->on('tbl_penerbit')
                ->onUpdate('cascade');

            $table->text('deskripsi_buku');
            $table->integer('jumlah_halaman');
            $table->date('tanggal_terbit');
            $table->string('ISBN', 13)->unique();
            $table->string('bahasa_buku', 30);
            $table->string('format_buku', 30);
            $table->double('berat_buku');
            $table->string('dimensi_buku', 20);
            $table->integer('harga_satuan');
            $table->integer('stok_buku');
            $table->string('foto_buku', 30);
            $table->dateTime('tanggal_masuk')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_buku');
    }
}
