<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_invoice', function (Blueprint $table) {
            $table->string('id_invoice', 20)->primary();
            $table->string('id_pesanan', 20);
            $table->string('id_pengguna', 20);
            
            $table->dateTime('tanggal_dibuat')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_invoice');
    }
}
