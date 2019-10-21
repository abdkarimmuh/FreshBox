<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateListProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement');

        DB::unprepared('CREATE PROCEDURE update_list_procurement(IN v_id INT, IN procurement_no VARCHAR(191), IN user_proc_id INT, IN vendor VARCHAR(191), IN total_amount DECIMAL(18,2), IN payment VARCHAR(191), IN file BINARY, IN status INT, IN updated_by INT )
        BEGIN
        UPDATE trx_list_procurement SET procurement_no = procurement_no, user_proc_id = user_proc_id, vendor = vendor, total_amount = total_amount, payment = payment, file = file, status = status, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement');
    }
}
