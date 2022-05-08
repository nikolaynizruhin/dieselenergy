<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];

    /**
     * The products that belong to the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->using(Media::class)
            ->withPivot('id', 'is_default')
            ->withTimestamps();
    }

    /**
     * Get the posts for the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the name of the image file.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): AttributeCast
    {
        return new AttributeCast(fn () => basename($this->path));
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
