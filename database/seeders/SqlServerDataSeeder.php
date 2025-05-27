<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SqlServerDataSeeder extends Seeder
{
    /**
     * Seed the database with data from the original SQL Server database.
     */
    public function run(): void
    {
        // The order matters due to foreign key constraints
        $this->call([
            TireTypeSeeder::class,        // Base data with no dependencies
            AbpUserSeeder::class,         // Users needed for creation/update references
            ObservationSeeder::class,     // Needed for inspection transaction observations
            RepairStepSeeder::class,      // Needed for repair transactions
            BarcodeSeeder::class,         // Barcodes for referencing
            InspectionTransactionSeeder::class,
            InspectionTransactionObservationSeeder::class,
            RepairTransactionSeeder::class,
            RepairTransactionRepairStepSeeder::class,
        ]);

        $this->command->info('All SQL Server data has been seeded successfully!');
    }
}
