<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealSearchController extends Controller
{
    /**
     * Search meals by ingredients.
     *
     * GET /api/meals/search?ingredients=chicken,rice,tomato
     *
     * Returns only meals where ALL ingredients are present in the search query.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $ingredientsInput = $request->query('ingredients', '');

        // Return empty array if no ingredients provided
        if (empty(trim($ingredientsInput))) {
            return response()->json([]);
        }

        // Split input by comma and trim whitespace
        $ingredientNames = array_map(
            'trim',
            array_filter(explode(',', $ingredientsInput))
        );

        // Convert to lowercase for case-insensitive matching
        $ingredientNames = array_map('strtolower', $ingredientNames);

        if (empty($ingredientNames)) {
            return response()->json([]);
        }

        // Get ingredient IDs from database
        $ingredients = Ingredient::whereIn(
            DB::raw('LOWER(name)'),
            $ingredientNames
        )->get();

        $ingredientIds = $ingredients->pluck('id')->toArray();

        // If no matching ingredients found, return empty array
        if (empty($ingredientIds)) {
            return response()->json([]);
        }

        // Get total count of search ingredients
        $searchIngredientCount = count($ingredientNames);

        // Find meals that have ALL the required ingredients
        // Using whereHas to filter meals that have all ingredients
        $meals = Meal::with('ingredients')
            ->whereHas(
                'ingredients',
                function ($query) use ($ingredientIds) {
                    $query->whereIn('ingredient_id', $ingredientIds);
                },
                '=',
                $searchIngredientCount  // Meal must have exactly this many matching ingredients
            )
            ->get();

        // Get current user's liked meals
        $likedMealIds = auth()->check()
            ? auth()->user()->favoriteMeals()->pluck('meals.id')->toArray()
            : [];

        // Format response
        $formattedMeals = $meals->map(function ($meal) use ($likedMealIds) {
            return [
                'id' => $meal->id,
                'name' => $meal->name,
                'description' => $meal->description,
                'image' => $meal->image ? asset('storage/' . $meal->image) : null,
                'calories' => $meal->calories,
                'prep_time' => $meal->prep_time,
                'ingredients' => $meal->ingredients->pluck('name')->toArray(),
                'liked' => in_array($meal->id, $likedMealIds),
            ];
        })->values();

        return response()->json($formattedMeals);
    }
}
