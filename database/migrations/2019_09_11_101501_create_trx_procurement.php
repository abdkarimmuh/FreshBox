<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_procurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('procurement_no');
            $table->unsignedBigInteger('users_proc_id');
            $table->unsignedBigInteger('vendor_id');
            $table->decimal('total_amount', 18, 2);
            $table->string('payment');
            $table->binary('file');

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('users_proc_id')->on('users_proc')->references('id')->onDelete('cascade');
            $table->foreign('vendor_id')->on('master_vendor')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('trx_procurement');
    }
}
