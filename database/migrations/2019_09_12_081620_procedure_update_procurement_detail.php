<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_procurement_detail');

        DB::unprepared('CREATE PROCEDURE update_procurement_detail(IN v_id INT, IN trx_procurement_id INT, IN trx_list_procurement_id INT, IN qty DECIMAL(18,2), IN uom_id INT, IN amount DECIMAL(18,2), IN total_amount DECIMAL(18,2), IN updated_by INT )
        BEGIN
        UPDATE trx_procurement_detail SET trx_procurement_id = trx_procurement_id, trx_list_procurement_id = trx_list_procurement_id, qty = qty, uom_id = uom_id, amount = amount, total_amount = total_amount, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_procurement_detail');
    }
}
