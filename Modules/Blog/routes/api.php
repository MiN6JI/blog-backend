<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Modules\Blog\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Public routes
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // login
Route::get('/posts', [BlogController::class, 'index'])->name('post.index');
Route::get('/posts/{post}', [BlogController::class, 'show'])->name('post.show');

// Token-protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']); // logout
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::get('/user/posts', function () { return auth()->user()->posts; });
    Route::post('/post', [BlogController::class, 'store'])->name('post.store');
    Route::get('/posts-auth/{post}', [BlogController::class, 'edit'])->name('post.edit');
    Route::patch('/post/{post}', [BlogController::class, 'update'])->name('post.patch');
    Route::delete('/post/{post}', [BlogController::class, 'destroy'])->name('post.destroy');
});
