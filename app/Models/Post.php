<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'title', 'excerpt', 'body', 'image_id',
    ];

    /**
     * Get the image that owns the post.
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
