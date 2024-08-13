<?php

namespace App\JWT\User;

use App\JWT\JWTBase;

class UserJWT extends JWTBase implements UserJWTInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\UserRefreshToken::class;
    }
}
