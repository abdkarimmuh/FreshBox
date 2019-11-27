<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notification_procurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_proc_id');
            $table->unsignedBigInteger('trx_warehouse_confirm_id');
            $table->integer('status')->default(0);
            $table->dateTime('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_proc_id')->on('user_proc')->references('id')->onDelete('cascade');
            $table->foreign('trx_warehouse_confirm_id')->on('trx_warehouse_confirm')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notification_procurement');
    }
}
