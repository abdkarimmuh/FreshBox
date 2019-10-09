<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertListProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement_detail');

        DB::unprepared('CREATE PROCEDURE insert_list_procurement_detail( IN trx_list_procurement_id INT, IN trx_assign_procurement_id INT, IN qty DECIMAL(18, 2), IN qty_minus DECIMAL(18, 2), IN uom_id INT, IN amount DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN created_by INT )
        BEGIN
        INSERT INTO trx_list_procurement_detail (trx_list_procurement_id, trx_assign_procurement_id, qty, qty_minus, uom_id, amount, total_amount, created_at, created_by) VALUES (trx_list_procurement_id, trx_assign_procurement_id, qty, qty_minus, uom_id, amount, total_amount, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement_detail');
    }
}
