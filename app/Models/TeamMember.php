<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'photo_url',
        'tags',
        'is_placeholder',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_placeholder' => 'boolean',
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

    public function initials(): string
    {
        $words = preg_split('/\s+/', trim($this->name));
        $first = mb_substr($words[0] ?? '', 0, 1);
        $last = count($words) > 1 ? mb_substr(end($words), 0, 1) : '';

        return mb_strtoupper($first.$last);
    }
}
