<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MealSearchController;

// Meal search API endpoint
Route::get('/meals/search', [MealSearchController::class, 'search']);

// Standard API user endpoint for authenticated users
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
