<?php

namespace Tests\Feature\Controllers;

use App\Enums\Status;
use App\Http\Middleware\JwtMiddleware;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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
        ]);
    }

    public function test_category_search_by_keyword(): void
    {
        $keyword = 'test';
        $response = $this->getJson('api/category?keyword=' . $keyword);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
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
        ]);
    }

    /**
     * @dataProvider categoryStoreDataProvider
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
            'errors',
        ]);
    }

    public static function categoryStoreDataProvider(): array
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
        ];
    }

    public function test_category_show_success(): void
    {
        $category = Category::factory()->create();
        $response = $this->getJson('api/category/' . $category->slug);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
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
            'data' => [
                'title',
                'slug',
                'description',
                'status',
            ]
        ]);
    }
}
