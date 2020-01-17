<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxPettyCashPayment extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_petty_cash_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('finance_request_id');
            $table->bigInteger('amount')->default(0);
            $table->string('no_trx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_petty_cash_payment');
    }
}
