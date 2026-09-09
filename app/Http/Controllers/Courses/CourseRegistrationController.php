<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    public function create(Course $course)
    {
        abort_unless($course->is_published, 404);
        abort_unless($course->requires_registration, 404);

        if ($course->registrationFor(Auth::user())) {
            return redirect()->route('courses.show', $course);
        }

        return view('courses.registration.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        abort_unless($course->is_published, 404);
        abort_unless($course->requires_registration, 404);

        if ($course->registrationFor(Auth::user())) {
            return redirect()->route('courses.show', $course);
        }

        $validated = $request->validate([
            'profession' => ['required', 'string', 'max:255'],
            'workplace' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
            'years_of_experience' => ['required', 'integer', 'min:0', 'max:70'],
        ]);

        $course->registrations()->create($validated + ['user_id' => Auth::id()]);

        return redirect()->route('courses.show', $course)
            ->with('success', "You're registered for \"{$course->title}\" — you can now proceed to buy the course.");
    }
}
