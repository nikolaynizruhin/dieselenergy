<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'subject', 'message',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
