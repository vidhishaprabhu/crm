<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $admin = Role::create(['name' => 'admin']);
        $sales = Role::create(['name' => 'sales']);

        $create = Permission::create(['name' => 'create contact']);
        $delete = Permission::create(['name' => 'delete contact']);

        $admin->givePermissionTo([$create, $delete]);
        $sales->givePermissionTo($create);

        $user = \App\Models\User::find(1);
        $user->assignRole('admin');
    }
}
