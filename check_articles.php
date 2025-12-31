<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '=== SLUG CỦA CÁC BÀI VIẾT ===' . PHP_EOL;
$articles = App\Models\Article::all();
foreach($articles as $article) {
    echo $article->title . ' -> ' . $article->slug . PHP_EOL;
}
?>





