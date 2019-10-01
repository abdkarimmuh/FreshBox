<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $adminPermissions = ['manage-users', 'view-users', 'create-users', 'edit-users', 'delete-users'];
        foreach ($adminPermissions as $ap) {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
        }
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234')
        ]);
        $adminUser->assignRole($adminRole);

        $procRole = Role::create(['name' => 'Procurement']);
        $procurementUser = User::create([
            'name' => 'Procurement',
            'email' => 'procurement@example.com',
            'password' => Hash::make('1234')
        ]);
        UserProc::create([
            'user_id' => $procurementUser->id,
            'saldo' => 1000,

        ]);
        $procurementUser->assignRole($procRole);
    }
}
