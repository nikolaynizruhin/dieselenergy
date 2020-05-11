<?php

namespace App;

trait Attributable
{
    /**
     * The attributes that belong to the model.
     */
    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }
}
