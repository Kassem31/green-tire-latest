<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('is_super_admin', 1)->first();
        if (is_null($user)) {
            User::create([
                'name' => 'sys_admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make(123456),
                'is_active' => true,
                'is_super_admin' => 1,
            ]);
        }
    }
}
