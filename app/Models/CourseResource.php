<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    protected $fillable = [
        'course_week_id',
        'title',
        'youtube_url',
        'sort_order',
    ];

    public function week()
    {
        return $this->belongsTo(CourseWeek::class, 'course_week_id');
    }
}
