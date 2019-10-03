<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertCategory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_category');

        DB::unprepared('CREATE PROCEDURE insert_category( IN name VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_category (name, created_at, created_by) VALUES (name, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_category');
    }
}
