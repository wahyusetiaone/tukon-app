<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPenawaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history__penawarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penawaran')->default(0);
            $table->bigInteger('kode_pin')->default(0);
            $table->integer('keuntungan');
            $table->bigInteger('harga_total');
            $table->string('kode_status',4);
            $table->integer('revisi')->default(0);
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
        Schema::dropIfExists('history__penawarans');
    }
}
