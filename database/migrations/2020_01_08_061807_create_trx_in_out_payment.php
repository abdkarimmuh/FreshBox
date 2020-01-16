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
            $table->string('vendor');
            $table->bigInteger('bank_id')->default(0) ;
            $table->string('no_rek', 20);
            $table->bigInteger('amount')->default(0);
            $table->string('remarks');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type_transaction')->default(0);
            $table->timestamps('created_at');
            $table->timestamp('updated_at');
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
