<?php

namespace App\JWT;

use Illuminate\Database\Eloquent\Model;

interface JWTInterface
{
    public function handleToken(string $token, Model $user): array;
    public function saveRefreshToken(string $refreshToken, Model $user): void;
    public function createRefreshToken(Model $user): string;
    public function getUserFromRefreshToken(string $refreshToken): ?Model;
    public function revokeRefreshToken(Model $user): void;
    public function responseWithToken(string $token, string $refreshToken, Model $user): array;
}
