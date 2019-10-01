<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureUpdateAssignProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_assign_procurement');

        DB::unprepared('CREATE PROCEDURE update_assign_procurement(IN v_id INT, IN sales_order_detail_id INT, IN user_proc_id INT, IN updated_by INT )
        BEGIN
        UPDATE trx_assign_procurement SET sales_order_detail_id = sales_order_detail_id, user_proc_id = user_proc_id, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_assign_procurement');
    }
}
