<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'status',
        'featured',
        'cover_image',
        'external_link',
        'excerpt',
        'content',
        'tags',
        'read_time',
        'views',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'featured' => 'boolean',
        'views' => 'integer',
        'read_time' => 'integer',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
