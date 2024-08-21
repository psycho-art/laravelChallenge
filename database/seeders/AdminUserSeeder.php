<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class AdminUserSeeder extends Seeder
{
    public function run()
    {
       // Create the admin role if it doesn't already exist
       $role = Role::firstOrCreate(['name' => 'Admin']);

       // Create the admin user
       $user = User::create([
           'name' => 'Admin User',
           'email' => 'admin@example.com',
           'password' => Hash::make('password'),
       ]);

       // Assign the 'admin' role to the user
       $user->assignRole('Admin');
    }
}

