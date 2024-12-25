<?php

namespace App\Services;

interface JwtService
{
    function createtoken(string $id,string $email, string $password): string;
}