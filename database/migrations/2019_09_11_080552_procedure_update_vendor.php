<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_vendor');

        DB::unprepared('CREATE PROCEDURE update_vendor(IN v_id INT, IN name VARCHAR(100), IN category_id INT, IN pic_vendor VARCHAR(191), IN tlp_pic VARCHAR(20), IN bank_account VARCHAR(191), IN bank_id INT, IN remarks VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_vendor SET name = name, category_id = category_id, pic_vendor = pic_vendor, tlp_pic = tlp_pic, bank_account = bank_account, bank_id = bank_id, remarks = remarks, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_vendor');
    }
}
