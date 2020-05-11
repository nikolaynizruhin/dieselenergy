<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Attributable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
