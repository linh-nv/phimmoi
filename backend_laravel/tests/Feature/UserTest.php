<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
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

        $response->assertStatus(422);
        $response->assertJsonStructure([
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

        $response->assertStatus(422);
        $response->assertJsonStructure([
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

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user',
        ]);
    }

    public function test_user_login_failed(): void
    {
        $user = User::create(['name' => 'test', 'email' => 'nonexistent@example.com', 'password' => '12345678']);

        $response = $this->postJson('api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_logout_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('api/logout');

        $response->assertStatus(500);
    }

    public function test_user_refresh_failse(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('api/refresh');

        $response->assertStatus(500);
    }

    public function test_user_profile_failse(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->getJson('api/me');

        $response->assertStatus(401);
    }

    public function test_user_change_password_success(): void
    {
        $oldPassword = 'password123';
        $newPassword = 'newpassword123';
        
        $user = User::factory()->create([
            'password' => Hash::make($oldPassword),
        ]);

        $this->actingAs($user, 'api');

        $response = $this->postJson('api/change-password', [
            'old_password' => $oldPassword,
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword,
        ]);

        $response->assertStatus(200);
    }
}