<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', AuthController::class.'@login');
Route::post('/register', AuthController::class.'@register');

Route::prefix('category-products')->middleware([AuthMiddleware::class])->group(function () {
    Route::get('/', CategoryController::class.'@get');
    Route::get('/{id}', CategoryController::class.'@getById');
    Route::post('/', CategoryController::class.'@create');
    Route::patch('/{id}', CategoryController::class.'@update');
    Route::delete('/{id}', CategoryController::class.'@delete');
});

Route::prefix('products')->middleware([AuthMiddleware::class])->group(function () {
    Route::get('/', ProductController::class.'@get');
    Route::get('/{id}', ProductController::class.'@getById');
    Route::post('/', ProductController::class.'@create');
    Route::post('/{id}', ProductController::class.'@update');
    Route::delete('/{id}', ProductController::class.'@delete');
});
