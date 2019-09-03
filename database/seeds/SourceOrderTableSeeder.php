<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_source_order` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'PO', 'Purchase Order', 1, NULL, NULL, '2019-05-02 03:00:00', NULL),
            (2, 'Email', 'Email', 1, NULL, NULL, '2019-05-02 03:00:00', NULL),
            (3, 'Whatsapp', 'Whatsapp', 1, NULL, NULL, '2019-05-02 03:00:00', NULL),
            (4, 'Telephone', 'Telephone', 1, NULL, NULL, '2019-05-02 03:00:00', NULL);
        ");
    }
}
