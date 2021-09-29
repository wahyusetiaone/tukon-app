<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_telepon', 12);
            $table->string('kota',255);
            $table->string('provinsi',255);
            $table->string('alamat',255);
            $table->text('kode_lokasi')->nullable();
            $table->string('no_rekening',255)->nullable();
            $table->string('atas_nama_rekening',255)->nullable();
            $table->string('bank',255)->nullable();
            $table->string('path_icon', 255)->default('images/def_tukang.png');;
            $table->double('rate')->default(0);
            $table->boolean('verifikasi_lokasi')->default(false);
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
        Schema::dropIfExists('tukangs');
    }
}
