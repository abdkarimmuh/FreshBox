<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_driver');

        DB::unprepared('CREATE PROCEDURE update_driver(IN v_id INT, IN name VARCHAR(191), IN phone_number VARCHAR(20), IN updated_by INT )
        BEGIN
        UPDATE master_driver SET name = name, phone_number = phone_number, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_driver');
    }
}
