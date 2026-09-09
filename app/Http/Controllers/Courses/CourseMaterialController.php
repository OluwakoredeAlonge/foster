<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Auth;

class CourseMaterialController extends Controller
{
    /**
     * Redirect to the material's real (Cloudinary) file, but only after
     * confirming the logged-in user has actually paid for this course.
     * Keeps the underlying file URL out of the page source for anyone who
     * hasn't purchased — the direct link is never rendered unless access
     * is confirmed server-side, right here, on every request.
     */
    public function download(Course $course, CourseMaterial $material)
    {
        abort_unless($material->course_id === $course->id, 404);
        abort_unless($course->hasConfirmedOrderFor(Auth::user()), 403);

        return redirect($material->download_url);
    }
}
