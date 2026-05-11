<?php

namespace App\Models;

use App\Filters\Filterable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use Filterable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug', 'title', 'excerpt', 'body', 'image_id',
    ];

    /**
     * Get the image that owns the post.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
