<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        if(!$authHeader) {
            return response()->json([
                "errors" => [
                    'message' => 'Authorization Header Missing'
                ] 
            ], 401); 
        }

        $token = str_replace('Bearer ', '', $authHeader);
        if(!$token) {
            return response()->json([
                "errors" => [
                    'message' => 'Require Token: Missing Token'
                ] 
            ], 401);
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                "errors" => [
                    'message' => 'Require Token: Invalid Token'
                ] 
            ], 401);
        }

        $userData = User::where('id', $user->id)->first();
        if(!$userData) {
            return response()->json([
                "errors" => [
                    'message' => 'Require Token: Invalid Token'
                ]
            ], 401);
        }

        Auth::login($userData);

        return $next($request);
    }
}
