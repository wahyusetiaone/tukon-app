<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegoPenawaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nego_penawarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penawaran')->unsigned();
            $table->bigInteger('harga_nego')->default(0);
            $table->boolean('disetujui')->nullable();
            $table->timestamps();
            $table->foreign('kode_penawaran')
                ->references('id')->on('penawarans')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nego_penawarans');
    }
}
