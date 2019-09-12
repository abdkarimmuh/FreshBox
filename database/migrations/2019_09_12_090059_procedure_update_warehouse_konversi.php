<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateWarehouseKonversi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_konversi');

        DB::unprepared('CREATE PROCEDURE update_warehouse_konversi(IN v_id INT, IN trx_proc_detail_id INT, IN procurement_no VARCHAR(191), IN qty_proc DECIMAL(18,2), IN uom_proc INT, IN qty_konversi DECIMAL(18,2), IN uom_konversi INT, IN updated_by INT )
        BEGIN
        UPDATE trx_warehouse_konversi SET trx_proc_detail_id = trx_proc_detail_id, procurement_no = procurement_no, qty_proc = qty_proc, uom_proc = uom_proc, qty_konversi = qty_konversi, uom_konversi = uom_konversi, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_warehouse_konversi');
    }
}
