<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InspectionTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding InspectionTransactions...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE inspection_transactions NOCHECK CONSTRAINT ALL');

        // Clear the existing data
        DB::table('inspection_transactions')->delete();

        // Sample inspection transactions based on the SQL file data
        $transactions = [
            [
                // 'id' => 60,
                'barcode' => 'TIRE-20250101-00001',
                'tire_type_id' => 1,
                'decision' => 'Pending',
                'is_repaired' => 0,
                'building_date' => '2025-05-01 10:15:22',
                'machine' => 'VMI Maxx',
                'operator_name' => 'Ahmed Ibrahim',
                'operator_code' => 'AIB001',
                'created_at' => '2025-05-01 10:15:22',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 61,
                'barcode' => 'TIRE-20250102-00002',
                'tire_type_id' => 2,
                'decision' => 'Repair',
                'is_repaired' => 0,
                'building_date' => '2025-05-01 11:20:33',
                'machine' => 'HF TBR-1',
                'operator_name' => 'Fatima Al-Sayed',
                'operator_code' => 'FAS002',
                'created_at' => '2025-05-01 11:20:33',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 62,
                'barcode' => 'TIRE-20250103-00003',
                'tire_type_id' => 2,
                'decision' => 'Scrap',
                'is_repaired' => 0,
                'building_date' => '2025-05-02 09:05:19',
                'machine' => 'Harburg Freudenberger',
                'operator_name' => 'Mohammed Ali',
                'operator_code' => 'MAL003',
                'created_at' => '2025-05-02 09:05:19',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 63,
                'barcode' => 'TIRE-20250104-00004',
                'tire_type_id' => 1,
                'decision' => 'Pending',
                'is_repaired' => 0,
                'building_date' => '2025-05-02 14:25:41',
                'machine' => 'Kobelco KBKC',
                'operator_name' => 'Sara Hassan',
                'operator_code' => 'SHA004',
                'created_at' => '2025-05-02 14:25:41',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 64,
                'barcode' => 'TIRE-20250105-00005',
                'tire_type_id' => 2,
                'decision' => 'Repair',
                'is_repaired' => 1,
                'building_date' => '2025-05-03 10:10:10',
                'machine' => 'Rogers CP-700',
                'operator_name' => 'Omar Khalid',
                'operator_code' => 'OKH005',
                'created_at' => '2025-05-03 10:10:10',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => '2025-05-04 11:15:20',
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 65,
                'barcode' => 'TIRE-20250106-00006',
                'tire_type_id' => 2,
                'decision' => 'Repair',
                'is_repaired' => 0,
                'building_date' => '2025-05-04 08:45:30',
                'machine' => 'Mitsubishi HT-Series',
                'operator_name' => 'Aisha Ahmed',
                'operator_code' => 'AAH006',
                'created_at' => '2025-05-04 08:45:30',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                // 'id' => 66,
                'barcode' => 'TIRE-20250107-00007',
                'tire_type_id' => 1,
                'decision' => 'Pending',
                'is_repaired' => 0,
                'building_date' => '2025-05-05 16:20:15',
                'machine' => 'Bridgestone AutoSpecial',
                'operator_name' => 'Youssef Mahmoud',
                'operator_code' => 'YMA007',
                'created_at' => '2025-05-05 16:20:15',
                // 'created_by' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ]
        ];

        // Insert the data
        foreach (array_chunk($transactions, 50) as $chunk) {
            DB::table('inspection_transactions')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE inspection_transactions CHECK CONSTRAINT ALL');

        $this->command->info('InspectionTransactions seeding completed successfully!');
    }
}
