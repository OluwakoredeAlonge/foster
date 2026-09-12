<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::ordered()->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.form', ['testimonial' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);

        $validated['sort_order'] = (Testimonial::max('sort_order') ?? -1) + 1;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', "Testimonial from \"{$validated['client_name']}\" added.");
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);
        $validated['is_visible'] = $request->boolean('is_visible', true);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', "Testimonial from \"{$testimonial->client_name}\" updated.");
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial removed.');
    }

    public function toggle(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_visible' => ! $testimonial->is_visible]);

        return back()->with(
            'success',
            $testimonial->is_visible ? 'Testimonial is now shown on the site.' : 'Testimonial is now hidden from the site.'
        );
    }

    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_role' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);
    }
}
