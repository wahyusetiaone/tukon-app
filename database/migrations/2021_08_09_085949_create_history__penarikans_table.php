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
        Schema::create('history__penarikans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_penariakan');
            $table->bigInteger('kode_persentase_penarikan');
            $table->bigInteger('penarikan');
            $table->bigInteger('kode_status');
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
