<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalCourseVisibility extends Model
{
    protected $fillable = [
        'slug',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Slugs the admin has explicitly hidden from the public site.
     *
     * @return array<int, string>
     */
    public static function hiddenSlugs(): array
    {
        return static::where('is_visible', false)->pluck('slug')->all();
    }
}
