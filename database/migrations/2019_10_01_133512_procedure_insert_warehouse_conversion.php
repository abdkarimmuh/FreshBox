<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertWarehouseConversion extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_conversion');

        DB::unprepared('CREATE PROCEDURE insert_warehouse_conversion( IN list_proc_detail_id INT, IN procurement_no VARCHAR(191), IN qty_proc DECIMAL(18,2), IN uom_proc INT, IN qty_konversi DECIMAL(18,2), IN uom_konversi INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_conversion (list_proc_detail_id, procurement_no, qty_proc, uom_proc, qty_konversi, uom_konversi, created_at, created_by) VALUES (trx_proc_detail_id, procurement_no, qty_proc, uom_proc, qty_konversi, uom_konversi, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_conversion');
    }
}
