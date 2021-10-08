<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_tukangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tukang_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned();
            $table->bigInteger('alokasi_bonus_id')->unsigned();
            $table->string('nama_tukang', 255);
            $table->string('no_hp', 255);
            $table->string('email', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->text('koordinat');
            $table->text('catatan')->nullable();
            $table->string('status',4)->default('V01');
            $table->timestamps();
            $table->foreign('tukang_id')
                ->references('id')->on('tukangs')
                ->onDelete('cascade');
            $table->foreign('admin_id')
                ->references('id')->on('admins');
            $table->foreign('alokasi_bonus_id')
                ->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_tukangs');
    }
}
