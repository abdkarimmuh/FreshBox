<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertUom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE insert_uom( IN name VARCHAR(191), IN description VARCHAR(191), IN created_by INT )
        BEGIN
        insert into master_uom (name, description, created_at, created_by) values (name, description, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_uom');
    }
}
