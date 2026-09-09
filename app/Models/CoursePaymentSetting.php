<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePaymentSetting extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'instructions',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
