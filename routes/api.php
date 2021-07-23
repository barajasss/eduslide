<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\FavoriteController;

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

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('me', [AuthController::class, 'updateMe']);
});

Route::resource('lessons', LessonController::class)->except(['create', 'edit']);
Route::resource('slides', SlideController::class)->except(['create', 'edit']);
Route::resource('favorites', FavoriteController::class)->only(['index', 'store', 'destroy']);
