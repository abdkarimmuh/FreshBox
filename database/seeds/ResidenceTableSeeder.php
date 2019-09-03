<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResidenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_residence` (`id`, `province_id`, `name`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 12, 'Kota Depok', 1, NULL, NULL, '2019-06-24 18:25:39', NULL),
            (2, 12, 'Kota Bekasi', 1, NULL, NULL, '2019-05-02 03:00:00', NULL);
        ");
    }
}
