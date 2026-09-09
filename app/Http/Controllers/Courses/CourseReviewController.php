<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        // The `auth` middleware alone doesn't distinguish students from
        // staff — they share the same guard/users table — so without this,
        // an admin or attendant account could post (and inflate) reviews.
        abort_unless(Auth::user()->role === 'student', 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $course->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return back()->with('success', 'Thanks for your review!');
    }
}
