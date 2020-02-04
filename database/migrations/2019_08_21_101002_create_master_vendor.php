<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterVendor extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('master_vendor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->string('pic_vendor');
            $table->string('tlp_pic', 20);
            $table->unsignedBigInteger('bank_id');
            $table->string('bank_account');
            $table->float('ppn')->default(0);
            $table->float('pph')->default(0);
            $table->tinyInteger('type_vendor')->default(0)->comment('1 = Employee , 2 = Vendor');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('category_id')->on('master_category')->references('id')->onDelete('cascade');
            $table->foreign('bank_id')->on('master_bank')->references('id')->onDelete('cascade');
            $table->index(['name', 'pic_vendor']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor');
    }
}
