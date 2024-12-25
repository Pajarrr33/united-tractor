<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

     /**
     * @OA\Info(
     *     title="United Tractor API",
     *     version="1.0.0",
     *     description="United Tractor API documentation",
     *     @OA\Contact(
     *         email="fajarshidik78@gmail.com"
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="BearerToken",
     *         type="apiKey",
     *         in="header",
     *         name="Authorization",
     *         description="Enter token in format (Bearer <token>)"
     *     ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */
class AuthController extends Controller
{
     private AuthService $authService;

     public function __construct(AuthService $authService)
     {
          $this->authService = $authService;
     }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login into account",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="email", type="string", example="tokoweb@gmail.com"),
     *               @OA\Property(property="password", type="string", example="tokoweb")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data",type="object", 
     *                   @OA\Property(property="email", type="string", example="tokoweb@gmail.com"),
     *                   @OA\Property(property="token", type="string", example="ASDAEOJEAOAJEOAEOA212e4nsifcwaie2h"),
     *              ),
     *         )
     *     )
     * )
     */
     public function login(LoginRequest $request): JsonResponse
     {
          $data = $request->validated();

          $user = User::where('email', $data['email'])->first();

          if (!$user || !Hash::check($data['password'], $user->password)) {
               throw new HttpResponseException(response()->json([
                    'erros' => [
                         'email' => 'Email or password is wrong'
                         ]
                    ], 401));
          }

          $user = $this->authService->login($data['email'], $data['password']);

          return ($user)->response()->setStatusCode(200);
     }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register new account",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               @OA\Property(property="email", type="string", example="tokoweb@gmail.com"),
     *               @OA\Property(property="password", type="string", example="tokoweb")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data",type="object", 
     *                   @OA\Property(property="email", type="string", example="tokoweb@gmail.com"),
     *                   @OA\Property(property="token", type="string", example="ASDAEOJEAOAJEOAEOA212e4nsifcwaie2h"),
     *              ),
     *         )
     *     ),
     * )
     */
     public function register(RegisterRequest $request): JsonResponse
     {
          $data = $request->validated();

          if(User::where('email', $data['email'])->count() == 1) 
          {
               throw new HttpResponseException(response()->json([
                    'erros' => [
                         'email' => 'Email already exist'
                         ]
                    ], 400));
          }

          $user = $this->authService->register($data['email'], $data['password']);

          return ($user)->response()->setStatusCode(201);
     }
}
