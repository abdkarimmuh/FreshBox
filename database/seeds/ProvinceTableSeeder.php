<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO master_province (`id`, name, created_by, created_at, updated_by, `updated_at`) VALUES
            ('1', '-', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('2', 'NANGGRO ACEH DARUSALAM', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('3', 'SUMATERA UTARA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('4', 'SUMATERA BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('5', 'RIAU', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('6', 'KEPULAUAN RIAU', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('34', 'JAMBI', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('7', 'SUMATERA SELATAN', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('8', 'BANGKA BELITUNG', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('9', 'BENGKULU', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('10', 'LAMPUNG', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('11', 'DKI JAKARTA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('12', 'JAWA BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('13', 'BANTEN', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('14', 'JAWA TENGAH', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('15', 'DAERAH ISTIMEWA YOGYAKARTA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('16', 'JAWA TIMUR', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('17', 'BALI', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('18', 'NUSA TENGGARA BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('19', 'NUSA TENGGARA TIMUR', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('20', 'KALIMANTAN BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('21', 'KALIMANTAN TENGAH', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('22', 'KALIMANTAN SELATAN', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('23', 'KALIMANTAN TIMUR', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('24', 'SULAWESI UTARA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('25', 'GORONTALO', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('26', 'SULAWESI TENGAH', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('27', 'SULAWESI TENGGARA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('28', 'SULAWESI SELATAN', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('29', 'SULAWESI BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('30', 'MALUKU', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('31', 'MALUKU UTARA', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('32', 'PAPUA BARAT', 1, '2017-10-14 16:04:35', NULL, NULL),
            ('33', 'PAPUA', 1, '2017-10-14 16:04:35', NULL, NULL);
        ");
    }
}
