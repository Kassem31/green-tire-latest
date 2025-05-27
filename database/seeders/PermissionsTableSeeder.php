<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laratrust\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {

        $permissions = [
            'list_user',
            'show_user',
            'create_user',
            'edit_user',
            'delete_user',
            'list_role',
            'show_role',
            'edit_role',
            'create_role',
            'delete_role',
            'list_observations',
            'list_repair_steps',
            'list_inspection_transactions',
            'list_pending_transactions',
            
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'display_name' => ucfirst(str_replace('_', ' ', $permission)),
                'description' => 'Allows a user to ' . str_replace('_', ' ', $permission),
            ]);
        }
    }
}
