<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteResource extends Model
{
    protected $fillable = [
        'category',
        'title',
        'blurb',
        'url',
        'read_time',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
