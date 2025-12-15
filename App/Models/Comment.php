<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'content',
    ];

  // App/Models/Comment.php

public function article(): BelongsTo
{
    return $this->belongsTo(Article::class);
}

public function user(): BelongsTo
{
    // Giả định khóa ngoại là user_id
    return $this->belongsTo(User::class); 
}
}