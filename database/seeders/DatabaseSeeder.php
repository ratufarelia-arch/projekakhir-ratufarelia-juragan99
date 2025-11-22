<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => User::ROLE_CUSTOMER,
            ]);
        }

        User::updateOrCreate(
            ['email' => 'riffanafendi@gmail.com'],
            [
                'name' => 'Rifan',
                'password' => 'rifanadmin123@',
                'role' => User::ROLE_ADMIN,
            ],
        );
    }
}
