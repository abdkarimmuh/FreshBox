<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxInvoiceRecapTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_invoice_recap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recap_invoice_no', '20');
            $table->unsignedBigInteger('customer_id');
            $table->date('recap_date');
            $table->date('submitted_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->bigInteger('admin_amount')->default(0);
            $table->binary('file')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_invoice_recap');
    }
}
