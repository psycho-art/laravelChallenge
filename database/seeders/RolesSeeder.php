<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // No Permisions for client by default
        $clientRole = Role::firstOrCreate(['name' => 'Client']);
    }
}

