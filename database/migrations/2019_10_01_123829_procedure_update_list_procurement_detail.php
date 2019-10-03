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

        DB::unprepared('CREATE PROCEDURE update_list_procurement_detail(IN v_id INT, IN trx_list_procurement_id INT, IN trx_assign_procurement_id INT, IN qty DECIMAL(18,2), IN uom_id INT, IN amount DECIMAL(18,2), IN total_amount DECIMAL(18,2), IN updated_by INT )
        BEGIN
        UPDATE trx_list_procurement_detail SET trx_list_procurement_id = trx_list_procurement_id, trx_assign_procurement_id = trx_assign_procurement_id, qty = qty, uom_id = uom_id, amount = amount, total_amount = total_amount, updated_by = updated_by, updated_at = now() WHERE id = v_id;
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
