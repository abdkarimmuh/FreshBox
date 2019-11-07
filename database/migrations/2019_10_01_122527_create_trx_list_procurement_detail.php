<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxListProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_list_procurement_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_list_procurement_id');
            $table->unsignedBigInteger('skuid');
            $table->decimal('qty', 18, 2);
            $table->decimal('qty_minus', 18, 2)->default(0);
            $table->unsignedBigInteger('uom_id');
            $table->decimal('amount', 18, 2);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('trx_list_procurement_id')->on('trx_list_procurement')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_list_procurement_detail');
    }
}
