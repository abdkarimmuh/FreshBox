<?php

use App\Model\Procurement\UserProcurement;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserProcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procRole = Role::create(['name' => 'Procurement']);
        $procurementUser = User::create([
            'name' => 'Procurement',
            'email' => 'procurement@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser->id,
            'saldo' => 1000,
            'bank_account' => 123,
            'bank_id' => 1,
            'category_id' => 1,
            'origin_id' => 1
        ]);
        $procurementUser->assignRole($procRole);
    }
}
