<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return DB::statement("
            INSERT INTO `master_bank` (`id`, `name`, `kode_bank`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
            (1, 'Bank Negara Indonesia', 'BNI', 1, NULL, '2019-05-06 19:15:24', NULL),
            (2, 'Bank Mandiri', 'Mandiri', 1, NULL, '2019-05-06 19:15:24', NULL),
            (3, 'Bank Republik Indonesia', 'BRI', 1, NULL, '2019-05-06 19:15:24', NULL);
        ");
    }
}
