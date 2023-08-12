<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    protected $casts = ['is_default' => 'boolean'];

    /**
     * Get the product that owns the media.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the image that owns the media.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Unmark others default medias.
     */
    public function unmarkOtherDefaults(): void
    {
        if ($this->is_default) {
            self::where([
                ['product_id', $this->product_id],
                ['image_id', '<>', $this->image_id],
                ['is_default', 1],
            ])->update(['is_default' => 0]);
        }
    }

    /**
     * Marks as default.
     */
    public function markAsDefault(): bool
    {
        return $this->update(['is_default' => 1]);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(fn (Media $media) => $media->unmarkOtherDefaults());
    }
}
