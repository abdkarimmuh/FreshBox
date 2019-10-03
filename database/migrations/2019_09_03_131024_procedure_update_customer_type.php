<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateCustomerType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_customer_type');

        DB::unprepared('CREATE PROCEDURE update_customer_type(IN v_id INT, IN name VARCHAR(191), IN description VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_customer_type SET name = name, description = description, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_customer_type');
    }
}
