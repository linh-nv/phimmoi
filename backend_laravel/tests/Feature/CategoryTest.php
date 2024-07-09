<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Http\Middleware\JwtMiddleware;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(JwtMiddleware::class);
    }

    public function test_category_list(): void
    {
        $response = $this->getJson('api/category');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_category_search_by_keyword(): void
    {
        $keyword = 'test';
        $response = $this->getJson('api/category?keyword=' . $keyword);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_category_store_success(): void
    {
        $statusActive = Status::ACTIVE;
        $response = $this->postJson('api/category', [
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
     * @dataProvider categoryDataProvider
     */
    public function test_category_store_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $response = $this->postJson('api/category', [
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

    public function test_category_show_success(): void
    {
        $category = Category::factory()->create();
        $response = $this->getJson('api/category/' . $category->slug);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    public function test_category_show_failed(): void
    {
        $response = $this->getJson('api/category/1');
        $response->assertStatus(404);
    }

    public function test_category_update_success(): void
    {
        $statusActive = Status::ACTIVE;
        $category = Category::factory()->create();
        $response = $this->putJson("api/category/{$category->slug}", [
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
     * @dataProvider categoryDataProvider
     */
    public function test_category_update_failed(string|null $slug, string|null $title, string|null $description, int|null $status): void
    {
        $category = Category::factory()->create();

        $response = $this->putJson("api/category/{$category->slug}", [
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

    public static function categoryUpdateDataProvider(): array
    {
        $statusActive = Status::ACTIVE;

        return [
            'Without title' => [
                'title' => null,
                'slug' => 'test-update-slug',
                'description' => 'test-update-description',
                'status' => $statusActive->value,
            ],
            'Without slug' => [
                'title' => 'test-update-title',
                'slug' => null,
                'description' => 'test-update-description',
                'status' => $statusActive->value,
            ],
            'Without status' => [
                'title' => 'test-update-title',
                'slug' => 'test-update-slug',
                'description' => 'test-update-description',
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
                'slug' => 'test-update-slug',
                'description' => 'test-update-description',
                'status' => $statusActive->value,
            ],
            'Slug too long' => [
                'title' => 'test-update-title',
                'slug' => Str::random(256),
                'description' => 'test-update-description',
                'status' => $statusActive->value,
            ],
            'Status too large' => [
                'title' => 'test-update-title',
                'slug' => 'test-update-slug',
                'description' => 'test-update-description',
                'status' => PHP_INT_MAX,
            ],
        ];
    }

    public function test_category_delete_success(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("api/category/{$category->slug}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_delete_failed(): void
    {
        $nonExistentCategorySlug = 'non-existent-category-slug';

        $response = $this->deleteJson("api/category/{$nonExistentCategorySlug}");

        $response->assertStatus(404);
    }

    public function test_category_store_unique_slug_failed(): void
    {
        $category = Category::factory()->create(['slug' => 'test-slug']);

        $response = $this->postJson('api/category', [
            'title' => 'Another title',
            'slug' => 'test-slug',
            'description' => 'test-description',
            'status' => Status::ACTIVE->value,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function test_category_update_unique_slug_failed(): void
    {
        $category1 = Category::factory()->create(['slug' => 'test-slug-1']);
        $category2 = Category::factory()->create(['slug' => 'test-slug-2']);

        $response = $this->putJson("api/category/{$category2->slug}", [
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

    public static function categoryDataProvider(): array
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
