<?php

namespace Database\Seeders;

use App\Models\Cut;
use Illuminate\Database\Seeder;

class CutSeeder extends Seeder
{
    public function run(): void
    {
        $cuts = [
            ['name' => 'Sirloin', 'slug' => 'sirloin'],
            ['name' => 'Ribeye', 'slug' => 'ribeye'],
            ['name' => 'Tenderloin', 'slug' => 'tenderloin'],
            ['name' => 'Flank', 'slug' => 'flank'],
            ['name' => 'Chuck', 'slug' => 'chuck'],
            ['name' => 'Brisket', 'slug' => 'brisket'],
            ['name' => 'Hanger', 'slug' => 'hanger'],
        ];

        foreach ($cuts as $cut) {
            Cut::firstOrCreate(['slug' => $cut['slug']], $cut);
        }
    }
}
