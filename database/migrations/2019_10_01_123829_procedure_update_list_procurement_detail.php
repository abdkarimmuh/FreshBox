<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateListProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement_detail');

        DB::unprepared('CREATE PROCEDURE update_list_procurement_detail(IN v_id INT, IN trx_list_procurement_id INT, IN skuid INT, IN qty DECIMAL(18,2), IN qty_minus DECIMAL(18,2), IN uom_id INT, IN amount DECIMAL(18,2), IN status INT, IN updated_by INT )
        BEGIN
        UPDATE trx_list_procurement_detail SET trx_list_procurement_id = trx_list_procurement_id, skuid = skuid, qty = qty, qty_minus = qty_minus, uom_id = uom_id, amount = amount, status = status, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement_detail');
    }
}
