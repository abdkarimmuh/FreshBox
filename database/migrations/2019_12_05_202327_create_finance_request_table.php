<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceRequestTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('finance_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id')->index();
            $table->tinyInteger('status');
            $table->unsignedBigInteger('master_warehouse_id')->index();
            $table->string('no_request')->index();
            $table->date('request_date')->index();
            $table->string('no_payment')->nullable();
            $table->date('confirm_date')->nullable();
            $table->tinyInteger('request_type')->comment('1 = Cash , 2 = Advance');
            $table->tinyInteger('product_type')->comment('1 = Non Core , 2 = Core');
            $table->binary('file')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('finance_request');
    }
}
