<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertListProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement');

        DB::unprepared('CREATE PROCEDURE insert_list_procurement( IN procurement_no VARCHAR(191), IN user_proc_id INT, IN vendor VARCHAR(191), IN total_amount DECIMAL(18, 2), IN payment VARCHAR(191), IN file BINARY, IN status INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_list_procurement (procurement_no, user_proc_id, vendor, total_amount, payment, file, status, created_at, created_by) VALUES (procurement_no, user_proc_id, vendor, total_amount, payment, file, status, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement');
    }
}
