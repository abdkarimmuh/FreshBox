<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateCategory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_category');

        DB::unprepared('CREATE PROCEDURE update_category(IN v_id INT, IN name VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_category SET name = name, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_category');
    }
}
