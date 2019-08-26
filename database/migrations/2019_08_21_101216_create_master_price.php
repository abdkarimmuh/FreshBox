<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skuid');
            $table->unsignedBigInteger('uom_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount', 18, 2);
            $table->date('start_periode');
            $table->date('end_periode');
            $table->string('remarks');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('skuid')->on('master_item')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('master_customer')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('edited_by')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_price');
    }
}
