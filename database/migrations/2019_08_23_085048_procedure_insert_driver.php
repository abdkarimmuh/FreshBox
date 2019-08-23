<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE insert_driver( IN driver_name VARCHAR(191), IN phone_number VARCHAR(15), IN created_by INT )
        BEGIN
        insert into master_driver (driver_name, phone_number, created_at, created_by) values (driver_name, phone_number, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_driver');
    }
}
