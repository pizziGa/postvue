<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//

Route::post('/user/store', [UserController::class, 'store']);

Route::post('/user/authenticate', [UserController::class, 'authenticate']);

Route::middleware('auth/sanctum')->post('/user/logout', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'show']);
