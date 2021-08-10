<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenPenawaranOfflinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_penawaran_offlines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penawaran_offline');
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
        Schema::dropIfExists('komponen_penawaran_offlines');
    }
}
