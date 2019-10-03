<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateBank extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_bank');

        DB::unprepared('CREATE PROCEDURE update_bank( IN v_id INT, IN name VARCHAR(191), IN kode_bank VARCHAR(20), IN updated_by INT )
        BEGIN
        UPDATE master_bank SET name = name, kode_bank = kode_bank, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_bank');
    }
}
