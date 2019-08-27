<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE insert_item( IN skuid INT, IN name_item VARCHAR(191), IN name_item_latin VARCHAR(191), IN description VARCHAR(191), IN category_id INT, IN uom_id INT, IN origin_id INT, IN created_by INT )
        BEGIN
        insert into master_item (skuid, name_item, name_item_latin, description, category_id, uom_id, origin_id, created_at, created_by) values (skuid, name_item, name_item_latin, description, category_id, uom_id, origin_id, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_item');
    }
}