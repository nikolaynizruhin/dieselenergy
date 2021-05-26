<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'measure',
    ];

    /**
     * Get the attribute's field.
     *
     * @return string
     */
    public function getFieldAttribute()
    {
        return $this->measure
            ? $this->name.', '.$this->measure
            : $this->name;
    }

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
