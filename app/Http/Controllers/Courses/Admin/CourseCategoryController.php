<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::orderBy('sort_order')->withCount('courses')->get();

        return view('admin.courses.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:course_categories,name'],
        ]);

        $nextSortOrder = CourseCategory::max('sort_order') + 1;

        CourseCategory::create([
            'name' => $validated['name'],
            'sort_order' => $nextSortOrder,
        ]);

        return back()->with('success', "Category \"{$validated['name']}\" added.");
    }

    public function destroy(CourseCategory $category)
    {
        if ($category->courses()->exists()) {
            return back()->with('error', "Can't delete \"{$category->name}\" — it still has courses assigned to it. Move them to another category first.");
        }

        $category->delete();

        return back()->with('success', 'Category removed.');
    }
}
