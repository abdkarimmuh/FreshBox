<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertWarehouseConfirmDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirm_detail');

        DB::unprepared('CREATE PROCEDURE insert_warehouse_confirm_detail( IN warehouse_confirm_id INT, IN list_proc_detail_id INT, IN qty_order DECIMAL(18,2), IN qty_confirm DECIMAL(18,2), IN uom_id INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_confirm_detail (warehouse_confirm_id, list_proc_detail_id, qty_order, qty_confirm, uom_id, created_at, created_by) VALUES (warehouse_confirm_id, list_proc_detail_id, qty_order, qty_confirm, uom_id, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirm_detail');
    }
}
