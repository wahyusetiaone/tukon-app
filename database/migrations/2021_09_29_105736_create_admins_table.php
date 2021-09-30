<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_telepon', 12);
            $table->string('alamat',255);
            $table->string('provinsi',255);
            $table->string('kota',100);
            $table->string('kode_lokasi', 6)->nullable();
            $table->string('path_foto', 255)->default('storage/images/photos/def_profile.svg');
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
        Schema::dropIfExists('admins');
    }
}
