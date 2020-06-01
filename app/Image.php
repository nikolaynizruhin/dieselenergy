<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
