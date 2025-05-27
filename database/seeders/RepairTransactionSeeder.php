<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding RepairTransactions...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_transactions NOCHECK CONSTRAINT ALL');

        // Clear the existing data
        DB::table('repair_transactions')->delete();

        // Sample repair transactions data
        $repairTransactions = [
            [
                'inspection_transaction_id' => 1, // Linked to the inspection transaction with repair decision
                'decision' => 'repaired',
                'created_at' => '2025-05-01 14:30:45',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 2, // Linked to the inspection transaction that's already repaired
                'decision' => 'scrap',
                'created_at' => '2025-05-03 16:45:22',
                'updated_at' => '2025-05-04 11:15:20',
                'updated_by' => null,  
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'inspection_transaction_id' => 3, // Linked to the inspection transaction with repair decision but not yet repaired
                'decision' => 'pending',
                'created_at' => '2025-05-05 09:20:15',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
        ];

        // Insert the data
        foreach (array_chunk($repairTransactions, 50) as $chunk) {
            DB::table('repair_transactions')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_transactions CHECK CONSTRAINT ALL');

        $this->command->info('RepairTransactions seeding completed successfully!');
    }
}
