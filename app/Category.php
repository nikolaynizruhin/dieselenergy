<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSearch;

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

    /**
     * The attributes that belong to the model.
     */
    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable')
            ->using(Specification::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }
}
