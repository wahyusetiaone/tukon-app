<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_cabangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cabang_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned();
            $table->timestamps();
            $table->foreign('cabang_id')
                ->references('id')->on('cabangs')
                ->onDelete('cascade');
            $table->foreign('admin_id')
                ->references('id')->on('admins')
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
        Schema::dropIfExists('has_cabangs');
    }
}
