<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembayaran', function (Blueprint $table) {
            // $table->string('id_pesanan', 20);

            // // relasi ke tbl_pesanan dengan foreign id_pesanan
            // $table->foreign('id_pesanan')
            //     ->references('id_pesanan')
            //     ->on('tbl_pesanan')
            //     ->onDelete('cascade');

            // $table->string('id_pengguna', 20);

            // // relasi ke tbl_pesanan dengan foreign id_pengguna
            // $table->foreign('id_pengguna')
            //     ->references('id_pengguna')
            //     ->on('tbl_pesanan')
            //     ->onDelete('cascade');

            // $table->string('bank', 20);
            // $table->string('atas_nama', 50);
            // $table->string('no_rekening', 20);
            // $table->string('foto_bukti', 30)->nullable();
            // $table->boolean('status_pembayaran')->default(0);
            // $table->date('batas_pembayaran');
            // $table->dateTime('tanggal_upload')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->boolean('selesai')->default(0);


            $table->string('id_pesanan', 20);

            // relasi ke tbl_pesanan dengan foreign id_pesanan
            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('tbl_pesanan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('id_pengguna', 20);

            // relasi ke tbl_pesanan dengan foreign id_pengguna
            // $table->foreign('id_pengguna')
            //     ->references('id_pengguna')
            //     ->on('tbl_pesanan')
            //     ->onDelete('cascade');

            $table->string('bank', 20);
            $table->string('atas_nama', 50);
            $table->string('no_rekening', 20);
            $table->string('foto_bukti', 30)->nullable();
            $table->boolean('status_pembayaran')->default(0);
            $table->date('batas_pembayaran');
            $table->dateTime('tanggal_upload')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('selesai')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pembayaran');
    }
}
