<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxInOutPayment extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_in_out_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('finance_request_id')->nullable();
            $table->string('source')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('bank_id');
            $table->string('no_rek', 20);
            $table->bigInteger('amount')->default(0);
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type_transaction')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_in_out_payment');
    }
}
