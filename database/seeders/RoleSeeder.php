<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'customer',
            'moderator'
        ];

        foreach ($roles as $roleName) {
            // Because of the HasUuids trait in your model, 
            // Laravel automatically generates the UUID for you!
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
}