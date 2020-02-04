<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxSettlementTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_settlement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_finance_id')->index();
            $table->tinyInteger('status');
            $table->string('no_settlement')->index();
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
        Schema::dropIfExists('trx_settlement');
    }
}
