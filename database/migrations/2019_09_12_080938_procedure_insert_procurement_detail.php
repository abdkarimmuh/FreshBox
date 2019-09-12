<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_procurement_detail');

        DB::unprepared('CREATE PROCEDURE insert_procurement_detail( IN trx_proc_detail_id INT, IN trx_list_procurement_id INT, IN qty DECIMAL(18, 2), IN uom_id INT, IN amount DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN created_by INT )
        BEGIN
        INSERT INTO trx_procurement_detail (trx_proc_detail_id, trx_list_procurement_id, qty, uom_id, amount, total_amount, created_at, created_by) VALUES (trx_proc_detail_id, trx_list_procurement_id, qty, uom_id, amount, total_amount, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_procurement_detail');
    }
}
