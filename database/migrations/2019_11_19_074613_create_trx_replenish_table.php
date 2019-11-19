<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxReplenishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_replenish', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('list_proc_id');
            $table->tinyInteger('status')->comment('1 = Replenish, 2 = Return Replenish');
            $table->bigInteger('total_amount');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('trx_replenish');
    }
}
