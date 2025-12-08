<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        // Create sample gifts
        Gift::create([
            'name' => 'Spa Ceylon Gift Voucher',
            'description' => 'Enjoy a luxurious spa experience with our premium gift voucher. Valid for 6 months from date of issue.',
            'type' => 'voucher',
            'value' => 100.00,
            'is_active' => true,
        ]);

        Gift::create([
            'name' => 'Shagila Dinner Voucher',
            'description' => 'Experience fine dining at Shagila Restaurant. Valid for 2 persons. Reservation required.',
            'type' => 'dinner',
            'value' => 150.00,
            'is_active' => true,
        ]);

        // Create additional test users (optional)
        // User::factory(10)->create();
    }
}
