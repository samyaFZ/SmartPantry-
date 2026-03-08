<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meals = Meal::all();

        foreach ($meals as $meal) {
            $steps = $this->generateStepsForMeal($meal);
            $meal->update(['steps' => $steps]);
        }

        $this->command->info("Generated steps for {$meals->count()} meals");
    }

    /**
     * Generate preparation steps based on meal name and ingredients.
     */
    private function generateStepsForMeal(Meal $meal): string
    {
        $name = strtolower($meal->name);
        $ingredients = $meal->ingredients->pluck('name')->toArray();

        // Fried Rice dishes
        if (str_contains($name, 'fried rice')) {
            return "Heat 1 tablespoon oil in a large wok or skillet over medium-high heat\n" .
                   "Add minced garlic and ginger, stir-fry for 30 seconds until fragrant\n" .
                   "Add protein (chicken, beef, or shrimp) and cook for 3-4 minutes until nearly done\n" .
                   "Add vegetables and stir-fry for 2-3 minutes until tender-crisp\n" .
                   "Add cooked rice and soy sauce, stir-fry for 2 minutes to combine flavors\n" .
                   "Push mixture to one side, add 1 teaspoon oil and crack eggs into pan\n" .
                   "Scramble eggs until cooked, then mix everything together\n" .
                   "Season with salt, pepper, and additional soy sauce if needed\n" .
                   "Serve hot garnished with green onions";
        }

        // Pasta dishes
        elseif (str_contains($name, 'pasta') || str_contains($name, 'spaghetti') || str_contains($name, 'fettuccine') || str_contains($name, 'penne')) {
            return "Bring a large pot of salted water to boil\n" .
                   "Cook pasta according to package directions until al dente (usually 8-10 minutes)\n" .
                   "While pasta cooks, heat olive oil in a large skillet over medium heat\n" .
                   "Add minced garlic and cook for 1 minute until fragrant\n" .
                   "Add tomatoes, herbs, and seasonings, simmer for 5-7 minutes\n" .
                   "Reserve 1 cup pasta water, then drain pasta\n" .
                   "Add pasta to sauce and toss to combine\n" .
                   "Add cheese and fresh herbs, toss until melted\n" .
                   "If sauce is too thick, add reserved pasta water\n" .
                   "Serve immediately with additional cheese on top";
        }

        // Risotto dishes
        elseif (str_contains($name, 'risotto')) {
            return "Heat chicken or vegetable broth in a saucepan and keep warm over low heat\n" .
                   "Heat butter and olive oil in a large saucepan over medium heat\n" .
                   "Add finely chopped onions and cook until translucent (about 5 minutes)\n" .
                   "Add Arborio rice and stir for 2 minutes until lightly toasted\n" .
                   "Add white wine and stir until completely absorbed\n" .
                   "Add warm broth one ladle at a time, stirring constantly after each addition\n" .
                   "Continue adding broth and stirring for 18-20 minutes until rice is creamy\n" .
                   "Stir in grated Parmesan cheese, butter, and seasonings\n" .
                   "Remove from heat, cover, and let rest for 2 minutes\n" .
                   "Serve immediately with additional cheese";
        }

        // Stir fry dishes
        elseif (str_contains($name, 'stir fry') || str_contains($name, 'stir-fry')) {
            return "Prepare all ingredients and have them ready before starting (mise en place)\n" .
                   "Heat 1-2 tablespoons oil in a wok or large skillet over high heat\n" .
                   "Add aromatics (garlic, ginger) and stir-fry for 30 seconds\n" .
                   "Add protein and stir-fry for 2-3 minutes until nearly cooked\n" .
                   "Add harder vegetables (carrots, broccoli) and stir-fry for 2 minutes\n" .
                   "Add softer vegetables and stir-fry for 1-2 minutes\n" .
                   "Add sauce ingredients and toss everything to coat evenly\n" .
                   "Cook for 1-2 more minutes until sauce thickens slightly\n" .
                   "Remove from heat and serve immediately over rice or noodles\n" .
                   "Garnish with sesame seeds or green onions if desired";
        }

        // Grilled or baked chicken
        elseif (str_contains($name, 'grilled chicken') || str_contains($name, 'baked chicken')) {
            return "Preheat grill to medium-high heat (about 375-400°F) or oven to 400°F\n" .
                   "Pat chicken dry with paper towels and season both sides generously\n" .
                   "Brush with olive oil or marinade and let sit at room temperature for 15 minutes\n" .
                   "For grilling: Place chicken on grill and cook for 6-7 minutes per side\n" .
                   "For baking: Place chicken on a baking sheet and bake for 20-25 minutes\n" .
                   "Check internal temperature - chicken is done at 165°F\n" .
                   "Let chicken rest for 5 minutes before slicing\n" .
                   "Serve with your favorite sides and vegetables";
        }

        // Seafood dishes
        elseif (str_contains($name, 'shrimp') || str_contains($name, 'seafood') || str_contains($name, 'fish')) {
            return "Pat seafood dry and season with salt and pepper\n" .
                   "Heat olive oil or butter in a skillet over medium-high heat\n" .
                   "Add minced garlic and cook for 30 seconds until fragrant\n" .
                   "Add seafood and cook for 2-3 minutes per side (shrimp: 2-3 minutes total)\n" .
                   "Add lemon juice, white wine, or herbs during the last minute of cooking\n" .
                   "Remove from heat when seafood is opaque and cooked through\n" .
                   "Serve immediately with pasta, rice, or vegetables\n" .
                   "Garnish with fresh herbs and lemon wedges";
        }

        // Default cooking steps
        else {
            return "Preheat oven or heat cooking vessel to appropriate temperature\n" .
                   "Prepare ingredients by washing, chopping, and measuring as needed\n" .
                   "Heat oil, butter, or cooking fat in your cooking vessel\n" .
                   "Add aromatics (onions, garlic, ginger) and cook until softened\n" .
                   "Add main ingredients and cook according to recipe requirements\n" .
                   "Season with salt, pepper, herbs, and spices throughout cooking\n" .
                   "Add liquids (broth, water, wine) as needed for desired consistency\n" .
                   "Cook until all ingredients are tender and fully cooked\n" .
                   "Adjust seasoning and serve hot with appropriate accompaniments";
        }
    }
}