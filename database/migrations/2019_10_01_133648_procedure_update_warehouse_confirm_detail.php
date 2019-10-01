<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureUpdateWarehouseConfirmDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm_detail');

        DB::unprepared('CREATE PROCEDURE update_warehouse_confirm_detail(IN v_id INT, IN warehouse_confirm_id INT, IN list_proc_detail_id INT, IN qty_order DECIMAL(18,2), IN qty_confirm DECIMAL(18,2), IN uom_id INT, IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_confirm_detail SET warehouse_confirm_id = warehouse_confirm_id, list_proc_detail_id = list_proc_detail_id, qty_order = qty_order, qty_confirm = qty_confirm, uom_id = uom_id, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm_detail');
    }
}
