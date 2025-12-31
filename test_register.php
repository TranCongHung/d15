<?php

// Test register modal route with proper CSRF token
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$csrfToken = csrf_token(); // Get real CSRF token
echo "CSRF Token: " . $csrfToken . PHP_EOL;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/register-modal');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'name' => 'Test User',
    'email' => 'testuser@example.com',
    'phone' => '0912345678',
    'password' => 'password123',
    'password_confirmation' => 'password123'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest' // Simulate AJAX
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpCode . PHP_EOL;
echo "Response: " . $response . PHP_EOL;

// Check if user was created
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo PHP_EOL . "Users count after test: " . App\Models\User::count() . PHP_EOL;
$latest = App\Models\User::latest()->first();
echo "Latest user: " . $latest->name . " (" . $latest->email . ")" . PHP_EOL;
?>
