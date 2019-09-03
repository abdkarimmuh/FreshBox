<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxDeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_delivery_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('delivery_order_no', 15);
            $table->unsignedBigInteger('sales_order_id');
            $table->unsignedBigInteger('customer_id');

            $table->date('do_date');
            $table->date('confrim_date');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sales_order_id')->on('trx_sales_order')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('master_customer')->references('id')->onDelete('cascade');

            $table->foreign('driver_id')->on('master_driver')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_delivery_order');
    }
}
