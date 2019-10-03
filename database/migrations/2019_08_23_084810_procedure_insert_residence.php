<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertResidence extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_residence');

        DB::unprepared('CREATE PROCEDURE insert_residence( IN name VARCHAR(191), IN province_id INT, IN created_by INT )
        BEGIN
        INSERT INTO master_residence (name, province_id, created_at, created_by) VALUES (name, province_id, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_residence');
    }
}
