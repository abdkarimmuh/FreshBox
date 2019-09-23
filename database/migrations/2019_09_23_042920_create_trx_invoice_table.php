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
            $table->unsignedBigInteger('id_so');
            $table->unsignedBigInteger('id_do');
            $table->date('invoice_date');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('id_so')->on('trx_sales_order')->references('id')->onDelete('cascade');
            $table->foreign('id_do')->on('trx_delivery_order')->references('id')->onDelete('cascade');

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
