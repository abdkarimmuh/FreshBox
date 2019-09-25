<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxSalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_sales_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sales_order_no', 20);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('source_order_id');
            $table->string('no_po')->nullable();
            $table->date('fulfillment_date');
            $table->string('remarks', 200)->nullable();
            $table->binary('file')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_printed')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('master_customer')->references('id')->onDelete('cascade');
            $table->foreign('source_order_id')->on('master_source_order')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_sales_order');
    }
}
