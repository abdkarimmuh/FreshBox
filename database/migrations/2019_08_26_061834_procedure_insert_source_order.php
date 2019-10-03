<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertSourceOrder extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_source_order');

        DB::unprepared('CREATE PROCEDURE insert_source_order( IN name VARCHAR(191), IN description VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_source_order (name, description, created_at, created_by) VALUES (name, description, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_source_order');
    }
}
