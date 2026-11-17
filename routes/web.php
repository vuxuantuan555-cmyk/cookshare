<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chủ - Danh sách công thức
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Recipe Routes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/search', [RecipeController::class, 'search'])->name('recipes.search');
Route::get('/recipes/category/{category}', [RecipeController::class, 'byCategory'])->name('recipes.category');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// Protected Recipe Routes
Route::middleware('auth')->group(function () {
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/recipes-create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    
    // Comments
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Ratings
    Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])->name('ratings.store');
});