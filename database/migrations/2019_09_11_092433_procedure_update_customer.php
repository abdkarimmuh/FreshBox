<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureUpdateCustomer extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_customer');

        DB::unprepared('CREATE PROCEDURE update_customer(IN v_id INT, IN customer_code VARCHAR(15), IN customer_type_id INT, IN customer_group_id INT, IN name VARCHAR(191), IN pic_customer VARCHAR(191), IN tlp_pic VARCHAR(20), IN address VARCHAR(500), IN province_id INT, IN residence_id INT, IN kodepos INT, IN longitude VARCHAR(191), IN latitude VARCHAR(191), IN updated_by INT )
        BEGIN
        UPDATE master_customer SET name = name, customer_code = customer_code, customer_type_id = customer_type_id, customer_group_id = customer_group_id, name = name, pic_customer = pic_customer, tlp_pic = tlp_pic, address = address, province_id = province_id, residence_id = residence_id, kodepos = kodepos, longitude = longitude, latitude = latitude, updated_by = updated_by, updated_at = now() WHERE id = v_id;
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_customer');
    }
}
