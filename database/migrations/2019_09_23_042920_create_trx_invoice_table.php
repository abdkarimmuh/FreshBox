<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no');
            $table->unsignedBigInteger('do_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('invoice_date');
            $table->date('submit_date')->nullable();
            $table->tinyInteger('is_printed')->default(0);
            $table->tinyInteger('is_recap')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('do_id')->on('trx_delivery_order')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('master_customer')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_invoice');
    }
}
