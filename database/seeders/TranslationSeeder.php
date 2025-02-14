<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class TranslationSeeder extends Seeder
{
    public function run()
    {
        // Create 50 translations
        Translation::factory()->count(50)->create();
    }
}
