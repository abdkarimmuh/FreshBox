<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
        INSERT INTO master_customer (`id`, customer_code, customer_type_id, customer_group_id, name, pic_customer, tlp_pic, address, province_id, residence_id, kodepos, longitude, latitude, created_by, updated_by, deleted_at, created_at, `updated_at`) VALUES
        (1, 'KIT', 1, 1, 'Kitchenette (Plaza Indonesia)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (2, 'KIT', 1, 1, 'Kitchenette (Gancit)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (3, 'KIT', 1, 1, 'Kitchenette (Central Park)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (4, 'TPC', 1, 2, 'The People\'s Café (PVJ)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (5, 'TPC', 1, 2, 'The People\'s Café (Pasaraya)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (6, 'TPC', 1, 2, 'The People\'s Café (SMS)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (7, 'SUM', 1, 3, 'Sumoboo (Grand Indonesia)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (8, 'SUM', 1, 3, 'Sumoboo (Central Park)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (9, 'SUM', 1, 3, 'Sumoboo (PIK)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (10, 'BEN', 1, 4, 'Benedict (Grand Indonesia)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (11, 'BEN', 1, 4, 'Benedict (Pacific Place)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (12, 'BLT', 1, 5, 'Bakso Lap. Tembak (Pondok Gede)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (13, 'BLT', 1, 5, 'Bakso Lap. Tembak (Alam Sutera)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (14, 'BLT', 1, 5, 'Bakso Lap. Tembak (Karawaci)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (15, 'BLT', 1, 5, 'Bakso Lap. Tembak (Buaran Plaza)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (16, 'BLT', 1, 5, 'Bakso Lap. Tembak (Cipinang)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
        (17, 'BHA', 1, 6, 'Beer Hall (SCBD)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (18, 'FUJ', 1, 7, 'FŪJIN (Gunawarman)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (19, 'MMO', 1, 8, 'Mother Monster (Thamrin)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (20, 'BIS', 1, 9, 'Bistecca (Thamrin)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (21, 'PBK', 1, 10, 'PARDON Bar & Kitchen (Tanah Abang)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (22, 'UIS', 1, 11, 'Up In Smoke (RDTX)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (23, 'LCA', 1, 12, 'Lewis & Caroll (Kebayoran)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (24, 'SAH', 1, 13, 'SAHAJA (Semanggi)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (25, 'ARG', 1, 14, 'Aroma Gelato (Senayan City)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (26, 'HHK', 1, 15, 'Hustle House Kristal (Asia Afrika)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (27, 'AGE', 1, 16, 'Ayam Geprek (Rasuna Said)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (28, 'FSH', 1, 17, 'Fat Shogun & Fat Odon (Menara BTN)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (29, 'DEC', 1, 18, 'Devon Café (Asia Afrika)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (30, 'TPD', 1, 19, 'The Plunge Dining & Co. (Kembangan)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (31, 'BAR', 1, 20, 'Bara (Kemang)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL),
        (32, 'ALF', 1, 21, 'Alfred (Thamrin)', '', '', '', 1, 1, NULL, NULL, NULL, 1, NULL, NULL, '2019-06-19 10:00:00', NULL);
        ");
    }
}
