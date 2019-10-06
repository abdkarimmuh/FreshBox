<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertDriver extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_driver');

        DB::unprepared('CREATE PROCEDURE insert_driver( IN name VARCHAR(191), IN phone_number VARCHAR(20), IN vehicle_no VARCHAR(20), IN created_by INT )
        BEGIN
        INSERT INTO master_driver (name, phone_number, vehicle_no, created_at, created_by) VALUES (name, phone_number, vehicle_no, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_driver');
    }
}
