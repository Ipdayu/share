<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active links ordered by sort order
    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
