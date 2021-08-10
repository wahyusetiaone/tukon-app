<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenarikanDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penarikan_danas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_project');
            $table->bigInteger('total_dana');
            $table->bigInteger('kode_limitasi');
            $table->bigInteger('limitasi');
            $table->integer('persentase_penarikan')->default(0);
            $table->bigInteger('penarikan')->default(0);
            $table->bigInteger('sisa_penarikan');
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
        Schema::dropIfExists('penarikan_danas');
    }
}
