<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProcedureNotificationProcurement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_notification_procurement');

        DB::unprepared('CREATE PROCEDURE insert_notification_procurement( IN user_proc_id INT, IN trx_warehouse_confirm_id INT, IN status INT, IN message VARCHAR(191), IN read_at DATE, IN created_by INT )
        BEGIN
        INSERT INTO notification_procurement (user_proc_id, trx_warehouse_confirm_id, status, message, read_at, created_at, created_by) VALUES (user_proc_id, trx_warehouse_confirm_id, status, message, read_at, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_notification_procurement');
    }
}
