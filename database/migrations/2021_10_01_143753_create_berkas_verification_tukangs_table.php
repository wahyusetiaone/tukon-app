<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasVerificationTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_verification_tukangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('verificationtukang_id')->unsigned();
            $table->text('path');
            $table->text('original_name');
            $table->timestamps();
            $table->foreign('verificationtukang_id')
                ->references('id')->on('verification_tukangs')
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
        Schema::dropIfExists('berkas_verification_tukangs');
    }
}
