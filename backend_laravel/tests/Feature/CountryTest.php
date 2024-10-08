<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Http\Middleware\JwtMiddleware;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(JwtMiddleware::class);
    }

    public function test_country_list(): void
    {
        $response = $this->getJson('api/country');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_country_search_by_keyword(): void
    {
        $keyword = 'test';
        $response = $this->getJson('api/country?keyword=' . $keyword);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_country_store_success(): void
    {
        $statusActive = Status::ACTIVE;
        $response = $this->postJson('api/country', [
            'title' => 'test title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => $statusActive->value,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    /**
     * @dataProvider countryDataProvider
     */
    public function test_country_store_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $response = $this->postJson('api/country', [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    public function test_country_show_success(): void
    {
        $country = Country::factory()->create();
        $response = $this->getJson('api/country/' . $country->slug);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_country_show_failed(): void
    {
        $response = $this->getJson('api/country/1');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_country_update_success(): void
    {
        $statusActive = Status::ACTIVE;
        $country = Country::factory()->create();
        $response = $this->putJson("api/country/{$country->slug}", [
            'title' => 'test title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => $statusActive->value,
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    /**
     * @dataProvider countryDataProvider
     */
    public function test_country_update_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $country = Country::factory()->create();

        $response = $this->putJson("api/country/{$country->slug}", [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function test_country_delete_success(): void
    {
        $country = Country::factory()->create();

        $response = $this->deleteJson("api/country/{$country->slug}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $country->id,
        ]);
    }

    public function test_country_delete_failed(): void
    {
        $nonExistentCountrySlug = 'non-existent-country-slug';

        $response = $this->deleteJson("api/country/{$nonExistentCountrySlug}");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_country_store_unique_slug_failed(): void
    {
        $country = Country::factory()->create(['slug' => 'test-slug']);

        $response = $this->postJson('api/country', [
            'title' => 'Another title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => Status::ACTIVE->value,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function test_country_update_unique_slug_failed(): void
    {
        $country1 = Country::factory()->create(['slug' => 'test-slug-1']);
        $country2 = Country::factory()->create(['slug' => 'test-slug-2']);

        $response = $this->putJson("api/country/{$country2->slug}", [
            'title' => 'Updated title',
            'slug' => 'test-slug-1',
            'description' => 'Updated description',
            'status' => Status::ACTIVE->value,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public static function countryDataProvider(): array
    {
        $statusActive = Status::ACTIVE;

        return [
            'Without title' => [
                'title' => null,
                'slug' => 'test',
                'description' => 'test-description',
                'status' => $statusActive->value,
            ],
            'Without slug' => [
                'title' => 'test-title',
                'slug' => null,
                'description' => 'test-description',
                'status' => $statusActive->value,
            ],
            'Without status' => [
                'title' => 'test title',
                'slug' => 'test-slug',
                'description' => 'test-description',
                'status' => null,
            ],
            'Empty' => [
                'title' => null,
                'slug' => null,
                'description' => null,
                'status' => null,
            ],
            'Title too long' => [
                'title' => Str::random(256),
                'slug' => 'test-slug',
                'description' => 'test-description',
                'status' => $statusActive->value,
            ],
            'Slug too long' => [
                'title' => 'test title',
                'slug' => Str::random(256),
                'description' => 'test-description',
                'status' => $statusActive->value,
            ],
            'Status too large' => [
                'title' => 'test title',
                'slug' => 'test-slug',
                'description' => 'test-description',
                'status' => PHP_INT_MAX,
            ],
        ];
    }
}
