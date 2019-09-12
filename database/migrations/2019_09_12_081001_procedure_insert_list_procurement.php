<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        DB::unprepared('CREATE PROCEDURE insert_list_procurement( IN sales_order_detail_id INT, IN users_proc_id INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_list_procurement (sales_order_detail_id, users_proc_id, created_at, created_by) VALUES (sales_order_detail_id, users_proc_id, now(), created_by);
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
