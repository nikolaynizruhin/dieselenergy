<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
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
            ->withPivot('id');
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
