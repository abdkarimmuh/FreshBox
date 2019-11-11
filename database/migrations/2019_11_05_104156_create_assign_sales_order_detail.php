<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignSalesOrderDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assign_sales_order_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_order_detail_id');
            $table->unsignedBigInteger('assign_id');

            $table->foreign('sales_order_detail_id')->on('trx_sales_order_detail')->references('id')->onDelete('cascade');
            $table->foreign('assign_id')->on('trx_assign_procurement')->references('id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assign_sales_order_detail');
    }
}
