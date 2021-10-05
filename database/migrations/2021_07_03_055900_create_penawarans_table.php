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
            $table->bigInteger('kode_pin')->default(0);
            $table->bigInteger('kode_spd')->default(1);
            $table->integer('keuntungan');
            $table->bigInteger('kode_bpa')->default(0);
            $table->bigInteger('kode_bac')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('harga_total');
            $table->string('kode_status',4);
            $table->timestamps();
            $table->softDeletes();
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
