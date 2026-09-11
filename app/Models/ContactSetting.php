<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'address',
        'phone_display',
        'phone_href',
        'email',
        'hours_weekday',
        'hours_saturday',
        'instagram_url',
        'facebook_url',
        'youtube_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
