<?php

namespace App\Traits;

use App\Models\User;

trait TestUser
{
    /**
     * Create user
     *
     * @return User
     */
    protected function createUser(): User
    {
        return User::factory()->create();
    }

    /**
     * Generate Token
     *
     * @param User|null $user User
     * @return string
     */
    protected function generateToken(User $user = null): string
    {
        if (!$user) {
            $user = $this->createUser();
        }

        return $user->createToken('token')->plainTextToken;
    }

    /**
     * Handle headers with bearer token
     *
     * @param User|null $user User
     * @return array
     */
    protected function headersWithToken(User $user = null): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->generateToken($user),
        ];
    }
}