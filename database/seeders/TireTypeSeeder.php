<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TireTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding TireTypes...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE tire_types NOCHECK CONSTRAINT ALL');

        // Clear the table first
        DB::table('tire_types')->delete();

        // Insert basic tire types based on inspection transactions requirements
        DB::table('tire_types')->insert([
            [
                'name_en' => 'Main Group',
                'name_ar' => 'المجموعة الرئيسية',
                'description' => 'Main group tire type',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_en' => 'Green Tire',
                'name_ar' => 'إطار أخضر',
                'description' => 'Green tire type',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE tire_types CHECK CONSTRAINT ALL');

        $this->command->info('TireTypes seeding completed successfully!');
    }
}
