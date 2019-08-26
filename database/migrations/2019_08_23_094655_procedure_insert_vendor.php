<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureInsertVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE insert_vendor( IN name VARCHAR(191), IN category_id INT, IN pic_vendor VARCHAR(191), IN tlp_pic VARCHAR(20), IN bank_account VARCHAR(191), IN bank_id INT, IN remarks VARCHAR(191), IN created_by INT )
        BEGIN
        insert into master_vendor (name, category_id, pic_vendor, tlp_pic, bank_account, bank_id, remarks, created_at, created_by) values (name, category_id, pic_vendor, tlp_pic, bank_account, bank_id, remarks, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_vendor');
    }
}
