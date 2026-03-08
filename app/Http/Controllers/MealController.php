<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a meal's details.
     */
    public function show($id)
    {
        $meal = Meal::with('ingredients')->findOrFail($id);
        return view('meals.show', compact('meal'));
    }

    /**
     * Persist a newly created meal.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'calories' => 'nullable|integer',
            'prep_time' => 'nullable|integer',
            'ingredients' => 'nullable|string',
            'steps' => 'nullable|string',
        ]);

        // if the user didn't supply a picture we still want something
        if (empty($data['image'])) {
            $data['image'] = 'https://source.unsplash.com/800x400/?' . urlencode($data['name']);
        }

        $meal = auth()->user()->meals()->create($data);

        if (!empty($data['ingredients'])) {
            $lines = preg_split('/\r?\n/', trim($data['ingredients']));
            foreach ($lines as $name) {
                $ingredient = Ingredient::firstOrCreate(['name' => trim($name)]);
                $meal->ingredients()->attach($ingredient->id);
            }
        }

        // steps can be stored/processed later when we build a richer meal table

        return redirect()->route('meals.show', $meal->id)
                         ->with('success', 'Meal created successfully');
    }

    /**
     * Toggle favorite status for a meal.
     */
    public function toggleFavorite(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);
        $user = auth()->user();

        if ($user->favoriteMeals()->where('meal_id', $id)->exists()) {
            // Remove from favorites
            $user->favoriteMeals()->detach($id);
            $isFavorited = false;
        } else {
            // Add to favorites
            $user->favoriteMeals()->attach($id);
            $isFavorited = true;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_favorited' => $isFavorited
            ]);
        }

        return back()->with('success', $isFavorited ? 'Meal added to favorites!' : 'Meal removed from favorites!');
    }
}
