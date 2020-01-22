<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::statement("
            INSERT INTO `master_category` (`id`, `name`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'Sayuran', 1, NULL, NULL, '2019-05-06 19:15:24', NULL),
            (2, 'Buah Lokal', 1, NULL, NULL, '2019-05-06 19:15:24', NULL),
            (3, 'Buah Import', 1, NULL, NULL, '2019-05-06 19:15:24', NULL),
            (4, 'Bahan Pokok', 1, NULL, NULL, '2019-05-06 19:15:24', NULL),
            (5, 'Bahan Makanan', 1, NULL, NULL, '2019-05-06 19:15:24', NULL),
            (6, 'Hydroponic', 1, NULL, NULL, '2019-05-07 10:00:00', NULL);
            (8, 'Buah', 1, NULL, NULL, '2019-05-07 10:00:00', NULL);
            (9, 'Other', 1, NULL, NULL, '2019-05-07 10:00:00', NULL);
        ");
    }
}
