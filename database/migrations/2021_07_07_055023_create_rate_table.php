<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_tukang');
            $table->integer('value_rate');
            $table->integer('count_rate')->default(0);
            $table->timestamps();
        });

        $procedure = "
    CREATE PROCEDURE `procedure_name`(procedure_param_1 TEXT, procedure_param_2 TEXT)
    BEGIN
         // Your SP here
    END
";

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate');
    }
}
