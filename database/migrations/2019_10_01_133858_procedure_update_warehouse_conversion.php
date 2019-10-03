<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateWarehouseConversion extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_conversion');

        DB::unprepared('CREATE PROCEDURE update_warehouse_conversion(IN v_id INT, IN list_proc_detail_id INT, IN procurement_no VARCHAR(191), IN qty_proc DECIMAL(18,2), IN uom_proc INT, IN qty_konversi DECIMAL(18,2), IN uom_konversi INT, IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_conversion SET list_proc_detail_id = list_proc_detail_id, procurement_no = procurement_no, qty_proc = qty_proc, uom_proc = uom_proc, qty_konversi = qty_konversi, uom_konversi = uom_konversi, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_conversion');
    }
}
