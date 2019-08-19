<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreshCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fresh_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_code', 15);
            $table->unsignedBigInteger('customer_type_id');
            $table->unsignedBigInteger('customer_group_id');
            $table->string('customer_name', 100);
            $table->string('pic_customer', 100);
            $table->string('tlp_pic', 100);
            $table->string('address', 500);
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('residence_id');
            $table->integer('kodepos');
            $table->string('longitude', 100);
            $table->string('latitude', 100);
            $table->unsignedBigInteger('created_by');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('customer_type_id')->on('customer_type')->references('id')->onDelete('cascade');
            $table->foreign('customer_group_id')->on('users')->references('customer_group')->onDelete('cascade');

//            $table->foreign('province_id')->on('users')->references('province')->onDelete('cascade');
//            $table->foreign('residence')->on('users')->references('residence')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fresh_customer');
    }
}
