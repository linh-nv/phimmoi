<?php

namespace App\JWT;

use App\Exceptions\RefreshTokenException;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ResponseHandler;

abstract class JWTBase implements JWTInterface
{
    use ResponseHandler;

    /**
     * @var Model
     */
    protected Model $_modelJWT;

    /**
     * JWTBase constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * Set model
     */
    public function setModel(): void
    {
        $this->_modelJWT = app()->make($this->getModel());
    }

    /**
     * Handle create and save refresh token; respone detail user information, access, refresh token
     */
    public function handleToken(string $token, Model $user): array
    {
        $refreshToken = $this->createRefreshToken($user);

        return $this->responseWithToken($token, $refreshToken, $user);
    }

    /**
     * Create refresh token
     */
    public function createRefreshToken(Model $user): string
    {
        $refreshTTL = config('jwt.refresh_ttl');
        $refreshToken = JWTAuth::customClaims(['type' => 'refresh', 'exp' => now()->addMinutes($refreshTTL)->timestamp])->fromUser($user);
        $this->saveRefreshToken($refreshToken, $user);

        return $refreshToken;
    }

    /**
     * Save refresh token into database
     */
    public function saveRefreshToken(string $refreshToken, Model $user): void
    {

        $this->_modelJWT::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'token' => $refreshToken,
                'user_id' => $user->id,
                'expires_at' => now()->addDays(14),
            ]
        );
    }

    /**
     * Get user from refresh token
     */
    public function checkRefreshToken(Model $user, string $refreshToken): ?Model
    {
        if (!$this->_modelJWT::where('user_id', $user->id)->where('token', $refreshToken)->first()) {

            throw new RefreshTokenException('Refresh token is invalid or has expired.');
        }

        return $user;
    }

    /**
     * Revoke refresh token
     */
    public function revokeRefreshToken($user_id): void
    {
        $refreshToken = $this->_modelJWT->where('user_id', $user_id)->firstOrFail();

        $refreshToken->delete();
    }

    /**
     * Response detail user, access token, refresh token, expires time
     */
    public function responseWithToken(string $token, string $refreshToken, Model $user): array
    {

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl'),
            'refresh_token' => $refreshToken,
            'refresh_expires_in' => config('jwt.refresh_ttl'),
            'data' => $user,
        ];
    }
}
