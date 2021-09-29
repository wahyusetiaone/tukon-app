<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTukangFotoKantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukang_foto_kantors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tukang_id')->unsigned();
            $table->text('path');
            $table->text('original_name');
            $table->timestamps();
            $table->foreign('tukang_id')
                ->references('id')->on('tukangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tukang_foto_kantors');
    }
}
