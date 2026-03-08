<?php
// Test file to debug API access
header('Content-Type: application/json');

// Test 1: Simple JSON response
echo json_encode(['test' => 'hello from test file']);
