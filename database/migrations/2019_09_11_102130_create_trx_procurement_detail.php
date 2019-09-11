<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_procurement_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_procurement_id');
            $table->unsignedBigInteger('trx_list_procurement_id');
            $table->decimal('qty', 18, 2);
            $table->unsignedBigInteger('uom_id');
            $table->decimal('amount', 18, 2);
            $table->decimal('total_amount', 18, 2);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('trx_procurement_id')->on('trx_procurement')->references('id')->onDelete('cascade');
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_procurement_detail');
    }
}
