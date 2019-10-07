<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertAssignProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_assign_procurement');

        DB::unprepared('CREATE PROCEDURE insert_assign_procurement( IN sales_order_detail_id INT, IN user_proc_id INT, IN qty INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_assign_procurement (sales_order_detail_id, user_proc_id, qty, created_at, created_by) VALUES (sales_order_detail_id, user_proc_id, qty, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_assign_procurement');
    }
}
