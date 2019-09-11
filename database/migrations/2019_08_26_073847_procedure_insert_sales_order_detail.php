<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertSalesOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_sales_order_detail');

        DB::unprepared('CREATE PROCEDURE insert_sales_order_detail( IN sales_order_id INT, IN skuid INT, IN uom_id INT, IN qty DECIMAL(18, 2), IN amount_price DECIMAL(18, 2), IN tax_value DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN notes VARCHAR(191), IN status INT, IN created_by INT )
        BEGIN
        INSERT INTO master_sales_order_detail (sales_order_id, skuid, uom_id, qty, amount_price, tax_value, total_amount, notes, status, created_at, created_by) VALUES (sales_order_id, skuid, uom_id, qty, amount_price, tax_value, total_amount, notes, status, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_sales_order_detail');
    }
}
