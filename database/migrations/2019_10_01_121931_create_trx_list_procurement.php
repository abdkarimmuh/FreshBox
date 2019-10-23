<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxListProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_list_procurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('procurement_no');
            $table->unsignedBigInteger('user_proc_id');
            $table->string('vendor')->nullable();
            $table->decimal('total_amount', 18, 2);
            $table->string('payment');
            $table->binary('file')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('remarks')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('user_proc_id')->on('user_proc')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('trx_list_procurement');
    }
}
