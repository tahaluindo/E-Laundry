<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testTenant = Tenant::where('name', 'Testing')->first();
        if(empty($testTenant)){
            $testTenant = Tenant::create([
                'name' => "Testing Tenant",
                'address' => "Jl.Testing No 24"
            ]);
        }
    }
}
