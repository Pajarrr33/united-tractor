<?php

namespace App\Services\Impl;

use App\Services\JwtService;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtServiceImpl implements JwtService
{
    function createtoken(string $id,string $email, string $password): string
    {
        $credential = ['email' => $email,'password' => $password];

        $customClaims = [
            'user_id' => $id,
            'email' => $email,
        ];

        $token = JWTAuth::claims($customClaims)->attempt($credential);

        return $token ;
    }
}
