<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PantryController extends Controller
{
    public function index()
    {
        // Mock data for internal presentation
        $ingredients = [
            [
                'name' => 'Organic Chicken Breast',
                'category' => 'Proteins',
                'status' => 'Fresh',
                'days_left' => 4,
                'added_at' => '2 days ago',
                'icon' => 'fas fa-drumstick-bite'
            ],
            [
                'name' => 'Baby Spinach',
                'category' => 'Vegetables',
                'status' => 'Expiring Soon',
                'days_left' => 2,
                'added_at' => '3 days ago',
                'icon' => 'fas fa-leaf'
            ],
            [
                'name' => 'Cherry Tomatoes',
                'category' => 'Vegetables',
                'status' => 'Fresh',
                'days_left' => 7,
                'added_at' => '1 day ago',
                'icon' => 'fas fa-apple-whole'
            ],
            [
                'name' => 'Greek Yogurt',
                'category' => 'Dairy',
                'status' => 'Expiring Soon',
                'days_left' => 3,
                'added_at' => '5 days ago',
                'icon' => 'fas fa-cheese'
            ],
            [
                'name' => 'Brown Rice',
                'category' => 'Grains',
                'status' => 'Fresh',
                'days_left' => 60,
                'added_at' => '2 weeks ago',
                'icon' => 'fas fa-pepper-hot'
            ],
        ];

        $stats = [
            'total_items' => count($ingredients),
            'possible_meals' => 14,
            'expiring_soon' => 2,
        ];

        return view('pantry', compact('ingredients', 'stats'));
    }
}
