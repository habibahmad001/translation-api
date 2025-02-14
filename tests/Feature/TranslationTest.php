<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Translation;
use Laravel\Passport\Passport;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate for all tests
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_can_create_translation()
    {
        $response = $this->postJson('/api/translations', [
            'key' => 'example_key',
            'content' => 'This is an example translation.',
            'locale' => 'en',
            'tag' => 'example_tag',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('translations', [
            'key' => 'example_key',
            'content' => 'This is an example translation.',
        ]);
    }

    public function test_can_list_translations()
    {
        // Create some translations
        Translation::factory()->count(3)->create();

        // Make the API request
        $response = $this->getJson('/api/translations');

        // Log the response content for debugging
        \Log::info('Response Content: ' . $response->getContent());

        // Assert the response status
        $response->assertStatus(200);

        // Assert that the response contains exactly 3 translations in the 'data' array
        $response->assertJsonCount(3, 'data'); // Specify 'data' to match your actual response structure
    }

    public function test_can_update_translation()
    {
        // Create a translation
        $translation = Translation::factory()->create([
            'key' => 'example_key',
            'content' => 'This is an example translation.',
        ]);

        $response = $this->putJson("/api/translations/{$translation->id}", [
            'key' => 'updated_key',
            'content' => 'This is an updated translation.',
            'locale' => 'en',
            'tag' => 'updated_tag',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'key' => 'updated_key',
            'content' => 'This is an updated translation.',
        ]);
    }

    public function test_can_delete_translation()
    {
        // Create a translation
        $translation = Translation::factory()->create();

        $response = $this->deleteJson("/api/translations/{$translation->id}");

        $response->assertStatus(204); // No Content
        $this->assertDatabaseMissing('translations', [
            'id' => $translation->id,
        ]);
    }

    public function test_can_export_translations()
    {
        // Create some translations
        Translation::factory()->count(3)->create();

        $response = $this->getJson('/api/translations/export');

        $response->assertStatus(200);
    }
}
