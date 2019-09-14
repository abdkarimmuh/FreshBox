<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertDeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_delivery_order');

        DB::unprepared('CREATE PROCEDURE insert_delivery_order( IN delivery_order_no VARCHAR(15), IN sales_order_id INT, IN customer_id INT, IN do_date DATE, IN confrim_date DATE, IN driver_id INT, IN created_by INT )
        BEGIN
        INSERT INTO trx_delivery_order (delivery_order_no, sales_order_id, customer_id, do_date, confirm_date, driver_id, created_at, created_by) VALUES (delivery_order_no, sales_order_id, customer_id, do_date, confrim_date, driver_id, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_delivery_order');
    }
}
