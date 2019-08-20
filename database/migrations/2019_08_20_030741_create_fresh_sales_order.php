<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreshSalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fresh_sales_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sales_order_no', 20);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('source_order_id');
            $table->dateTime('fulfillment_date');
            $table->string('remarks', 200);
            $table->integer('do_status');
            $table->integer('so_status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('edited_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('fresh_customer')->references('id')->onDelete('cascade');
            $table->foreign('source_order_id')->on('fresh_source_order')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fresh_sales_order');
    }
}
