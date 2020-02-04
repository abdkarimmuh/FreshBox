<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateVendor extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_vendor');

        DB::unprepared('CREATE PROCEDURE update_vendor(IN v_id INT, IN name VARCHAR(100), IN category_id INT, IN users_id INT, IN pic_vendor VARCHAR(191), IN tlp_pic VARCHAR(20), IN bank_account VARCHAR(191), IN bank_id INT,IN ppn DECIMAL(18, 2), IN pph DECIMAL(18, 2), IN type_vendor INT, IN remarks VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_vendor SET name = name, category_id = category_id, users_id = users_id, pic_vendor = pic_vendor, tlp_pic = tlp_pic, bank_account = bank_account, bank_id = bank_id, ppn = ppn, pph = pph, type_vendor = type_vendor, remarks = remarks, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_vendor');
    }
}
