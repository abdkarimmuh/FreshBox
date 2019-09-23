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
            $table->date('invoice_date');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('do_id')->on('trx_delivery_order')->references('id')->onDelete('cascade');
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
