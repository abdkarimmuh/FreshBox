<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('master_warehouse_id')->index();
            $table->string('no_request')->index();
            $table->date('request_date')->index();
            $table->string('no_request_confirm')->nullable();
            $table->date('request_confirm_date')->nullable();
            $table->tinyInteger('request_type')->comment('1 = cash , 2 = advance');
            $table->tinyInteger('product_type')->comment('1 = non core , 2 = core');
            $table->binary('file')->nullable();
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
        Schema::dropIfExists('finance_request');
    }
}
