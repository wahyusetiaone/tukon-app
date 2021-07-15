<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi__pembayarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_pembayaran')->default(0);
            $table->text('note_transaksi')->nullable();
            $table->text('path');
            $table->string('status_transaksi', 4)->default("A01");
            $table->text('note_return_transaksi')->nullable();
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
        Schema::dropIfExists('transaksi__pembayarans');
    }
}
