<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseWeek extends Model
{
    protected $fillable = [
        'course_id',
        'week_number',
        'title',
        'details',
        'sort_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function resources()
    {
        return $this->hasMany(CourseResource::class)->orderBy('sort_order');
    }

    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?: "WEEK {$this->week_number}";
    }
}
