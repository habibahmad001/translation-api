<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        // List of valid locales (language codes)
        $locales = ['en', 'fr', 'es', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ar'];

        // List of meaningful tags for context
        $tags = ['mobile', 'desktop', 'web', 'admin', 'user', 'email', 'notification', 'error', 'success'];

        // Generate a unique key using a combination of words and a random number
        $key = $this->faker->word . '-' . $this->faker->word . '-' . $this->faker->randomNumber(3);

        return [
            'key' => $key, // Custom unique key
            'content' => $this->faker->sentence,
            'locale' => $this->faker->randomElement($locales), // Randomly pick a locale
            'tag' => $this->faker->randomElement($tags), // Randomly pick a tag
        ];
    }
}
