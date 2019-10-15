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
            $table->bigInteger('skuid');
            $table->unsignedBigInteger('uom_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount_basic', 18, 2);
            $table->decimal('amount_discount', 18, 2);
            $table->decimal('amount', 18, 2);
            $table->decimal('tax_value', 18, 2)->nullable();
            $table->date('start_periode');
            $table->date('end_periode');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['skuid','amount','amount_basic','amount_discount']);

            $table->foreign('uom_id')->on('master_uom')->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('master_customer')->references('id')->onDelete('cascade');
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
