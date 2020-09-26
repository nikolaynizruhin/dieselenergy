<?php

namespace App\Models;

use App\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
    ];

    /**
     * The products that belong to the image.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(Media::class)
            ->withPivot('id', 'is_default')
            ->withTimestamps();
    }

    /**
     * Get the posts for the image.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the name of the image file.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return basename($this->path);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(fn ($image) => Storage::delete($image->path));
    }
}
