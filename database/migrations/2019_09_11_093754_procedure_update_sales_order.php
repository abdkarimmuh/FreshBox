<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateSalesOrder extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_sales_order');

        DB::unprepared('CREATE PROCEDURE update_sales_order(IN v_id INT, IN sales_order_no VARCHAR(20), IN source_order_id INT, IN customer_id INT, IN fulfillment_date DATE, IN remarks VARCHAR(191), IN status INT, IN file BINARY, IN updated_by INT )
        BEGIN
        UPDATE trx_sales_order SET sales_order_no = sales_order_no, source_order_id = source_order_id, customer_id = customer_id, fulfillment_date = fulfillment_date, remarks = remarks, status = status, file = file, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_sales_order');
    }
}
