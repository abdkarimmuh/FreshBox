<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateWarehouseConfirmDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm_detail');

        DB::unprepared('CREATE PROCEDURE update_warehouse_confirm_detail(IN v_id INT, IN warehouse_confirm_id INT, IN list_proc_detail_id INT, IN bruto DECIMAL(18,2), IN netto DECIMAL(18,2), IN tara DECIMAL(18,2), IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_confirm_detail SET warehouse_confirm_id = warehouse_confirm_id, list_proc_detail_id = list_proc_detail_id, bruto = bruto, netto = netto, tara = tara, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_confirm_detail');
    }
}
