<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'parent_id',
        'icon',
        'title',
        'description',
        'url',
        'order',
        'is_active',
        'is_subpage',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_subpage' => 'boolean',
    ];

    // Scope for active links ordered by sort order
    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    // Relationship to parent link (if it is a child link)
    public function parent()
    {
        return $this->belongsTo(Link::class, 'parent_id');
    }

    // Relationship to child links (if it is a subpage)
    public function children()
    {
        return $this->hasMany(Link::class, 'parent_id');
    }
}
