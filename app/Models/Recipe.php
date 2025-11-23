<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'product_link',
        'product_link_text',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
