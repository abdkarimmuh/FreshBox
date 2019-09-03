<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OriginTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_origin` (`id`, `origin_code`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'JKT', 'Area Jakarta', 1, NULL, NULL, '2019-05-05 10:00:00', NULL),
            (2, 'BDG', 'Area Bandung', 1, NULL, NULL, '2019-05-05 10:00:00', NULL);
        ");
    }
}
