<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateDriver extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_driver');

        DB::unprepared('CREATE PROCEDURE update_driver(IN v_id INT, IN name VARCHAR(191), IN phone_number VARCHAR(20), IN vehicle_no VARCHAR(20), IN role INT, IN updated_by INT )
        BEGIN
        UPDATE master_driver SET name = name, phone_number = phone_number, vehicle_no = vehicle_no, role = role, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_driver');
    }
}
