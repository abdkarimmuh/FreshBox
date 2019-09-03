<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_customer_group` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'Kitchenette', 'Kitchenette Group', 1, 1, NULL, NULL, NULL),
            (2, 'The People\'s Cafe', 'The People\'s Café  Group', 1, NULL, NULL, NULL, NULL),
            (3, 'Sumoboo', 'Sumoboo Group', 1, NULL, NULL, NULL, NULL),
            (4, 'Benedict', 'Benedict Group', 1, NULL, NULL, NULL, NULL),
            (5, 'Bakso Lap. Tembak', 'Bakso Lap. Tembak Group', 1, NULL, NULL, NULL, NULL),
            (6, 'Beer Hall', 'Beer Hall Group', 1, NULL, NULL, NULL, NULL),
            (7, 'FŪJIN', 'FŪJIN Japanese Teppanyaki & Sake', 1, NULL, NULL, NULL, NULL),
            (8, 'Mother Monster', 'Mother Monster', 1, NULL, NULL, NULL, NULL),
            (9, 'Bistecca', 'Bistecca', 1, NULL, NULL, NULL, NULL),
            (10, 'PARDON Bar & Kitchen', 'PARDON Bar & Kitchen', 1, NULL, NULL, NULL, NULL),
            (11, 'Up In Smoke', 'Up In Smoke', 1, NULL, NULL, NULL, NULL),
            (12, 'Lewis & Caroll', 'Lewis & Caroll', 1, NULL, NULL, NULL, NULL),
            (13, 'SAHAJA', 'SAHAJA', 1, NULL, NULL, NULL, NULL),
            (14, 'Aroma Gelato', 'Aroma Gelato', 1, NULL, NULL, NULL, NULL),
            (15, 'Hustle House Kristal', 'Hustle House Kristal', 1, NULL, NULL, NULL, NULL),
            (16, 'Ayam Geprek', 'Ayam Geprek', 1, NULL, NULL, NULL, NULL),
            (17, 'Fat Shogun & Fat Odon', 'Fat Shogun & Fat Odon', 1, NULL, NULL, NULL, NULL),
            (18, 'Devon Café ', 'Devon Café ', 1, NULL, NULL, NULL, NULL),
            (19, 'The Plunge Dining & Co.', 'The Plunge Dining & Co.', 1, NULL, NULL, NULL, NULL),
            (20, 'Bara', 'Bara', 1, NULL, NULL, NULL, NULL),
            (21, 'Alfred', 'Alfred', 1, NULL, NULL, NULL, NULL);
        ");
    }
}
