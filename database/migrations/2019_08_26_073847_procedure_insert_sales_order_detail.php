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
        DB::unprepared('CREATE PROCEDURE insert_sales_order_detail( IN sales_order_id INT, IN skuid INT, IN uom_id INT, IN qty DECIMAL(18, 2), IN amount_price DECIMAL(18, 2), IN total_amount DECIMAL(18, 2), IN notes VARCHAR(191), IN created_by INT )
        BEGIN
        insert into master_sales_order_detail (sales_order_id, skuid, uom_id, qty, amount_price, total_amount, notes, created_at, created_by) values (sales_order_id, skuid, uom_id, qty, amount_price, total_amount, notes, now(), created_by);
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
