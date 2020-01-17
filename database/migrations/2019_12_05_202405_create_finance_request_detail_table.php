<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceRequestDetailTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('finance_request_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_finance_id')->index();
            $table->string('item_name')->index();
            $table->string('type_of_goods')->index();
            $table->float('qty')->index();
            $table->unsignedBigInteger('uom_id')->index();
            $table->integer('price')->index();
            $table->integer('ppn')->nullable();
            $table->integer('total')->index();
            $table->string('supplier_name');
            $table->string('remarks')->nullable();
            $table->integer('price_confirm')->nullable();
            $table->integer('total_confirm')->nullable();
            $table->float('qty_confirm')->default(0);
            $table->tinyInteger('checked')->default(0)->comment('0 = default ,1 = notReturned, 2 = returned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('finance_request_detail');
    }
}
