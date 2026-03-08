<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GenerateMealSteps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-meal-steps {--force : Force update even if steps already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate preparation steps for meals using external recipe APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $meals = Meal::all();
        $this->info("Found {$meals->count()} meals to process");

        $progressBar = $this->output->createProgressBar($meals->count());
        $progressBar->start();

        $updated = 0;
        $skipped = 0;

        foreach ($meals as $meal) {
            if (!$this->option('force') && !empty($meal->steps)) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            $steps = $this->generateStepsForMeal($meal);

            if ($steps) {
                $meal->update(['steps' => $steps]);
                $updated++;
            }

            // Add delay to avoid API rate limits
            sleep(1);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("Updated: {$updated} meals");
        $this->info("Skipped: {$skipped} meals (already have steps)");
    }

    /**
     * Generate preparation steps for a meal.
     */
    private function generateStepsForMeal(Meal $meal): ?string
    {
        // Try Spoonacular API first
        $steps = $this->getStepsFromSpoonacular($meal);
        if ($steps) {
            return $steps;
        }

        // Fallback to generating basic steps based on ingredients
        return $this->generateBasicSteps($meal);
    }

    /**
     * Get steps from Spoonacular API.
     */
    private function getStepsFromSpoonacular(Meal $meal): ?string
    {
        $apiKey = config('services.spoonacular.key');

        if (!$apiKey) {
            return null;
        }

        try {
            // First, search for recipes
            $searchResponse = Http::timeout(10)->get('https://api.spoonacular.com/recipes/complexSearch', [
                'apiKey' => $apiKey,
                'query' => $meal->name,
                'number' => 1,
                'addRecipeInformation' => true,
                'fillIngredients' => true,
            ]);

            if (!$searchResponse->successful()) {
                return null;
            }

            $searchData = $searchResponse->json();
            if (empty($searchData['results'])) {
                return null;
            }

            $recipe = $searchData['results'][0];

            // Get detailed recipe information
            $detailResponse = Http::timeout(10)->get("https://api.spoonacular.com/recipes/{$recipe['id']}/analyzedInstructions", [
                'apiKey' => $apiKey,
            ]);

            if (!$detailResponse->successful()) {
                return null;
            }

            $instructions = $detailResponse->json();

            if (empty($instructions)) {
                return null;
            }

            // Extract steps
            $steps = [];
            foreach ($instructions as $instruction) {
                if (!empty($instruction['steps'])) {
                    foreach ($instruction['steps'] as $step) {
                        $steps[] = $step['step'];
                    }
                }
            }

            return implode("\n", $steps);

        } catch (\Exception $e) {
            $this->warn("Spoonacular API error for {$meal->name}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate basic preparation steps based on meal name and ingredients.
     */
    private function generateBasicSteps(Meal $meal): string
    {
        $ingredients = $meal->ingredients->pluck('name')->toArray();
        $name = strtolower($meal->name);

        $steps = [];

        // Basic cooking patterns based on meal type
        if (str_contains($name, 'fried rice') || str_contains($name, 'stir fry')) {
            $steps = [
                "Heat oil in a large wok or skillet over medium-high heat",
                "Add garlic and ginger, stir-fry for 30 seconds until fragrant",
                "Add protein (chicken, beef, shrimp) and cook until nearly done",
                "Add vegetables and stir-fry for 2-3 minutes",
                "Add cooked rice and soy sauce, stir-fry for 2 minutes",
                "Push everything to one side, crack eggs into pan and scramble",
                "Mix everything together and serve hot"
            ];
        } elseif (str_contains($name, 'pasta')) {
            $steps = [
                "Bring a large pot of salted water to boil",
                "Cook pasta according to package directions until al dente",
                "While pasta cooks, heat olive oil in a large skillet",
                "Add garlic and cook until fragrant (about 1 minute)",
                "Add tomatoes or sauce and simmer for 5-7 minutes",
                "Drain pasta, reserving 1 cup of pasta water",
                "Add pasta to sauce, toss to combine",
                "Add cheese and herbs, toss until melted and serve"
            ];
        } elseif (str_contains($name, 'risotto')) {
            $steps = [
                "Heat broth in a saucepan and keep warm over low heat",
                "Heat butter and oil in a large saucepan over medium heat",
                "Add onions and cook until translucent (about 5 minutes)",
                "Add rice and stir until lightly toasted (about 2 minutes)",
                "Add wine and stir until absorbed",
                "Add warm broth one ladle at a time, stirring constantly",
                "Continue adding broth and stirring until rice is creamy and tender",
                "Stir in cheese, butter, and seasonings",
                "Remove from heat, cover and let rest for 2 minutes before serving"
            ];
        } elseif (str_contains($name, 'grilled') || str_contains($name, 'baked chicken')) {
            $steps = [
                "Preheat grill or oven to 400°F (200°C)",
                "Season chicken with salt, pepper, and herbs",
                "Brush with olive oil or marinade",
                "Place chicken on grill or in oven",
                "Cook for 20-25 minutes, turning halfway through",
                "Check internal temperature reaches 165°F (74°C)",
                "Let rest for 5 minutes before slicing",
                "Serve with vegetables or rice"
            ];
        } else {
            // Generic cooking steps
            $steps = [
                "Preheat oven or heat pan to medium heat",
                "Prepare ingredients by washing and chopping as needed",
                "Heat oil or butter in a pan",
                "Add aromatics (garlic, onion) and cook until fragrant",
                "Add main ingredients and cook according to recipe",
                "Season with salt, pepper, and herbs",
                "Cook until ingredients are tender and fully cooked",
                "Serve hot with your favorite sides"
            ];
        }

        return implode("\n", $steps);
    }
}
