<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxDeliveryOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_delivery_order_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('delivery_order_id');
            $table->string('skuid');
            $table->unsignedBigInteger('sales_order_detail_id');
            $table->decimal('qty_do', 18, 2);
            $table->decimal('qty_confirm', 18, 2)->default(0);
            $table->unsignedBigInteger('uom_id');
            $table->integer('returned')->default(0);
            $table->string('remark')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('delivery_order_id')->on('trx_delivery_order')->references('id')->onDelete('cascade');
            $table->foreign('sales_order_detail_id')->on('trx_sales_order_detail')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_delivery_order_detail');
    }
}
