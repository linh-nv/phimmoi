<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Http\Middleware\JwtMiddleware;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(JwtMiddleware::class);
    }

    public function test_genre_list(): void
    {
        $response = $this->getJson('api/genre');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_genre_search_by_keyword(): void
    {
        $keyword = 'test';
        $response = $this->getJson('api/genre?keyword=' . $keyword);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_genre_store_success(): void
    {
        $statusActive = Status::ACTIVE;
        $response = $this->postJson('api/genre', [
            'title' => 'test title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => $statusActive->value,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    /**
     * @dataProvider genreDataProvider
     */
    public function test_genre_store_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $response = $this->postJson('api/genre', [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    public function test_genre_show_success(): void
    {
        $genre = Genre::factory()->create();
        $response = $this->getJson('api/genre/' . $genre->slug);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_genre_show_failed(): void
    {
        $response = $this->getJson('api/genre/1');
        $response->assertStatus(404);
    }

    public function test_genre_update_success(): void
    {
        $statusActive = Status::ACTIVE;
        $genre = Genre::factory()->create();
        $response = $this->putJson("api/genre/{$genre->slug}", [
            'title' => 'test title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => $statusActive->value,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    /**
     * @dataProvider genreDataProvider
     */
    public function test_genre_update_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $genre = Genre::factory()->create();

        $response = $this->putJson("api/genre/{$genre->slug}", [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function test_genre_delete_success(): void
    {
        $genre = Genre::factory()->create();

        $response = $this->deleteJson("api/genre/{$genre->slug}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $genre->id,
        ]);
    }

    public function test_genre_delete_failed(): void
    {
        $nonExistentGenreSlug = 'non-existent-genre-slug';

        $response = $this->deleteJson("api/genre/{$nonExistentGenreSlug}");

        $response->assertStatus(404);
    }

    public function test_genre_store_unique_slug_failed(): void
    {
        $genre = Genre::factory()->create(['slug' => 'test-slug']);

        $response = $this->postJson('api/genre', [
            'title' => 'Another title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => Status::ACTIVE->value,
        ]);

        // $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function test_genre_update_unique_slug_failed(): void
    {
        $genre1 = Genre::factory()->create(['slug' => 'test-slug-1']);
        $genre2 = Genre::factory()->create(['slug' => 'test-slug-2']);

        $response = $this->putJson("api/genre/{$genre2->slug}", [
            'title' => 'Updated title',
            'slug' => 'test-slug-1',
            'description' => 'Updated description',
            'status' => Status::ACTIVE->value,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public static function genreDataProvider(): array
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
