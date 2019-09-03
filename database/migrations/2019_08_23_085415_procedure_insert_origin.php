<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertOrigin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_origin');

        DB::unprepared('CREATE PROCEDURE insert_origin( IN origin_code VARCHAR(100), IN description VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_origin (origin_code, description, created_at, created_by) VALUES (origin_code, description, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_origin');
    }
}
