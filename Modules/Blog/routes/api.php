<?php

use Modules\Blog\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/posts', function () {
        return auth()->user()->posts;
    });
    Route::post('/post', [BlogController::class, 'store'])->name('post.store');
    Route::get('/posts-auth/{post}', [BlogController::class, 'edit'])->name('post.edit ');
    Route::patch('/post/{post}', [BlogController::class, 'update'])->name('post.patch');
    Route::delete('/post/{post}', [BlogController::class, 'destroy'])->name('post.destroy');
});

Route::get('/posts', [BlogController::class, 'index'])->name('post.index');
Route::get('/posts/{post}', [BlogController::class, 'show'])->name('post.show');

