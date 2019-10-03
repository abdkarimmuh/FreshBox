<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateSalesOrderDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_sales_order_detail');

        DB::unprepared('CREATE PROCEDURE update_sales_order_detail(IN v_id INT, IN sales_order_id INT, IN skuid INT, IN uom_id INT, IN qty DECIMAL(18, 2), IN amount_price DECIMAL(18, 2), IN tax_value DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN notes VARCHAR(191), IN status INT, IN updated_by INT )
        BEGIN
        UPDATE trx_sales_order_detail SET name = name, sales_order_id = sales_order_id, skuid = skuid, uom_id = uom_id, name = name, qty = qty, amount_price = amount_price, tax_value = tax_value, total_amount = total_amount, notes = notes, status = status, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_sales_order_detail');
    }
}
