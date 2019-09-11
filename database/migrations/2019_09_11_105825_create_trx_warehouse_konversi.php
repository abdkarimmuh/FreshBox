<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxWarehouseKonversi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_warehouse_konversi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_proc_detail_id');
            $table->string('procurement_no');
            $table->decimal('qty_proc', 18, 2);
            $table->unsignedBigInteger('uom_proc');
            $table->decimal('qty_konversi', 18, 2);
            $table->unsignedBigInteger('uom_konversi');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('trx_proc_detail_id')->on('trx_procurement_detail')->references('id')->onDelete('cascade');
            $table->foreign('uom_proc')->on('master_uom')->references('id')->onDelete('cascade');
            $table->foreign('uom_konversi')->on('master_uom')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_warehouse_konversi');
    }
}
