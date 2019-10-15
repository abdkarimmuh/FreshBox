<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxInvoiceRecapDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_invoice_recap_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_recap_id');
            $table->unsignedBigInteger('invoice_id');
            $table->decimal('amount_paid', 18, 2)->nullable();

            $table->foreign('invoice_recap_id')->on('trx_invoice_recap')->references('id')->onDelete('cascade');
            $table->foreign('invoice_id')->on('trx_invoice')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_invoice_recap_detail');
    }
}
