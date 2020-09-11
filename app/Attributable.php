<?php

namespace App;

use App\Models\Attribute;

trait Attributable
{
    /**
     * The attributes that belong to the model.
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }
}
