<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateUom extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_uom');

        DB::unprepared('CREATE PROCEDURE update_uom(IN v_id INT, IN name VARCHAR(100), IN description VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_uom SET name = name, description = description, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_uom');
    }
}
