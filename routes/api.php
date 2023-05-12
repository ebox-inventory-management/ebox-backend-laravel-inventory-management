<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostController;
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



Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/user/{id}', [UserAuthController::class, 'update']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user', [UserAuthController::class, 'show']);