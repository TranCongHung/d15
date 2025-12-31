<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '=== COMMENT TRONG DATABASE ===' . PHP_EOL;
$comments = App\Models\Comment::with(['user', 'article'])->latest()->get();
foreach($comments as $comment) {
    echo 'Comment: ' . $comment->content . PHP_EOL;
    echo 'User: ' . $comment->user->name . ' (' . $comment->user->email . ')' . PHP_EOL;
    echo 'Article: ' . $comment->article->title . PHP_EOL;
    echo 'Time: ' . $comment->created_at . PHP_EOL;
    echo '---' . PHP_EOL;
}
?>





