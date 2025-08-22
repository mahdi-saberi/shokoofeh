<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users without factory
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create additional super admin
        User::create([
            'name' => 'مدیر کل سیستم',
            'email' => 'superadmin@shokoofeh.com',
            'password' => Hash::make('SuperAdmin123!'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create a regular admin user
        User::create([
            'name' => 'مدیر عادی',
            'email' => 'admin@shokoofeh.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // First seed the lookup tables
        $this->call([
            AgeGroupSeeder::class,
            GameTypeSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
        ]);
    }
}
