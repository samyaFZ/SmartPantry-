<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug-search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get ingredient by name
        $name = $this->ask('Enter ingredient to debug (e.g., tomato)');
        $ingredient = \App\Models\Ingredient::where('name', $name)->first();
        if ($ingredient) {
            $this->info("Found ingredient id={$ingredient->id} name={$ingredient->name}");
        } else {
            $this->error('Ingredient not found');
            return 1;
        }

        $mealsWith = \App\Models\Meal::whereHas('ingredients', function($q) use ($name) {
            $q->where('name', $name);
        })->get();

        $this->info('Meals containing ' . $name . ': ' . $mealsWith->count());
        foreach ($mealsWith as $meal) {
            $this->line('- ' . $meal->name);
        }

        return 0;
    }
}
