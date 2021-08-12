<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPenarikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi__penarikans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penarikan');
            $table->bigInteger('kode_persentase_penarikan');
            $table->bigInteger('penarikan');
            $table->string('kode_status',4);
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
        Schema::dropIfExists('history__penarikans');
    }
}
