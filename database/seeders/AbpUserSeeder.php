<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbpUser;
use Illuminate\Support\Facades\DB;

class AbpUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding AbpUsers...');

        // Disable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE AbpUsers NOCHECK CONSTRAINT ALL');

        // Clear the table first (in SQL Server TRUNCATE might fail if the table is referenced, so use DELETE)
        DB::table('AbpUsers')->delete();

        // Insert data from the original database
        DB::table('AbpUsers')->insert([
            [
                'Id' => '13373642-5beb-888f-420d-3a11aacb413f',
                'TenantId' => null,
                'UserName' => 'admin',
                'NormalizedUserName' => 'ADMIN',
                'Name' => 'admin',
                'Surname' => null,
                'Email' => 'admin@abp.io',
                'NormalizedEmail' => 'ADMIN@ABP.IO',
                'EmailConfirmed' => 0,
                'PasswordHash' => 'AQAAAAIAAYagAAAAEB0UJfcWUX1zCfWoU2FpMI3GUrspMh6DOJONC+fc3kS6WRnIZcftvo0D9KtiBwgi3Q==',
                'SecurityStamp' => 'DQZQHAYU5KIDLXSUM4GWJD6HHTS65JE2',
                'IsExternal' => 0,
                'PhoneNumber' => null,
                'PhoneNumberConfirmed' => 0,
                'IsActive' => 1,
                'TwoFactorEnabled' => 0,
                'LockoutEnd' => '2025-02-19T08:58:11.0195361+00:00',
                'LockoutEnabled' => 1,
                'AccessFailedCount' => 0,
                'ShouldChangePasswordOnNextLogin' => 0,
                'EntityVersion' => 72,
                'LastPasswordChangeTime' => '2024-04-01T07:45:02.3440164+00:00',
                'ExtraProperties' => '{}',
                'ConcurrencyStamp' => 'e0b006269e994dd58a76ef80d47a8814',
                'CreationTime' => '2024-04-01 09:45:02.4780683',
                'CreatorId' => null,
                'LastModificationTime' => '2025-03-25 08:17:02.0939791',
                'LastModifierId' => null,
                'IsDeleted' => 0,
                'DeleterId' => null,
                'DeletionTime' => null
            ],
            [
                'Id' => 'ba51cd4d-3ea3-fb08-3ce0-3a11b05ccfd3',
                'TenantId' => null,
                'UserName' => 'administrator',
                'NormalizedUserName' => 'ADMINISTRATOR',
                'Name' => 'Prometeon Admin',
                'Surname' => 'Admin',
                'Email' => 'admin@prometeon.com',
                'NormalizedEmail' => 'ADMIN@PROMETEON.COM',
                'EmailConfirmed' => 0,
                'PasswordHash' => 'AQAAAAIAAYagAAAAEB0UJfcWUX1zCfWoU2FpMI3GUrspMh6DOJONC+fc3kS6WRnIZcftvo0D9KtiBwgi3Q==',
                'SecurityStamp' => 'TXF3DSKN7UXDXSVPAY2NUXZDANV7PJIL',
                'IsExternal' => 0,
                'PhoneNumber' => null,
                'PhoneNumberConfirmed' => 0,
                'IsActive' => 1,
                'TwoFactorEnabled' => 0,
                'LockoutEnd' => null,
                'LockoutEnabled' => 0,
                'AccessFailedCount' => 0,
                'ShouldChangePasswordOnNextLogin' => 0,
                'EntityVersion' => 26,
                'LastPasswordChangeTime' => '2024-04-02T09:42:07.6866854+00:00',
                'ExtraProperties' => '{}',
                'ConcurrencyStamp' => '03dfc6137f764411acaa472520af5922',
                'CreationTime' => '2024-04-02 11:42:07.7129020',
                'CreatorId' => '13373642-5beb-888f-420d-3a11aacb413f',
                'LastModificationTime' => '2025-04-28 12:38:23.4700070',
                'LastModifierId' => null,
                'IsDeleted' => 0,
                'DeleterId' => null,
                'DeletionTime' => null
            ],
            [
                'Id' => '0cd3fc11-36da-05e8-5e4c-3a11b509a476',
                'TenantId' => null,
                'UserName' => 'test',
                'NormalizedUserName' => 'TEST',
                'Name' => '',
                'Surname' => '',
                'Email' => 'test@prometeon.com',
                'NormalizedEmail' => 'TEST@PROMETEON.COM',
                'EmailConfirmed' => 0,
                'PasswordHash' => 'AQAAAAIAAYagAAAAEB0UJfcWUX1zCfWoU2FpMI3GUrspMh6DOJONC+fc3kS6WRnIZcftvo0D9KtiBwgi3Q==',
                'SecurityStamp' => 'KSPVYGXPCNT2LZ5TE2Q22QR53TROJTGA',
                'IsExternal' => 0,
                'PhoneNumber' => null,
                'PhoneNumberConfirmed' => 0,
                'IsActive' => 1,
                'TwoFactorEnabled' => 0,
                'LockoutEnd' => null,
                'LockoutEnabled' => 0,
                'AccessFailedCount' => 0,
                'ShouldChangePasswordOnNextLogin' => 0,
                'EntityVersion' => 5,
                'LastPasswordChangeTime' => '2024-04-03T07:29:23.2219179+00:00',
                'ExtraProperties' => '{}',
                'ConcurrencyStamp' => 'bda5840c46b349088b7b974f6643e7af',
                'CreationTime' => '2024-04-03 09:29:23.2698761',
                'CreatorId' => 'ba51cd4d-3ea3-fb08-3ce0-3a11b05ccfd3',
                'LastModificationTime' => '2024-05-22 12:25:57.2902400',
                'LastModifierId' => null,
                'IsDeleted' => 0,
                'DeleterId' => null,
                'DeletionTime' => null
            ]
        ]);

        // Re-enable foreign key constraints in SQL Server
        DB::statement('ALTER TABLE AbpUsers CHECK CONSTRAINT ALL');

        $this->command->info('AbpUsers seeding completed successfully!');
    }
}
