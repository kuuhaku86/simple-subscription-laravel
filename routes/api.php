<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
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

Route::apiResource('websites', WebsiteController::class);
Route::apiResource('posts', PostController::class, ['except' => ['index', 'show']]);
Route::apiResource('users', UserController::class);

Route::get('posts/{website_id}', [PostController::class, 'index']);
Route::post('users/subscribe', [UserController::class, 'subscribe']);
