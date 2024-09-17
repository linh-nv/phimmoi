<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_register_success(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'test user',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'name',
                'email',
                'phone',
                'updated_at',
                'created_at',
                'id',
            ]
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }

    public function test_user_register_unique_email_failed(): void
    {
        $existingUser = User::factory()->create(['email' => 'testuser@example.com']);

        $response = $this->postJson('api/register', [
            'name' => 'test user',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    public function test_user_register_email_too_long_failed(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'test user',
            'email' => Str::random(256) . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    public function test_user_login_success(): void
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'data' => [
                "access_token",
                "token_type",
                "expires_in",
                "user" => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "phone",
                    "google_id",
                    "google_verified_at",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);
    }

    public function test_user_login_failed(): void
    {
        $user = User::create(['name' => 'test', 'email' => 'nonexistent@example.com', 'password' => '12345678']);

        $response = $this->postJson('api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson([
            "success" => 0,
            "data" => null,
        ]);
        $response->assertJsonStructure([
            "success",
            "data",
            "errors" => [
                "error_code",
                "error_message"
            ]
        ]);
    }

    public function test_user_logout_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');
        $token = auth('api')->login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token);
        $response = $this->postJson('api/logout');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'message',
            ]
        ]);
    }


    public function test_user_logout_failse(): void
    {
        $response = $this->postJson('api/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonStructure([
            'status'
        ]);
    }

    public function test_user_refresh_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');
        $token = auth('api')->login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token);
        $response = $this->postJson('api/refresh');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                "access_token",
                "token_type",
                "expires_in",
                "user" => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "phone",
                    "google_id",
                    "google_verified_at",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);
    }

    public function test_user_refresh_failse(): void
    {
        $response = $this->postJson('api/refresh');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonStructure([
            'status'
        ]);
    }

    public function test_user_profile_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');
        $token = auth('api')->login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token);
        $response = $this->getJson('api/me');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "phone",
                    "google_id",
                    "google_verified_at",
                    "created_at",
                    "updated_at"
            ]
        ]);
    }

    public function test_user_profile_failed(): void
    {
        $response = $this->getJson('api/me');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonStructure([
            'status'
        ]);
    }

    public function test_user_change_password_success(): void
    {
        $oldPassword = 'password123';
        $newPassword = 'newpassword123';

        $user = User::factory()->create([
            'password' => Hash::make($oldPassword),
        ]);

        $this->actingAs($user, 'api');
        $token = auth('api')->login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token);
        $response = $this->postJson('api/change-password', [
            'old_password' => $oldPassword,
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "phone",
                    "google_id",
                    "google_verified_at",
                    "created_at",
                    "updated_at"
            ]
        ]);
    }

    public function test_user_change_password_failed(): void
    {
        $oldPassword = 'password123';
        $newPassword = 'newpassword123';
        $wrongPassword = 'wrongnewpassword123';

        $user = User::factory()->create([
            'password' => Hash::make($oldPassword),
        ]);

        $this->actingAs($user, 'api');
        $token = auth('api')->login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('api/change-password', [
                'old_password' => 'wrongpassword',
                'new_password' => $newPassword,
                'new_password_confirmation' => $wrongPassword,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
}
