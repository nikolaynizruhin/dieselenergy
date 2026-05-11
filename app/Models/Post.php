<?php

namespace App\Models;

use App\Filters\Filterable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['slug', 'title', 'excerpt', 'body', 'image_id'])]
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use Filterable, HasFactory;

    /**
     * Get the image that owns the post.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
