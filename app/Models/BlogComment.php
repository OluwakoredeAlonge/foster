<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_post_id',
        'author_name',
        'body',
        'ip_address',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function scopeVisible($query)
    {
        return $query->whereNull('archived_at');
    }

    public function getDisplayNameAttribute(): string
    {
        $name = trim((string) $this->author_name);

        return $name !== '' ? $name : 'Anonymous';
    }
}
