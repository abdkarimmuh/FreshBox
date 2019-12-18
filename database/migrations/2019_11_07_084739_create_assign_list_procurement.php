<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignListProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assign_list_procurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('list_procurement_detail_id');
            $table->unsignedBigInteger('assign_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assign_list_procurement');
    }
}
