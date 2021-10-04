<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPencairanBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi__pencairan__bonuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bonus_admin_id')->unsigned();
            $table->bigInteger('pencairan');
            $table->text('catatan_penolakan');
            $table->text('bukti_tf_admin');
            $table->string('kode_status', 4)->default('TB01');
            $table->timestamps();
            $table->foreign('bonus_admin_id')
                ->references('id')->on('bonus_admin_cabangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi__pencairan__bonuses');
    }
}
