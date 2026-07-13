<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\DashbordController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\Api\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('home', [TemplateController::class, 'home'])->name('api.home');
Route::get('blog', [TemplateController::class, 'blog'])->name('api.blog');
Route::get('category/{category}', [TemplateController::class, 'category'])->name('api.category');
Route::get('search', [TemplateController::class, 'search'])->name('api.search');
Route::get('post/{post}', [TemplateController::class, 'single'])->name('api.single');
Route::post('post/{post}/comment', [TemplateController::class, 'comment'])->name('api.comment');

Route::middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'authenticate'])->name('api.authenticate');
    Route::post('register', [AuthController::class, 'register'])->name('api.register');
});


Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('dashbord', [DashbordController::class, 'dashbord'])->name('api.dashbord');

    Route::get('Post', [PostController::class, 'index'])->name('api.post.index');
});
