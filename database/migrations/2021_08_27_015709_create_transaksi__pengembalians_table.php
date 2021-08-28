<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi__pengembalians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_pengembalian_dana');
            $table->string('nomor_rekening');
            $table->string('atas_nama_rekening');
            $table->string('bank');
            $table->string('kode_status', 4)->default('TP01');
            $table->text('catatan_penolakan')->nullable();
            $table->text('path_bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi__pengembalians');
    }
}
