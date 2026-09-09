<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseReview;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = CourseReview::with(['course', 'user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $reviews = $query->paginate(20)->appends($request->query());

        return view('admin.courses.reviews.index', compact('reviews', 'search'));
    }

    public function destroy(CourseReview $review)
    {
        $review->delete();

        return back()->with('success', 'Comment removed.');
    }
}
