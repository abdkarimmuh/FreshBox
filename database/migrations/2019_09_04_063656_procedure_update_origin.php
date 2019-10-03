<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateOrigin extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_origin');

        DB::unprepared('CREATE PROCEDURE update_origin(IN v_id INT, IN origin_code VARCHAR(100), IN description VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_origin SET origin_code = origin_code, description = description, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_origin');
    }
}
