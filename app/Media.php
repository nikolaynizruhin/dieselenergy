<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Media extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image_product';

    /**
     * Get the product that owns the media.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the image that owns the media.
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
