<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureInsertListProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement_detail');

        DB::unprepared('CREATE PROCEDURE insert_list_procurement_detail( IN trx_list_procurement_id INT, IN trx_assign_procurement_id INT, IN qty DECIMAL(18, 2), IN uom_id INT, IN amount DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN created_by INT )
        BEGIN
        INSERT INTO trx_list_procurement_detail (trx_list_procurement_id, trx_assign_procurement_id, qty, uom_id, amount, total_amount, created_at, created_by) VALUES (trx_list_procurement_id, trx_assign_procurement_id, qty, uom_id, amount, total_amount, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_list_procurement_detail');
    }
}