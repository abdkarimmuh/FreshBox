<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertWarehouseConfirmationDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirmation_detail');

        DB::unprepared('CREATE PROCEDURE insert_warehouse_confirmation_detail( IN trx_proc_detail_id INT, IN qty_order DECIMAL(18,2), IN qty_confirm DECIMAL(18,2), IN uom_id INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_warehouse_confirmation_detail (trx_proc_detail_id, qty_order, qty_confirm, uom_id, created_at, created_by) VALUES (trx_proc_detail_id, qty_order, qty_confirm, uom_id, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_warehouse_confirmation_detail');
    }
}
