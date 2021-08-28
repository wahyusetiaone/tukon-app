<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian_danas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_project');
            $table->integer('jmlh_pengembalian_persentasi');
            $table->bigInteger('jmlh_pengembalian');
            $table->bigInteger('kode_penalty');
            $table->string('kode_status', 4);
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
        Schema::dropIfExists('pengembalian_danas');
    }
}
