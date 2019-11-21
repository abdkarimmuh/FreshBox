<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxTopupProc extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_topup_proc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_proc_id');
            $table->integer('amount')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('remark')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_topup_proc');
    }
}
