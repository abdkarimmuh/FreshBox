<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxWarehouseConfirm extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_warehouse_confirm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('list_procurement_id');
            $table->string('remark');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('list_procurement_id')->on('trx_list_procurement')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_warehouse_confirm');
    }
}
