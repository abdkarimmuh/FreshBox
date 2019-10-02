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

        $procurementUser1 = User::create([
            'name' => 'Procurement 1',
            'email' => 'procurement1@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser1->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 1,
            'category_id' => 1,
            'origin_id' => 1
        ]);
        $procurementUser1->assignRole($procRole);

        $procurementUser2 = User::create([
            'name' => 'Procurement 2',
            'email' => 'procurement2@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser2->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 2,
            'category_id' => 2,
            'origin_id' => 1
        ]);
        $procurementUser2->assignRole($procRole);

        $procurementUser3 = User::create([
            'name' => 'Procurement 3',
            'email' => 'procurement3@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser3->id,
            'saldo' => 4800000,
            'bank_account' => 123,
            'bank_id' => 3,
            'category_id' => 3,
            'origin_id' => 1
        ]);
        $procurementUser3->assignRole($procRole);

        $procurementUser4 = User::create([
            'name' => 'Procurement 4',
            'email' => 'procurement4@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser4->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 1,
            'category_id' => 4,
            'origin_id' => 1
        ]);
        $procurementUser4->assignRole($procRole);

        $procurementUser5 = User::create([
            'name' => 'Procurement 5',
            'email' => 'procurement5@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser5->id,
            'saldo' => 4800000,
            'bank_account' => 123,
            'bank_id' => 2,
            'category_id' => 5,
            'origin_id' => 1
        ]);
        $procurementUser5->assignRole($procRole);

        $procurementUser6 = User::create([
            'name' => 'Procurement 6',
            'email' => 'procurement6@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser6->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 3,
            'category_id' => 6,
            'origin_id' => 1
        ]);
        $procurementUser6->assignRole($procRole);

        $procurementUser7 = User::create([
            'name' => 'Procurement 7',
            'email' => 'procurement7@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser7->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 1,
            'category_id' => 1,
            'origin_id' => 2
        ]);
        $procurementUser7->assignRole($procRole);

        $procurementUser8 = User::create([
            'name' => 'Procurement 8',
            'email' => 'procurement8@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser8->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 2,
            'category_id' => 2,
            'origin_id' => 2
        ]);
        $procurementUser8->assignRole($procRole);

        $procurementUser9 = User::create([
            'name' => 'Procurement 9',
            'email' => 'procurement9@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser9->id,
            'saldo' => 4800000,
            'bank_account' => 123,
            'bank_id' => 3,
            'category_id' => 3,
            'origin_id' => 2
        ]);
        $procurementUser9->assignRole($procRole);

        $procurementUser10 = User::create([
            'name' => 'Procurement 10',
            'email' => 'procurement10@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser10->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 1,
            'category_id' => 4,
            'origin_id' => 2
        ]);
        $procurementUser10->assignRole($procRole);

        $procurementUser11 = User::create([
            'name' => 'Procurement 11',
            'email' => 'procurement11@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser11->id,
            'saldo' => 4800000,
            'bank_account' => 123,
            'bank_id' => 2,
            'category_id' => 5,
            'origin_id' => 2
        ]);
        $procurementUser11->assignRole($procRole);

        $procurementUser12 = User::create([
            'name' => 'Procurement 12',
            'email' => 'procurement12@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProcurement::create([
            'user_id' => $procurementUser12->id,
            'saldo' => 5000000,
            'bank_account' => 123,
            'bank_id' => 3,
            'category_id' => 6,
            'origin_id' => 2
        ]);
        $procurementUser12->assignRole($procRole);
    }
}
