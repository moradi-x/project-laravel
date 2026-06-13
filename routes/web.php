<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TemplateController::class, 'home'])->name('home');
Route::get('blog',[TemplateController::class , 'blog'])->name('blog') ;
Route::get('category/{category}', [TemplateController::class, 'category'])->name('category');
Route::get('search', [TemplateController::class, 'search'])->name('search');
Route::get('post/{post}', [TemplateController::class, 'single'])->name('single'); 
Route::post('post/{post}/comment', [TemplateController::class, 'comment'])->name('comment');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerUser'])->name('register.user');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    Route::get('dashbord', [DashbordController::class, 'dashbord'])->name('dashbord');

    Route::get('Post' ,[PostController::class , 'index'])->name('post.index');
    Route::get('post/create', [PostController::class,'create'])->name('post.create');
    Route::post('post',[PostController::class , 'store'])->name('post.store');
    Route::get('post/{post}/edit' , [PostController::class , 'edit'])->name('post.edit');
    Route::put('post/{post}',[PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}',[PostController::class , 'destroy'])->name('post.destroy');
    Route::patch('post/{post}', [PostController::class , 'change'])->name('post.change') ;

    Route::get('category',[CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create',[CategoryController::class , 'create'])->name('category.create');
    Route::post('category' , [CategoryController::class , 'store'])->name('category.store');
    Route::get('category/{category}/edit' , [CategoryController::class , 'edit'])->name('category.edit');
    Route::put('category/{category}' , [CategoryController::class , 'update'])->name('category.update');
    Route::delete('category/{category}' , [CategoryController::class , 'destroy'])->name('category.destroy');

    Route::get('comment',[CommentController::class, 'index'])->name('comment.index');
    Route::get('comment/{comment}/edit',[CommentController::class , 'edit'])->name('comment.edit');
    Route::put('comment/{comment}',[CommentController::class , 'update'])->name('comment.update');
    Route::delete('comment/{comment}',[CommentController::class , 'destroy'])->name('comment.destroy');

    Route::get('user/',[UserController::class,'index'])->name('user.index');
    Route::get('user/create',[UserController::class , 'create'])->name('user.create');
    Route::post('user' , [UserController::class, 'store'])->name('user.store');
    Route::delete('user/{user}',[UserController::class,'destroy'])->name('user.destroy');
    Route::get('user/{user}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('user/{user}',[UserController::class,'update'])->name('user.update');
    Route::patch('user/{user}/change' , [UserController::class , 'change'])->name('user.change');
    Route::patch('user/{user}/reset' , [UserController::class , 'reset'])->name('user.reset');

    Route::get('profile',[AuthController::class, 'profile'])->name('profile.edit');
    Route::put('profile',[AuthController::class , 'updateprofile'])->name('profile.update');
});
 