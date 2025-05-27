<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding RepairSteps...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_steps NOCHECK CONSTRAINT ALL');

        // Clear the existing data
        DB::table('repair_steps')->delete();

        // Common repair steps data
        $repairSteps = [
            [
                'name_en' => 'Surface Cleaning',
                'name_ar' => 'تنظيف السطح',
                'created_at' => '2025-01-01 10:00:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Inspection',
                'name_ar' => 'فحص',
                'created_at' => '2025-01-01 10:05:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Buffing',
                'name_ar' => 'تلميع',
                'created_at' => '2025-01-01 10:10:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Fill Damaged Area',
                'name_ar' => 'ملء المنطقة التالفة',
                'created_at' => '2025-01-01 10:15:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Apply Rubber Patch',
                'name_ar' => 'وضع رقعة مطاطية',
                'created_at' => '2025-01-01 10:20:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Vulcanization',
                'name_ar' => 'فلكنة',
                'created_at' => '2025-01-01 10:25:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
            [
                'name_en' => 'Final Inspection',
                'name_ar' => 'الفحص النهائي',
                'created_at' => '2025-01-01 10:30:00',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null
            ],
        ];

        // Insert the data
        foreach (array_chunk($repairSteps, 50) as $chunk) {
            DB::table('repair_steps')->insert($chunk);
        }

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE repair_steps CHECK CONSTRAINT ALL');

        $this->command->info('RepairSteps seeding completed successfully!');
    }
}
