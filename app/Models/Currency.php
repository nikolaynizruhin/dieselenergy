<?php

namespace App\Models;

use App\Filters\Filterable;
use Database\Factories\CurrencyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'rate', 'symbol'])]
class Currency extends Model
{
    /** @use HasFactory<CurrencyFactory> */
    use Filterable, HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['rate' => 'float'];
    }

    /**
     * Get the brands for the currency.
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
}
