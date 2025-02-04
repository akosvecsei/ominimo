<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    // Create a new post
    Route::post('/posts', [PostController::class, 'store']);

    // Edit post
    Route::put('/posts/{id}', [PostController::class, 'update']);

    // Delete post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // Create a comment
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
});

Route::get('/posts', [PostController::class, 'index']); // List all posts
Route::get('/posts/{id}', [PostController::class, 'show']); // Single post with comments
Route::get('/posts/{id}/edit', [PostController::class, 'edit']); // Edit form (only owner)
Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // Delete comment