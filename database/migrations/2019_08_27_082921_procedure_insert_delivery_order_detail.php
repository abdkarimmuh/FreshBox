<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertDeliveryOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_delivery_order_detail');

        DB::unprepared('CREATE PROCEDURE insert_delivery_order_detail( IN delivery_order_id INT, IN item_id INT, IN sales_order_detail_id INT, IN qty_do DECIMAL(18, 2), IN uom_id INT, IN created_by INT )
        BEGIN
        INSERT INTO master_delivery_order_detail (delivery_order_id, item_id, sales_order_detail_id, qty_do, uom_id, returned, created_at, created_by) VALUES (delivery_order_id, item_id, sales_order_detail_id, qty_do, uom_id, 0, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_delivery_order_detail');
    }
}
