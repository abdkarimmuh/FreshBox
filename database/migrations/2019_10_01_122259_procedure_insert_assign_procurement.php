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

        DB::unprepared('CREATE PROCEDURE insert_assign_procurement( IN skuid INT, IN user_proc_id INT, IN qty INT, IN uom_id INT, IN status INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_assign_procurement (skuid, user_proc_id, qty, uom_id, status, created_at, created_by) VALUES (skuid, user_proc_id, qty, uom_id, status, now(), created_by);
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
