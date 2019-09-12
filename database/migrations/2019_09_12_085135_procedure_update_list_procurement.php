<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateListProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement');

        DB::unprepared('CREATE PROCEDURE update_list_procurement(IN v_id INT, IN sales_order_detail_id INT, IN users_proc_id INT, IN updated_by INT )
        BEGIN
        UPDATE trx_list_procurement SET sales_order_detail_id = sales_order_detail_id, users_proc_id = users_proc_id, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_list_procurement');
    }
}
