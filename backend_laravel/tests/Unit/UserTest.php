<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use ResponseHandler;

    protected $userRepositoryMock;
    protected $userController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userController = new UserController($this->userRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRequest();
        $request->replace([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $user = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'created_at' => Carbon::now(),
        ]);

        $this->userRepositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::subset([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]))
            ->andReturn($user);

        $response = $this->userController->register($request);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at']
            ]);
    }

    public function testLoginSuccess()
    {
        $data = [
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ];

        $request = new Request($data);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(Mockery::subset($data))
            ->andReturn('fake_token');

        Auth::shouldReceive('user')
            ->once()
            ->andReturn(new User([
                "id" => 1,
                "name" => "admin",
                "email" => "admin@gmail.com",
                "email_verified_at" => null,
                "phone" => "0999999999",
                "google_id" => null,
                "google_verified_at" => null,
            ]));

        $response = $this->userController->login($request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'name', 'email', 'created_at', 'updated_at']
            ]);
    }

    public function testLoginUnauthorized()
    {
        $data = [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ];

        $request = new Request($data);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(Mockery::subset($data))
            ->andReturn(false);

        $response = $this->userController->login($request);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'status' => 'error',
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ]);
    }

    public function testUserProfileSuccess()
    {
        $user = new User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $response = $this->userController->userProfile();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at']
            ]);
    }

    public function testChangePasswordSuccess()
    {
        $user = new User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword123')
        ]);

        $request = new Request([
            'old_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $this->userRepositoryMock->shouldReceive('update')
            ->once()
            ->with($user, ['password' => Mockery::type('string')])
            ->andReturn($user);

        $response = $this->userController->changePassWord($request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at']
            ]);
    }

    public function testChangePasswordValidationError()
    {
        $user = new User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword123')
        ]);

        $request = new Request([
            'old_password' => 'oldpassword123',
            'new_password' => 'short',
            'new_password_confirmation' => 'short',
        ]);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $response = $this->userController->changePassWord($request);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'errors'
            ]);
    }

    public function testLogoutSuccess()
    {
        Auth::shouldReceive('logout')
            ->once();

        $response = $this->userController->logout();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'code' => Response::HTTP_OK,
                'message' => 'User successfully signed out',
                'data' => null
            ]);
    }

    public function testRefreshTokenSuccess()
    {
        $newToken = 'new_fake_token';

        Auth::shouldReceive('refresh')
            ->once()
            ->andReturn($newToken);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn(new User([
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@example.com'
            ]));

        $response = $this->userController->refresh();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => ['id', 'name', 'email', 'created_at', 'updated_at']
                ]
            ]);
    }
}
