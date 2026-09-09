<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = CourseRegistration::with(['course', 'user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('profession', 'like', "%{$search}%")
                    ->orWhere('workplace', 'like', "%{$search}%")
                    ->orWhere('qualification', 'like', "%{$search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $registrations = $query->paginate(20)->appends($request->query());

        return view('admin.courses.registrations.index', compact('registrations', 'search'));
    }
}
