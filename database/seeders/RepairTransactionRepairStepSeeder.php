<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairTransactionRepairStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding RepairTransactionRepairSteps...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_transaction_repair_steps NOCHECK CONSTRAINT ALL');

        // Clear the existing data
        DB::table('repair_transaction_repair_steps')->delete();

        // Sample repair transaction repair steps data
        $repairTransactionSteps = [
            // For the completed repair transaction ID 1
            [
                'repair_transaction_id' => 1,
                'repair_step_id' => 1, // Surface Cleaning
                'created_at' => '2025-05-01 14:35:10',
                'updated_at' => '2025-05-01 14:40:22',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 1,
                'repair_step_id' => 2, // Inspection
                'created_at' => '2025-05-01 14:41:05',
                'updated_at' => '2025-05-01 14:50:18',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 1,
                'repair_step_id' => 5, // Apply Rubber Patch
                'created_at' => '2025-05-01 14:55:30',
                'updated_at' => '2025-05-01 15:10:45',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 1,
                'repair_step_id' => 7, // Final Inspection
                'created_at' => '2025-05-01 15:15:25',
                'updated_at' => '2025-05-01 15:25:10',
                'deleted_by' => null,
                'deleted_at' => null
            ],

            // For the completed repair transaction ID 2
            [
                'repair_transaction_id' => 2,
                'repair_step_id' => 1, // Surface Cleaning
                'created_at' => '2025-05-03 16:50:10',
                'updated_at' => '2025-05-03 17:00:15',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 2,
                'repair_step_id' => 3, // Buffing
                'created_at' => '2025-05-03 17:05:30',
                'updated_at' => '2025-05-03 17:25:40',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 2,
                'repair_step_id' => 4, // Fill Damaged Area
                'created_at' => '2025-05-03 17:30:10',
                'updated_at' => '2025-05-03 17:50:22',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 2,
                'repair_step_id' => 6, // Vulcanization
                'created_at' => '2025-05-03 17:55:30',
                'updated_at' => '2025-05-04 11:10:15',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 2,
                'repair_step_id' => 7, // Final Inspection
                'created_at' => '2025-05-04 11:15:20',
                'updated_at' => '2025-05-04 11:30:45',
                'deleted_by' => null,
                'deleted_at' => null
            ],

            // For the in-progress repair transaction ID 3
            [
                'repair_transaction_id' => 3,
                'repair_step_id' => 1, // Surface Cleaning
                'created_at' => '2025-05-05 09:25:10',
                'updated_at' => '2025-05-05 09:35:20',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 3,
                'repair_step_id' => 2, // Inspection
                'created_at' => '2025-05-05 09:40:15',
                'updated_at' => '2025-05-05 10:00:30',
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'repair_transaction_id' => 3,
                'repair_step_id' => 3, // Buffing
                'created_at' => '2025-05-05 10:05:10',
                'updated_at' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ]
        ];

        // Insert the data
        foreach (array_chunk($repairTransactionSteps, 50) as $chunk) {
            DB::table('repair_transaction_repair_steps')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_transaction_repair_steps CHECK CONSTRAINT ALL');

        $this->command->info('RepairTransactionRepairSteps seeding completed successfully!');
    }
}
