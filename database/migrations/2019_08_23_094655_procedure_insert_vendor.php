<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertVendor extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_vendor');

        DB::unprepared('CREATE PROCEDURE insert_vendor( IN name VARCHAR(191), IN category_id INT, IN users_id INT, IN pic_vendor VARCHAR(191), IN tlp_pic VARCHAR(20), IN bank_account VARCHAR(191), IN bank_id INT, IN ppn DECIMAL(18, 2), IN pph DECIMAL(18, 2), IN type_vendor INT, IN remarks VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_vendor (name, category_id, users_id, pic_vendor, tlp_pic, bank_account, bank_id, ppn, pph, type_vendor, remarks, created_at, created_by) VALUES (name, category_id, users_id, pic_vendor, tlp_pic, bank_account, bank_id, ppn, pph, type_vendor, remarks, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_vendor');
    }
}
