<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPriceLog extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('master_price_log', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->bigInteger('skuid');
            $table->unsignedBigInteger('uom_id');
            $table->unsignedBigInteger('customer_group_id');
            $table->decimal('amount_basic', 18, 2)->nullable();
            $table->decimal('amount_discount', 18, 2)->nullable();
            $table->decimal('amount', 18, 2);
            $table->decimal('tax_value', 18, 2)->nullable();
            $table->date('start_periode');
            $table->date('end_periode');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('audit_user')->nullable();
            $table->timestamp('audit_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('uom_id');
            $table->index('skuid');
            $table->index('amount');
            $table->index('customer_group_id');
            $table->index('start_periode');
            $table->index('end_periode');
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('master_price_log');
    }
}
