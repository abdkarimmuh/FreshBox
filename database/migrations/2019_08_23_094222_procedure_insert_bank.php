<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertBank extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_bank');

        DB::unprepared('CREATE PROCEDURE insert_bank( IN name VARCHAR(191), IN kode_bank VARCHAR(20), IN created_by INT )
        BEGIN
        INSERT INTO master_bank (name, kode_bank, created_at, created_by) VALUES (name, kode_bank, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_bank');
    }
}
