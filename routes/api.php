<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
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

// User
Route::post('/user', [AuthUserController::class, 'store']);
Route::post('/user/authenticate', [AuthUserController::class, 'authenticate']);
Route::middleware('auth:sanctum')->get('/user/{username}', [AuthUserController::class, 'fetchUser']);
Route::middleware('auth:sanctum')->get('/user/logout', [AuthUserController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/user/update', [AuthUserController::class, 'update']);
Route::middleware('auth:sanctum')->get('/user/search/{username}', [AuthUserController::class, 'searchUser']);

// Post
Route::middleware('auth:sanctum')->get('/post/profile/{username}', [PostController::class, 'fetchProfilePosts']);
Route::middleware('auth:sanctum')->get('/post/explore', [PostController::class, 'fetchExplorePosts']);
Route::middleware('auth:sanctum')->get('/post/following', [PostController::class, 'fetchFollowingPosts']);
Route::middleware('auth:sanctum')->post('/post', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->get('/post/{id}', [PostController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/post/{id}', [PostController::class, 'destroy']);

// Comment
Route::middleware('auth:sanctum')->post('/comment', [CommentController::class, 'store']);
Route::middleware('auth:sanctum')->get('/post/{id}/comments', [CommentController::class, 'index']);


// Follow
Route::middleware('auth:sanctum')->post('/user/follow', [FollowController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/user/unfollow', [FollowController::class, 'destroy']);

