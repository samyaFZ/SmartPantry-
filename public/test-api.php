<?php
// Test file to verify API works
require_once __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create a GET request to the API
$request = \Illuminate\Http\Request::create('/api/meals/search?ingredients=chicken,rice,garlic', 'GET');
$response = $kernel->handle($request);

echo $response->content();
?>
