<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use PermissionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run the default seeders
        $this->call([
            PermissionsTableSeeder::class,
            SuperUserSeeder::class,
            TireTypeSeeder::class,
            ObservationSeeder::class,
            InspectionTransactionSeeder::class,
            InspectionTransactionObservationSeeder::class,
            RepairStepSeeder::class,
            RepairTransactionSeeder::class,
            RepairTransactionRepairStepSeeder::class,
        ]);

        // Run the comprehensive SQL Server data seeder
        // This includes all table seeders in the correct order
        // $this->call(SqlServerDataSeeder::class);
    }
}
