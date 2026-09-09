<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = [
        'course_id',
        'week_number',
        'label',
        'file_path',
        'sort_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getDownloadUrlAttribute(): string
    {
        return app(CloudinaryService::class)->attachmentUrl($this->file_path, "{$this->label}.pdf");
    }
}
