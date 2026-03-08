<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$count = App\Models\Meal::whereHas('ingredients', function($q){
    $q->where('name','tomato');
})->count();
echo "tomato meals=" . $count . "\n";
