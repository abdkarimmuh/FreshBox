<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_item');

        DB::unprepared('CREATE PROCEDURE update_item(IN v_id INT, IN skuid INT, IN name_item VARCHAR(191), IN name_item_latin VARCHAR(191), IN description VARCHAR(191), IN is_trf_item VARCHAR(191), IN category_id INT, IN uom_id INT, IN origin_id INT, IN tax FLOAT, IN updated_by INT )
        BEGIN
        UPDATE master_item SET skuid = skuid, name_item = name_item, name_item_latin = name_item_latin, description = description, is_trf_item = is_trf_item, category_id = category_id, uom_id = uom_id, origin_id = origin_id, tax = tax, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_item');
    }
}
