<?php

namespace App\JWT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface JWTInterface
{
    public function handleToken(string $token, Model $user): Collection;
    public function saveRefreshToken(string $refreshToken, Model $user): void;
    public function createRefreshToken(Model $user): string;
    public function checkRefreshToken(Model $user, string $refreshToken): ?Model;
    public function revokeRefreshToken($user_id): void;
    public function responseWithToken(string $token, string $refreshToken, Model $user): Collection;
}
