<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();
        if(empty($adminRole)){
            $adminRole = Role::create([
                'name' => 'Admin',
            ]);
        }

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if(empty($superAdminRole)) {
            $superAdminRole = Role::create([
                'name' => 'Super Admin'
            ]);
        }

        $customerRole = Role::where('name', 'Customer User')->first();
        if(empty($customerRole)) {
            $customerRole = Role::create([
                'name' => 'Customer User',
            ]);
        }

        $tenantRole = Role::where('name', 'Tenant User')->first();
        if(empty($tenantRole)) {
            Role::create([
                'name' => 'Tenant User',
            ]);
        }

        $workerRole = Role::where('name', 'Worker User')->first();
        if(empty($workerRole)) {
            Role::create([
                'name' => 'Worker User',
            ]);
        }
    }
}
