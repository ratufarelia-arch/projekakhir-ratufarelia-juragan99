<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RecipeSeeder extends Seeder
{
   
    public function run(): void
    {
        Recipe::updateOrCreate([
            'slug' => 'cara-membuat-steak-sempurna',
        ], [
            'title' => 'Cara Membuat Steak Sempurna',
            'excerpt' => 'Padukan tenderloin berkualitas dengan bumbu aromatik dan suhu panggang yang tepat untuk hasil empuk dan juicy.',
            'body' => 'Pilih tenderloin premium lalu keringkan permukaannya dengan tisu. Balurkan garam kasar, merica hitam, dan bawang putih cincang. Diamkan selama 30 menit di suhu ruang agar rasa meresap. Panaskan wajan besi atau panggangan sampai benar-benar panas, lalu panggang daging sekitar 2-3 menit per sisi sambil tidak terlalu sering dibolak-balik. Istirahatkan selama 5 menit sebelum diiris agar jus tersebar rata. Sajikan bersama mentega herb atau saus lada hitam.',
            'product_link' => url('/product') . '?search=tenderloin',
            'product_link_text' => 'Beli Tenderloin di sini',
            'published_at' => Carbon::now()->subDays(2),
        ]);
    }
}
