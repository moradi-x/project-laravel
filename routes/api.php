<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\api\DashbordController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\UserController;
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
    Route::get('me', [AuthController::class, 'me'])->name('me');

    Route::get('Post', [PostController::class, 'index'])->name('api.post.index');
    Route::post('post', [PostController::class, 'store'])->name('api.post.store');
    Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('api.post.destroy');
    Route::patch('post/{post}', [PostController::class, 'change'])->name('api.post.change');
    Route::put('post/{post}', [PostController::class, 'update'])->name('api.post.update');
    Route::delete('post/{post}/force', [PostController::class, 'forcedelete'])->name('api.post.force.delete');
    Route::patch('post/{post}/restore', [PostController::class, 'restore'])->name('api.post.restore');

    Route::get('category', [CategoryController::class, 'index'])->name('api.category.index');
    Route::post('category', [CategoryController::class, 'store'])->name('api.category.store');
    Route::put('category/{category}', [CategoryController::class, 'update'])->name('api.category.update');
    Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('api.category.destroy');

    Route::get('comment', [CommentController::class, 'index'])->name('api.comment.index');
    Route::put('comment/{comment}', [CommentController::class, 'update'])->name('api.comment.update');
    Route::delete('comment/{comment}', [CommentController::class, 'destroy'])->name('api.comment.destroy');

    Route::get('user/', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('user/{user}/change', [UserController::class, 'change'])->name('user.change');
    Route::patch('user/{user}/reset', [UserController::class, 'reset'])->name('user.reset');


    Route::put('profile', [AuthController::class, 'updateprofile'])->name('apu.profile.update');

});
