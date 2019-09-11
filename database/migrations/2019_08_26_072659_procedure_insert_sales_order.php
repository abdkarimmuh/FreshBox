<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertSalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_sales_order');

        DB::unprepared('CREATE PROCEDURE insert_sales_order( IN sales_order_no VARCHAR(20), IN source_order_id INT, IN customer_id INT, IN fulfillment_date DATE, IN remarks VARCHAR(191), IN status INT, IN file BINARY, IN created_by INT )
        BEGIN
        INSERT INTO trx_sales_order (sales_order_no, source_order_id, customer_id, fulfillment_date, remarks, status, file, created_at, created_by) VALUES (sales_order_no, source_order_id, customer_id, fulfillment_date, remarks, status, file, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_sales_order');
    }
}
