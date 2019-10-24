<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxWarehouseConfirmDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_warehouse_confirm_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_confirm_id');
            $table->unsignedBigInteger('list_proc_detail_id');
            $table->decimal('bruto', 18, 2);
            $table->decimal('netto', 18, 2);
            $table->decimal('tara', 18, 2);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('warehouse_confirm_id')->on('trx_warehouse_confirm')->references('id')->onDelete('cascade');
            $table->foreign('list_proc_detail_id')->on('trx_list_procurement_detail')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_warehouse_confirm_detail');
    }
}
