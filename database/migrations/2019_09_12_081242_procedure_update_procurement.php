<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_procurement');

        DB::unprepared('CREATE PROCEDURE update_procurement(IN v_id INT, IN procurement_no VARCHAR(191), IN users_proc_id INT, IN vendor_id INT, IN total_amount DECIMAL(18,2), IN payment VARCHAR(191), IN file BINARY, IN updated_by INT )
        BEGIN
        UPDATE trx_procurement SET procurement_no = procurement_no, users_proc_id = users_proc_id, vendor_id = vendor_id, total_amount = total_amount, payment = payment, file = file, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_procurement');
    }
}
