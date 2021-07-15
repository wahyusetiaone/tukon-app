<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history__pengajuans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_pengajuan')->default(0);
            $table->bigInteger('kode_client')->default(0);
            $table->string('nama_proyek', 100);
            $table->text('diskripsi_proyek');
            $table->string('alamat', 255);
            $table->text('path');
            $table->boolean('multipath')->default(false);
            $table->boolean('offline')->default(false);
            $table->bigInteger('range_min')->nullable();
            $table->bigInteger('range_max')->nullable();
            $table->date('deadline')->nullable();
            $table->string('kode_status', 4)->nullable();
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
        Schema::dropIfExists('history__pengajuans');
    }
}
