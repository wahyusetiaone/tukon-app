<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenawaranOfflinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penawaran_offlines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_tukang');
            $table->string('nama_client', 50)->nullable();
            $table->string('email_client', 50);
            $table->string('nomor_telepon_client', 50);
            $table->string('alamat_client',255);
            $table->string('nama_proyek',100);
            $table->text('diskripsi_proyek');
            $table->string('alamat_proyek',255);
            $table->bigInteger('range_min');
            $table->bigInteger('range_max');
            $table->integer('keuntungan');
            $table->bigInteger('harga_total');
            $table->date('deadline');
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
        Schema::dropIfExists('penawaran_offlines');
    }
}
