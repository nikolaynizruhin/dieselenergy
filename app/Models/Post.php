<?php

namespace App\Models;

use App\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'title', 'excerpt', 'body', 'image_id'];
}
