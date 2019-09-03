<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_customer_type` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'B2B Small', 'Business to Business', 1, NULL, NULL, '2019-06-24 18:25:39', NULL),
            (2, 'B2C', 'Business to Client', 1, NULL, NULL, '2019-05-02 03:00:00', NULL),
            (3, 'Employee', 'Employee', 1, NULL, NULL, '2019-05-02 03:00:00', NULL),
            (4, 'Offline Store', 'Offline Store', 1, NULL, NULL, '2019-05-06 13:21:14', NULL),
            (5, 'B2B Medium', 'Business to  ', 1, NULL, NULL, '2019-06-24 18:26:15', NULL);
        ");
    }
}
