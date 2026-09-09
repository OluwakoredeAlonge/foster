<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'profession',
        'workplace',
        'qualification',
        'years_of_experience',
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
