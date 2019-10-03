<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertCustomer extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_customer');

        DB::unprepared('CREATE PROCEDURE insert_customer( IN customer_code VARCHAR(15), IN customer_type_id INT, IN customer_group_id INT, IN name VARCHAR(191), IN pic_customer VARCHAR(191), IN tlp_pic VARCHAR(20), IN address VARCHAR(500), IN province_id INT, IN residence_id INT, IN kodepos INT, IN longitude VARCHAR(191), IN latitude VARCHAR(191), IN created_by INT )
        BEGIN
        INSERT INTO master_customer (customer_code, customer_type_id, customer_group_id, name, pic_customer, tlp_pic, address, province_id, residence_id, kodepos, longitude, latitude, created_at, created_by) VALUES (customer_code, customer_type_id, customer_group_id, name, pic_customer, tlp_pic, address, province_id, residence_id, kodepos, longitude, latitude, now(), created_by);
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_customer');
    }
}
