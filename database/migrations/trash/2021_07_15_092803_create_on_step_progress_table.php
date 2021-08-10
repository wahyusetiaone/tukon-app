<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnStepProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_step_progress', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_project')->default(0);
            $table->bigInteger('kode_plan_progress')->default(0);
            $table->text('path')->nullable();
            $table->text('note_step_progress')->nullable();
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
        Schema::dropIfExists('on_step_progress');
    }
}
