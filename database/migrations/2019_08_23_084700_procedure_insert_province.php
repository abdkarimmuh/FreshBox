<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE insert_province( IN name VARCHAR(191), IN created_by INT )
        BEGIN
        insert into master_province (name, created_at, created_by) values (name, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_province');
    }
}
