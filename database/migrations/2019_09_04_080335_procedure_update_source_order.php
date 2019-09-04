<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateSourceOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_source_order');

        DB::unprepared('CREATE PROCEDURE update_source_order(IN v_id INT, IN name VARCHAR(100), IN description VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_source_order SET name = name, description = description, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_source_order');
    }
}
