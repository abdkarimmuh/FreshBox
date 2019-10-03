<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertProvince extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_province');

        DB::unprepared('CREATE PROCEDURE insert_province( IN name VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_province (name, created_at, created_by) VALUES (name, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_province');
    }
}
