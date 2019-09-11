<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxWarehouseConfirmationDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_warehouse_confirmation_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_proc_detail_id');
            $table->decimal('qty_order', 18, 2);
            $table->decimal('qty_confirm', 18, 2);
            $table->unsignedBigInteger('uom_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('trx_proc_detail_id')->on('trx_procurement_detail')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('trx_warehouse_confirmation_detail');
    }
}
