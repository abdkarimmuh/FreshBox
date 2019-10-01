<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureInsertListProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement');

        DB::unprepared('CREATE PROCEDURE insert_list_procurement( IN procurement_no VARCHAR(191), IN user_proc_id INT, IN vendor_id INT, IN total_amount DECIMAL(18, 2), IN payment VARCHAR(191), IN file BINARY, IN created_by INT )
        BEGIN
        INSERT INTO trx_list_procurement (procurement_no, user_proc_id, vendor_id, total_amount, payment, file, created_at, created_by) VALUES (procurement_no, user_proc_id, vendor_id, total_amount, payment, file, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement');
    }
}
