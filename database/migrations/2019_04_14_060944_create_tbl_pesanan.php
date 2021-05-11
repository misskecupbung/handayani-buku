<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 20)->primary();
            $table->string('id_pengguna', 20);

            // relasi ke tbl_pengguna
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('tbl_pengguna')
                ->onUpdate('cascade');

            $table->string('nama_penerima', 50);
            $table->string('no_telepon', 20);
            $table->text('alamat_tujuan');
            $table->text('keterangan')->nullable();
            $table->string('layanan', 5);
            $table->double('ongkos_kirim');
            $table->double('total_bayar');
            $table->string('no_resi', 30)->nullable();
            $table->tinyInteger('status_pesanan')->default(0);
            $table->boolean('dibatalkan')->default(0);
            $table->dateTime('tanggal_dikirim')->nullable();
            $table->dateTime('tanggal_diterima')->nullable();
            $table->dateTime('tanggal_pesanan')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // buat tbl_detail_pesanan
        Schema::create('tbl_detail_pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 20);

            // relasi ke tbl_pesanan
            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('tbl_pesanan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('id_buku', 20);

            // relasi ke tbl_buku
            $table->foreign('id_buku')
                ->references('id_buku')
                ->on('tbl_buku')
                ->onUpdate('cascade');

            $table->integer('jumlah_beli');
            $table->double('subtotal_berat');
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
        Schema::dropIfExists('tbl_pesanan');
        Schema::dropIfExists('tbl_detail_pesanan');
    }
}
