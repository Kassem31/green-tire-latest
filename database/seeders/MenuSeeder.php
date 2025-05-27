<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // 0 for admin and clinic , 1 for admin only , 2 for clinic only
        Menu::truncate();

        $order = 2;
        // User Management

        $users = Menu::create([
            'name'       => 'Users Management',
            'order'      => $order++,
            'permission' => 'list_user',
            'svg'        => 'svg/users.svg', // Users management icon
            // 'panel_type' => '1',
        ]);

        $subOrder = 1;
        Menu::create([
            'name'       => 'Users',
            'route'      => 'users.index',
            'parent_id'  => $users->id,
            'order'      => $subOrder++,
            'permission' => 'list_user',
            // 'panel_type' => '1',
        ]);

        Menu::create([
            'name'       => 'Roles',
            'route'      => 'roles.index',
            'parent_id'  => $users->id,
            'order'      => $subOrder++,
            'permission' => 'list_role',
            // 'panel_type' => '1',
        ]);

        // observations Management
        $observations = Menu::create([
            'name'       => 'Observations',
            'order'      => $order++,
            'permission' => 'list_observations',
            // 'panel_type' => '1',
            'svg'        => 'svg/observation.svg', // Observation/inspection icon
            'route'      => 'observations.index',
        ]);
        $subOrder = 1;
        Menu::create([
            'name'       => 'All Observations',
            'route'      => 'observations.index',
            'parent_id'  => $observations->id,
            'order'      => $subOrder++,
            'permission' => 'list_observations',
            // 'panel_type' => '1',
        ]);




        $repair_steps = Menu::create([
            'name'       => 'Repair Steps',
            'order'      => $order++,
            'permission' => 'list_repair_steps',
            // 'panel_type' => '1',
            'svg'        => 'svg/repair.svg', // Repair/tools icon
            'route'      => 'repair-steps.index',
        ]);
        $subOrder = 1;
        Menu::create([
            'name'       => 'All Repair Steps',
            'route'      => 'repair-steps.index',
            'parent_id'  => $repair_steps->id,
            'order'      => $subOrder++,
            'permission' => 'list_repair_steps',
            // 'panel_type' => '1',
        ]);






        $inspection_transactions = Menu::create([
            'name'       => 'Inspection Transactions',
            'order'      => $order++,
            'permission' => 'list_inspection_transactions',
            'svg'        => 'svg/transaction.svg', // Transaction/clipboard icon
            // 'panel_type' => '1',
        ]);
        $subOrder = 1;
        Menu::create([
            'name'       => 'All Transactions',
            'route'      => 'inspection-transactions.index',
            'parent_id'  => $inspection_transactions->id,
            'order'      => $subOrder++,
            'permission' => 'list_inspection_transactions',
            // 'panel_type' => '1',
        ]);
        
        Menu::create([
            'name'       => 'Pending Transactions',
            'route'      => 'repair-transactions.pending',
            'parent_id'  => $inspection_transactions->id,
            'order'      => $subOrder++,
            'permission' => 'list_pending_transactions',
            // 'panel_type' => '1',
        ]);


        



    }
}
