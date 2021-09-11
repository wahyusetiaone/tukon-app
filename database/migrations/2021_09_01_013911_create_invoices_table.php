<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id')->nullable();
            $table->string('external_id');
            $table->bigInteger('kode_pembayaran');
            $table->string('status');
            $table->boolean('payment_offline');
            $table->bigInteger('amount');
            $table->string('payer_email');
            $table->string('description');
            $table->dateTime('expiry_date');
            $table->text('invoice_url');
            $table->json('available_banks')->nullable();
            $table->json('available_retail_outlets')->nullable();
            $table->json('available_ewallets')->nullable();
            $table->boolean('should_exclude_credit_card')->default(true);
            $table->boolean('should_send_email')->default(false);
            $table->string('currency')->default('IDR');
            $table->json('items');
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
        Schema::dropIfExists('invoices');
    }
}
