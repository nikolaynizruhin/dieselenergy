<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Media extends Pivot
{
    use HasFactory;

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
     * Unmark others default medias.
     */
    public function unmarkOtherDefaults()
    {
        if ($this->is_default) {
            self::where([
                ['product_id', '=', $this->product_id],
                ['image_id', '<>', $this->image_id],
                ['is_default', '=', 1],
            ])->update(['is_default' => 0]);
        }
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(fn ($media) => $media->unmarkOtherDefaults());
    }
}
