<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdatePrice extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_price');

        DB::unprepared('CREATE PROCEDURE update_price(IN v_id INT, IN skuid INT, IN uom_id INT, IN customer_id INT, IN amount DECIMAL(18, 2), IN tax_value DECIMAL(18, 2), IN start_periode DATE, IN end_periode DATE, IN remarks VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_price SET name = name, skuid = skuid, uom_id = uom_id, customer_id = customer_id, amount = amount, tax_value = tax_value, start_periode = start_periode, end_periode = end_periode, remarks = remarks, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_price');
    }
}
