<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MealSearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PantryController;

// landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// dashboard and meal browsing
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/meal/{id}', [MealController::class, 'show'])->name('meals.show');
Route::view('/favorites', 'favorites')->name('favorites');
Route::get('/pantry', [PantryController::class, 'index'])->name('pantry');
Route::view('/add-meal', 'meals.add')->name('meals.add');
// handle new meal submissions
Route::post('/meals', [MealController::class, 'store'])->name('meals.store');
Route::post('/meals/{id}/toggle-favorite', [MealController::class, 'toggleFavorite'])->middleware('auth')->name('meals.toggle-favorite');
Route::view('/profile', 'profile')->middleware('auth')->name('profile');

// authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::put('/profile/update', [AuthController::class, 'update'])->middleware('auth')->name('profile.update');
Route::delete('/account/delete', [AuthController::class, 'delete'])->middleware('auth')->name('account.delete');

// API Routes - Meal search endpoint
Route::get('/api/meals/search', [MealSearchController::class, 'search']);
