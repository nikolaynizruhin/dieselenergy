<?php

namespace App\Models;

use App\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'measure'];

    /**
     * The categories that belong to the attribute.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->using(Specification::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    /**
     * The products that belong to the attribute.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }
}
