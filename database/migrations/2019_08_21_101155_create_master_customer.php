<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_code', 15);
            $table->unsignedBigInteger('customer_type_id');
            $table->unsignedBigInteger('customer_group_id');
            $table->string('name');
            $table->string('pic_customer');
            $table->string('tlp_pic', 20);
            $table->tinyInteger('price_type');
            $table->string('address', 500);
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('residence_id')->nullable();
            $table->integer('kodepos')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name', 'customer_code']);
            $table->foreign('customer_type_id')->on('master_customer_type')->references('id')->onDelete('cascade');
            $table->foreign('customer_group_id')->on('master_customer_group')->references('id')->onDelete('cascade');
            $table->foreign('province_id')->on('master_province')->references('id')->onDelete('cascade');
            $table->foreign('residence_id')->on('master_residence')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_customer');
    }
}
