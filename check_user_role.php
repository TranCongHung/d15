<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'nguyenvana@example.com')->first();
echo 'User: ' . $user->name . PHP_EOL;
echo 'Role: ' . $user->role . PHP_EOL;
echo 'Is admin: ' . ($user->role === 'admin' ? 'YES' : 'NO') . PHP_EOL;
?>





