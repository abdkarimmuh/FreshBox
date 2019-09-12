<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateWarehouseConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirmation');

        DB::unprepared('CREATE PROCEDURE update_warehouse_confirmation(IN v_id INT, IN procurement_no VARCHAR(191), IN fulfillment_date DATE, IN status INT, IN remark VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_confirmation SET procurement_no = procurement_no, fulfillment_date = fulfillment_date, status = status, remark = remark, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirmation');
    }
}
