<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(ResidenceTableSeeder::class);
        $this->call(OriginTableSeeder::class);
        $this->call(UomTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(SourceOrderTableSeeder::class);
        $this->call(CustomerTypeTableSeeder::class);
        $this->call(CustomerGroupTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(PriceTableSeeder::class);
        $this->call(TrxSalesOrderTableSeeder::class);
        $this->call(TrxSalesOrderDetailTableSeeder::class);
    }
}
