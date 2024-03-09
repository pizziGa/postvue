<?php

use App\Http\Controllers\AuthUserController;
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

Route::post('/user/store', [AuthUserController::class, 'store']);

Route::post('/user/authenticate', [AuthUserController::class, 'authenticate']);

Route::middleware('auth:sanctum')->get('/user/logout', [AuthUserController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', [AuthUserController::class, 'show']);

Route::middleware('auth:sanctum')->post('/user/update', [AuthUserController::class, 'update']);