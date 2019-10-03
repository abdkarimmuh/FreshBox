<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertWarehouseConfirm extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirm');

        DB::unprepared('CREATE PROCEDURE insert_warehouse_confirm( IN procurement_no VARCHAR(191), IN fulfillment_date DATE, IN status INT, IN remark VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_confirm (procurement_no, fulfillment_date, status, remark, created_at, created_by) VALUES (procurement_no, fulfillment_date, status, remark, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirm');
    }
}
