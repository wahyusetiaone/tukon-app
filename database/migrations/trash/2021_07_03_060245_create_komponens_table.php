<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penawaran');
            $table->string('nama_komponen', 255);
            $table->bigInteger('harga');
            $table->string('merk_type', 50);
            $table->string('spesifikasi_teknis', 80);
            $table->string('satuan', 20);
            $table->bigInteger('total_unit');
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
        Schema::dropIfExists('komponens');
    }
}
