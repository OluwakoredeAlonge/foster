<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseResourceProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseProgressController extends Controller
{
    public function toggle(Request $request, Course $course)
    {
        abort_unless($course->hasConfirmedOrderFor(Auth::user()), 403);

        $validated = $request->validate([
            'week_number' => ['required', 'integer', 'min:1'],
            'resource_sort_order' => ['required', 'integer', 'min:0'],
            'completed' => ['required', 'boolean'],
        ]);

        if ($validated['completed']) {
            CourseResourceProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'week_number' => $validated['week_number'],
                    'resource_sort_order' => $validated['resource_sort_order'],
                ],
                ['completed_at' => now()]
            );
        } else {
            CourseResourceProgress::where([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'week_number' => $validated['week_number'],
                'resource_sort_order' => $validated['resource_sort_order'],
            ])->delete();
        }

        return response()->json(['success' => true]);
    }
}
