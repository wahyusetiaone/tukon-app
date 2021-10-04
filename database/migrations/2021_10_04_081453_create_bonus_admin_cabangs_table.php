<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusAdminCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_admin_cabangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_project')->unsigned();
            $table->bigInteger('admin_id')->unsigned();
            $table->boolean('dialihkan')->default(false);
            $table->bigInteger('bonus');
            $table->string('kode_status', 4)->default('BA01');
            $table->timestamps();
            $table->foreign('kode_project')
                ->references('id')->on('projects');
            $table->foreign('admin_id')
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
        Schema::dropIfExists('bonus_admin_cabangs');
    }
}
