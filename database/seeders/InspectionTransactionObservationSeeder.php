<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InspectionTransactionObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding InspectionTransactionObservations...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE inspection_transaction_observations NOCHECK CONSTRAINT ALL');

        // Clear the existing data first
        DB::table('inspection_transaction_observations')->delete();

        // Define a small sample of the observations data (the SQL file contains many entries)
        $observationsData = [
            [
                'inspection_transaction_id' => 1,
                'observation_id' => 1,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 2,
                'observation_id' => 1,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 3,
                'observation_id' => 8,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 4,
                'observation_id' => 7,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 5,
                'observation_id' => 7,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 6,
                'observation_id' => 7,
                'created_at' => now(),
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            // Add more records as needed - this is just a sample from the provided SQL
        ];

        // Insert the data in chunks to avoid potential memory issues
        foreach (array_chunk($observationsData, 50) as $chunk) {
            DB::table('inspection_transaction_observations')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE inspection_transaction_observations CHECK CONSTRAINT ALL');

        $this->command->info('InspectionTransactionObservations seeding completed successfully!');
    }
}
