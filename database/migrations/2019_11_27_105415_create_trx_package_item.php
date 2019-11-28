<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxPackageItem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trx_package_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('so_detail_id');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trx_package_item');
    }
}
