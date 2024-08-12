<?php

namespace App\JWT;

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
        $this->saveRefreshToken($refreshToken, $user, $this->_modelJWT);

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
    public function getUserFromRefreshToken(string $refreshToken): ?Model
    {
        $user = JWTAuth::setToken($refreshToken)->toUser();

        if($this->_modelJWT::where('user_id', $user->id)->where('token', $refreshToken)->first()){
            
            return $user;
        }

        return null;
    }

    /**
     * Revoke refresh token
     */
    public function revokeRefreshToken(Model $user): void
    {
        $user->delete();
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
