<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTrxListProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_list_procurement', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->renameColumn('vendor_id', 'vendor');
        });
        
        Schema::table('trx_list_procurement', function (Blueprint $table) {
            $table->string('vendor')->change();
        });

        Schema::table('trx_list_procurement_detail', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_list_procurement_detail', function (Blueprint $table) {
            $table->decimal('total_amount', 18, 2);
        });

        Schema::table('trx_list_procurement', function (Blueprint $table) {
            $table->renameColumn('vendor', 'vendor_id');
        });

        Schema::table('trx_list_procurement', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->change();
            $table->foreign('vendor_id')->on('master_vendor')->references('id')->onDelete('cascade');
        });
    }
}
