<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::updateOrCreate(['name' => 'Finance Head', 'slug' => 'finance-head', 'deletable' => false])
            ->permissions()
            ->sync($admin_permissions->pluck('id'));

        Role::updateOrCreate(['name' => 'Chief of Accounts', 'slug' => 'chief-of-accounts', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Accountant', 'slug' => 'accountant', 'deletable' => false]);
        Role::updateOrCreate(['name' => 'Accounts Executive', 'slug' => 'accounts-executive', 'deletable' => false]);
    }
}
