<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin
        $role1 = Role::where('slug','finance-head')->first();
        User::updateOrCreate([
            'role_id' => $role1->id,
            'name' => 'Mahfuz',
            'email' => 'mahfuz@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => true
        ]);

        // Create user
        $role2 = Role::where('slug','chief-of-accounts')->first();
        User::updateOrCreate([
            'role_id' => $role2->id,
            'name' => 'Moshfeq',
            'email' => 'moshfeq@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => true
        ]);

        // Create user
        $role3 = Role::where('slug','accountant')->first();
        User::updateOrCreate([
            'role_id' => $role3->id,
            'name' => 'Tanzim',
            'email' => 'tanzim@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => true
        ]);

        // Create user
        $role4 = Role::where('slug','accounts-executive')->first();
        User::updateOrCreate([
            'role_id' => $role4->id,
            'name' => 'Shagor',
            'email' => 'shagor@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => true
        ]);
        // Create user
        $role1 = Role::where('slug','finance-head')->first();
        User::updateOrCreate([
            'role_id' => $role1->id,
            'name' => 'Mominul',
            'email' => 'mominul@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => true
        ]);


    }
}
