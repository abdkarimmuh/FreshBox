<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxInvoiceRecapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_invoice_recap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recap_invoice_no','20');
            $table->unsignedBigInteger('customer_id');
            $table->date('recap_date');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('trx_invoice_recap');
    }
}
