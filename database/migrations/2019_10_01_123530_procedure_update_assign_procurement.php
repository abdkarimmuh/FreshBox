<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateAssignProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_assign_procurement');

        DB::unprepared('CREATE PROCEDURE update_assign_procurement(IN v_id INT, IN skuid INT, IN user_proc_id INT, IN sales_order_detail_id INT, IN qty INT, IN uom_id INT, IN status INT, IN updated_by INT )
        BEGIN
        UPDATE trx_assign_procurement SET skuid = skuid, user_proc_id = user_proc_id, sales_order_detail_id = sales_order_detail_id, qty = qty, uom_id = uom_id, status = status, updated_at = now(), updated_by = updated_by WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_assign_procurement');
    }
}
