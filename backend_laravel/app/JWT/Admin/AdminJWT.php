<?php

namespace App\JWT\Admin;

use App\JWT\JWTBase;

class AdminJWT extends JWTBase implements AdminJWTInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\AdminRefreshToken::class;
    }
}
