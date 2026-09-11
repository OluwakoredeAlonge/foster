<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteResourceController extends Controller
{
    public function index(): View
    {
        $resources = SiteResource::ordered()->get();

        return view('admin.site-resources.index', compact('resources'));
    }

    public function create(): View
    {
        return view('admin.site-resources.form', ['resource' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateResource($request);

        $validated['sort_order'] = (SiteResource::max('sort_order') ?? -1) + 1;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        SiteResource::create($validated);

        return redirect()->route('admin.site-resources.index')->with('success', "\"{$validated['title']}\" added.");
    }

    public function edit(SiteResource $siteResource): View
    {
        return view('admin.site-resources.form', ['resource' => $siteResource]);
    }

    public function update(Request $request, SiteResource $siteResource): RedirectResponse
    {
        $validated = $this->validateResource($request);
        $validated['is_visible'] = $request->boolean('is_visible', true);

        $siteResource->update($validated);

        return redirect()->route('admin.site-resources.index')->with('success', "\"{$siteResource->title}\" updated.");
    }

    public function destroy(SiteResource $siteResource): RedirectResponse
    {
        $siteResource->delete();

        return back()->with('success', 'Resource removed.');
    }

    public function toggle(SiteResource $siteResource): RedirectResponse
    {
        $siteResource->update(['is_visible' => ! $siteResource->is_visible]);

        return back()->with(
            'success',
            $siteResource->is_visible ? "\"{$siteResource->title}\" is now shown on the site." : "\"{$siteResource->title}\" is now hidden from the site."
        );
    }

    private function validateResource(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'blurb' => ['nullable', 'string', 'max:1000'],
            'url' => ['nullable', 'url', 'max:2048'],
            'read_time' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['read_time'] = $validated['read_time'] ?: '5 min read';

        return $validated;
    }
}
