<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSettlementDetailTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_settlement_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('settlement_id')->index();
            $table->string('item_name')->index();
            $table->string('skuid')->index();
            $table->float('qty')->index();
            $table->unsignedBigInteger('uom_id')->index();
            $table->integer('price')->index();
            $table->integer('ppn')->nullable();
            $table->integer('total')->index();
            $table->string('supplier_id')->nullable();
            $table->tinyInteger('checked')->default(0)->comment('0 = Default ,1 = Not Returned, 2 = Returned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_settlement_detail');
    }
}
