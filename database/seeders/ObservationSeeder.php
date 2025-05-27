<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Observations...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE Observations NOCHECK CONSTRAINT ALL');

        // Clear the existing data
        DB::table('Observations')->delete();

        // Create a set of observations based on the IDs used in InspectionTransactionObservations
        // The SQL file shows only the ID column, but we'll add some sample data
        $observationIds = [1, 2, 7, 8, 15, 21, 22, 23, 29, 30, 32, 33];

        $observations = [];
        foreach ($observationIds as $id) {
            $observations[] = [
                // 'Id' => $id,
                'name_en' => 'Observation Type ' . $id,
                'name_ar' => 'نوع الملاحظة ' . $id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Insert the data in chunks
        foreach (array_chunk($observations, 50) as $chunk) {
            DB::table('Observations')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE Observations CHECK CONSTRAINT ALL');

        $this->command->info('Observations seeding completed successfully!');
    }
}
