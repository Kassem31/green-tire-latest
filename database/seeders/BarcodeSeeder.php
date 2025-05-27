<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barcode;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user id to use as created_by
        $userId = User::first()?->id ?? 1;

        // Create a faker instance
        $faker = Faker::create();

        // Array of common machine models for tire manufacturing
        $machines = [
            'VMI Maxx',
            'HF TBR-1',
            'Harburg Freudenberger',
            'Kobelco KBKC',
            'Rogers CP-700',
            'Mitsubishi HT-Series',
            'Bridgestone AutoSpecial',
            'Michelin TBM-2000',
            'Continental GT-500',
            'Pirelli P-Gen4'
        ];

        // Array of sample operator names and their codes
        $operators = [
            ['name' => 'Ahmed Ibrahim', 'code' => 'AIB001'],
            ['name' => 'Fatima Al-Sayed', 'code' => 'FAS002'],
            ['name' => 'Mohammed Ali', 'code' => 'MAL003'],
            ['name' => 'Sara Hassan', 'code' => 'SHA004'],
            ['name' => 'Omar Khalid', 'code' => 'OKH005'],
            ['name' => 'Aisha Ahmed', 'code' => 'AAH006'],
            ['name' => 'Youssef Mahmoud', 'code' => 'YMA007'],
            ['name' => 'Layla Samir', 'code' => 'LSA008'],
            ['name' => 'Amr Zaki', 'code' => 'AZA009'],
            ['name' => 'Nour Adel', 'code' => 'NAD010']
        ];

        // Generate 50 random barcodes
        $barcodeData = [];

        for ($i = 0; $i < 50; $i++) {
            // Generate a random barcode - format TIRE-YYYYMMDD-XXXXX
            $date = $faker->dateTimeBetween('-1 year', 'now')->format('Ymd');
            $sequence = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $barcode = "TIRE-{$date}-{$sequence}";

            // Get a random machine
            $machine = $machines[array_rand($machines)];

            // Get a random operator
            $operator = $operators[array_rand($operators)];

            // Generate a barcode record
            $barcodeData[] = [
                'barcode' => $barcode,
                'machine' => $machine,
                'operator_name' => $operator['name'],
                'operator_code' => $operator['code'],
                'is_active' => $faker->boolean(90), // 90% chance of being active
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => $userId,
                'updated_by' => $userId
            ];
        }

        // Insert all barcodes in chunks to improve performance
        foreach (array_chunk($barcodeData, 10) as $chunk) {
            DB::table('barcodes')->insert($chunk);
        }

        // Output message
        $this->command->info('50 random barcodes have been created successfully.');
    }
}
