<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxAssignProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_assign_procurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skuid');
            $table->unsignedBigInteger('user_proc_id');
            $table->integer('qty');
            $table->unsignedBigInteger('uom_id');

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('user_proc_id')->on('user_proc')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_assign_procurement');
    }
}
