<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrxSalesOrderDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `trx_sales_order_detail` (`id`, `sales_order_id`, `skuid`, `uom_id`, `qty`, `amount_price`, `total_amount`, `notes`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 20, 10080, 1, '5.00', '5000.00', '25000.00', 'asdas', 1, NULL, NULL, NULL, NULL),
            (2, 20, 10074, 1, '3.00', '5000.00', '15000.00', 'asdasd', 1, NULL, NULL, NULL, NULL),
            (3, 45, 10006, 1, '10.00', '1000.00', '10000.00', 'sepulu', 1, NULL, NULL, NULL, NULL),
            (4, 45, 10012, 1, '5.00', '1000.00', '5000.00', 'lima', 1, NULL, NULL, NULL, NULL);
        ");
    }
}
