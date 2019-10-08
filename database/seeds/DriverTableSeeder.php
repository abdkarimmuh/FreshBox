<?php

use App\Model\MasterData\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_driver')->insert(['name' => 'John', 'role' => 1, 'phone_number' => '08966', 'created_by' => 1]);
        DB::table('master_driver')->insert(['name' => 'John PIC', 'role' => 2, 'phone_number' => '08966444', 'created_by' => 1]);
    }
}
