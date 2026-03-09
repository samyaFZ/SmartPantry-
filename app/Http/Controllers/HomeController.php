<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the homepage with random meals.
     */
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!empty(trim($query))) {
            // perform ingredient-based search (reuse logic similar to MealSearchController)
            $ingredientNames = array_map('trim', array_filter(explode(',', $query)));
            $ingredientNames = array_map('strtolower', $ingredientNames);

            if (!empty($ingredientNames)) {
                $ingredientIds = Ingredient::whereIn(DB::raw('LOWER(name)'), $ingredientNames)
                    ->pluck('id')
                    ->toArray();

                if (!empty($ingredientIds)) {
                    $searchCount = count($ingredientNames);
                    $meals = Meal::with('ingredients')
                        ->whereHas('ingredients', function ($q) use ($ingredientIds) {
                            $q->whereIn('ingredient_id', $ingredientIds);
                        }, '=', $searchCount)
                        ->get();
                } else {
                    $meals = collect();
                }
            } else {
                $meals = collect();
            }
        } else {
            // default random meals
            $meals = Meal::with('ingredients')->inRandomOrder()->limit(6)->get();
        }

        // Dashboard Stats
        $stats = [
            'pantry_count' => 42, // Placeholder for now as per pantry view
            'expiring_count' => 12,
            'favorites_count' => auth()->check() ? auth()->user()->favoriteMeals()->count() : 0,
            'saved_count' => auth()->check() ? auth()->user()->savedMeals()->count() : 0,
        ];

        return view('home', compact('meals', 'query', 'stats'));
    }
}
