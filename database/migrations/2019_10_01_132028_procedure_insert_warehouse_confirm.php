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

        DB::unprepared('CREATE PROCEDURE insert_warehouse_confirm( IN procurement_no VARCHAR(191), IN status INT, IN remark VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_confirm (procurement_no, status, remark, created_at, created_by) VALUES (procurement_no, status, remark, now(), created_by);
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
