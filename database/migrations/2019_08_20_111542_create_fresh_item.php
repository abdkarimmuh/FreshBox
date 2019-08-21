<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreshItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fresh_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('skuid', 6);
            $table->string('name_item');
            $table->string('name_item_latin')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('uom_id')->nullable();
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->on('category')->references('id')->onDelete('cascade');
            $table->foreign('uom_id')->on('uom')->references('id')->onDelete('cascade');
            $table->foreign('origin_id')->on('origin')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('fresh_item');
    }
}
