<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_price');

        DB::unprepared('CREATE PROCEDURE insert_price( IN skuid INT, IN uom_id INT, IN customer_id INT, IN amount DECIMAL(18, 2), IN tax_value DECIMAL(18, 2), IN start_periode DATE, IN end_periode DATE, IN remarks VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_price (skuid, uom_id, customer_id, amount, tax_value, start_periode, end_periode, remarks, created_at, created_by) VALUES (skuid, uom_id, customer_id, amount, tax_value, start_periode, end_periode, remarks, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_price');
    }
}
