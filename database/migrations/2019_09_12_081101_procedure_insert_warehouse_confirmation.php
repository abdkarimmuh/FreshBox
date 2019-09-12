<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertWarehouseConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirmation');

        DB::unprepared('CREATE PROCEDURE insert_warehouse_confirmation( IN procurement_no VARCHAR(191), IN fulfillment_date DATE, IN status INT, IN remark VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_confirmation (procurement_no, fulfillment_date, status, remark, created_at, created_by) VALUES (procurement_no, fulfillment_date, status, remark, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirmation');
    }
}
