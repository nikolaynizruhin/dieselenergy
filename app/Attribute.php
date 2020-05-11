<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The categories that belong to the attribute.
     */
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }

    /**
     * The products that belong to the attribute.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }
}
