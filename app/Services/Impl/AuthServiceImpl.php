<?php

namespace App\Services\Impl;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\JwtService;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{
    private JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    function register(string $email, string $password): UserResource
    {
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->access_token = $this->jwtService->createtoken($user->id, $email, $password);

        return new UserResource($user);
    }

    function login(string $email, string $password): UserResource
    {
        $user = User::where('email', $email)->first();

        $user->access_token = $this->jwtService->createtoken($user->id, $email, $password);

        return new UserResource($user);
    }
}
