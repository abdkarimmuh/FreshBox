<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificatiosProc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_proc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->unsignedBigInteger('users_proc_id');
            $table->unsignedBigInteger('trx_warehouse_confirmation_id');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();

            $table->foreign('users_proc_id')->on('users_proc')->references('id')->onDelete('cascade');
            $table->foreign('trx_warehouse_confirmation_id')->on('trx_warehouse_confirmation')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications_proc');
    }
}
