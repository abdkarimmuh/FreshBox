<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTemp extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('price_temp', function (Blueprint $table) {
            $table->string('No')->nullable();
            $table->string('Category')->nullable();
            $table->integer('SKU')->nullable();
            $table->string('Items')->nullable();
            $table->string('Unit')->nullable();
            $table->integer('Pricelist')->nullable();
            $table->integer('Discount')->nullable();
            $table->integer('Final')->nullable();
            $table->string('Remarks')->nullable();
            $table->tinyInteger('customer_group_id');
            $table->string('start_period');
            $table->string('End_Period');
            $table->dateTime('AuditDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('price_temp');
    }
}
