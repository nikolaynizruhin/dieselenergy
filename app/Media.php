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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

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

    /**
     * Unmark others media as default.
     */
    public function unmarkOthersAsDefault()
    {
        if ($this->is_default) {
            self::where([
                ['product_id', '=', $this->product_id],
                ['image_id', '<>', $this->image_id],
                ['is_default', '=', 1],
            ])->update(['is_default' => 0]);
        }
    }
}
