<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'image_url',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | MUTATOR
    |--------------------------------------------------------------------------
    */

    public function setSlugAttribute(?string $value): void
    {
        if (empty($value) && isset($this->attributes['title'])) {
            $this->attributes['slug'] = Str::slug($this->attributes['title']);
        } else {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
