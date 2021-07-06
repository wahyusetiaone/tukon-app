<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenawaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_pengajuan');
            $table->integer('keuntungan');
            $table->bigInteger('harga-total');
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
        Schema::dropIfExists('penawarans');
    }
}
