<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateWarehouseConfirm extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm');

        DB::unprepared('CREATE PROCEDURE update_warehouse_confirm(IN v_id INT, IN procurement_no VARCHAR(191), IN fulfillment_date DATE, IN status INT, IN remark VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_confirm SET procurement_no = procurement_no, fulfillment_date = fulfillment_date, status = status, remark = remark, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm');
    }
}
