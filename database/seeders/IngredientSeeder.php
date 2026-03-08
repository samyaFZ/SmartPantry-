<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            // Proteins
            'chicken', 'beef', 'pork', 'fish', 'shrimp', 'turkey', 'lamb', 'duck', 'salmon', 'tuna',
            'cod', 'halibut', 'crab', 'lobster', 'scallops', 'mussels', 'clams', 'tofu', 'tempeh', 'edamame',
            
            // Vegetables
            'tomato', 'onion', 'garlic', 'carrot', 'potato', 'broccoli', 'spinach', 'bell pepper', 'zucchini', 'cucumber',
            'lettuce', 'mushroom', 'green beans', 'corn', 'asparagus', 'cauliflower', 'celery', 'radish', 'eggplant', 'kale',
            'cabbage', 'leek', 'artichoke', 'okra', 'bamboo shoots', 'water spinach', 'bok choy', 'arugula', 'Brussels sprouts',
            'beets', 'sweet potato', 'butternut squash', 'acorn squash', 'pumpkin', 'fennel', 'chard', 'collard greens',
            
            // Fruits
            'lemon', 'lime', 'avocado', 'apple', 'banana', 'orange', 'pineapple', 'mango', 'strawberry', 'blueberry',
            'raspberry', 'coconut', 'peach', 'papaya', 'kiwi', 'pomegranate', 'cranberries', 'goji berries', 'acai berries',
            
            // Grains & Bases
            'rice', 'pasta', 'bread', 'flour', 'oats', 'couscous', 'quinoa', 'barley', 'noodles', 'rice noodles',
            'tortilla', 'polenta', 'farro', 'millet', 'buckwheat', 'amaranth', 'teff',
            
            // Dairy & Cheese
            'milk', 'cheese', 'cheddar cheese', 'parmesan cheese', 'mozzarella', 'feta cheese', 'goat cheese', 'brie', 'cream cheese',
            'butter', 'yogurt', 'cream', 'sour cream', 'ricotta', 'cottage cheese', 'kefir',
            
            // Legumes & Beans
            'chickpeas', 'kidney beans', 'black beans', 'lentils', 'split peas', 'pinto beans', 'white beans', 'navy beans',
            'cannellini beans', 'fava beans',
            
            // Nuts & Seeds
            'almonds', 'walnuts', 'pecans', 'cashews', 'pistachios', 'chia seeds', 'flaxseeds', 'hemp seeds', 'pumpkin seeds',
            'sunflower seeds', 'sesame seeds',
            
            // Herbs & Spices
            'salt', 'black pepper', 'basil', 'oregano', 'cumin', 'cinnamon', 'paprika', 'thyme', 'rosemary', 'sage',
            'dill', 'cilantro', 'mint', 'parsley', 'tarragon', 'ginger', 'turmeric', 'cloves', 'nutmeg', 'bay leaf',
            'chili powder', 'cayenne pepper', 'coriander', 'cardamom', 'fennel', 'saffron', 'curry powder',
            
            // Oils & Condiments
            'olive oil', 'coconut oil', 'vegetable oil', 'sesame oil', 'soy sauce', 'vinegar', 'balsamic vinegar', 'honey',
            'mayonnaise', 'mustard', 'worcestershire sauce', 'hot sauce', 'pesto', 'tomato sauce', 'ketchup', 'tahini',
            'apple cider vinegar', 'rice vinegar',
            
            // Other
            'eggs', 'coconut milk', 'chicken broth', 'beef broth', 'vegetable broth', 'soy milk', 'almond milk', 'oat milk',
            'baking powder', 'baking soda', 'vanilla extract', 'dark chocolate', 'cacao powder', 'maple syrup', 'agave nectar',
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::firstOrCreate(['name' => $ingredient]);
        }
    }
}
