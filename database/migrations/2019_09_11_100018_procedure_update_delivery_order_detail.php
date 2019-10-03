<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateDeliveryOrderDetail extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_delivery_order_detail');

        DB::unprepared('CREATE PROCEDURE update_delivery_order_detail(IN v_id INT, IN delivery_order_id INT, IN item_id INT, IN sales_order_detail_id INT, IN qty_do DECIMAL(18, 2), IN uom_id INT, IN updated_by INT )
        BEGIN
        UPDATE trx_delivery_order_detail SET delivery_order_id = delivery_order_id, item_id = item_id, sales_order_detail_id = sales_order_detail_id, qty_do = qty_do, uom_id = uom_id, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_delivery_order_detail');
    }
}
