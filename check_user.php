<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SAU KHI SUBMIT FORM ĐĂNG KÝ ===" . PHP_EOL;
echo "Users: " . App\Models\User::count() . PHP_EOL;

$latest = App\Models\User::latest()->first();
echo "Latest user: " . $latest->name . " - " . $latest->email . PHP_EOL;
echo "Phone: " . $latest->phone . PHP_EOL;
echo "Role: " . $latest->role . PHP_EOL;
echo "Created at: " . $latest->created_at . PHP_EOL;

echo PHP_EOL . "All users:" . PHP_EOL;
foreach(App\Models\User::all() as $user) {
    echo "- " . $user->name . " (" . $user->email . ") - " . $user->phone . PHP_EOL;
}
?>





