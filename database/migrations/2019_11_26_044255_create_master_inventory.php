<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterInventory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('master_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('skuid');
            $table->bigInteger('qty')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('master_inventory');
    }
}
