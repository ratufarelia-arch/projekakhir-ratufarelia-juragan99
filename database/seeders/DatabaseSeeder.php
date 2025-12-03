<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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
            ['email' => 'ratufarelia@gmail.com'],
            [
                'name' => 'Ratu',
                'password' => 'ratuadmin23@',
                'role' => User::ROLE_ADMIN,
            ],
        );

        $this->call(CutSeeder::class);
        $this->call(RecipeSeeder::class);
    }
}
