<?php

namespace App\Services;

use App\Http\Resources\UserResource;

interface AuthService
{
    function register(string $email, string $password): UserResource;
    function login(string $email, string $password): UserResource;
}