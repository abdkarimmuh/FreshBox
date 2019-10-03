<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateResidence extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_residence');

        DB::unprepared('CREATE PROCEDURE update_residence(IN v_id INT, IN name VARCHAR(191), IN province_id INT, IN updated_by INT )
        BEGIN
        UPDATE master_residence SET name = name, province_id = province_id, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_residence');
    }
}
