<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageSetting;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageSettingController extends Controller
{
    public function edit(): View
    {
        $settings = LandingPageSetting::current();

        return view('admin.landing-page.edit', compact('settings'));
    }

    public function update(Request $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge_text' => ['nullable', 'string', 'max:255'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_headline_highlight' => ['nullable', 'string', 'max:255'],
            'hero_subheadline' => ['nullable', 'string', 'max:2000'],
            'hero_primary_cta_text' => ['nullable', 'string', 'max:100'],
            'hero_secondary_cta_text' => ['nullable', 'string', 'max:100'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['nullable', 'string', 'max:20'],
            'stats.*.suffix' => ['nullable', 'string', 'max:10'],
            'stats.*.label' => ['nullable', 'string', 'max:100'],

            'about_eyebrow' => ['nullable', 'string', 'max:255'],
            'about_heading' => ['nullable', 'string', 'max:255'],
            'about_paragraph' => ['nullable', 'string', 'max:2000'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'about_quote' => ['nullable', 'string', 'max:500'],
            'about_quote_citation' => ['nullable', 'string', 'max:255'],
            'about_pillars' => ['nullable', 'array'],
            'about_pillars.*.icon' => ['nullable', 'string', 'max:50'],
            'about_pillars.*.label' => ['nullable', 'string', 'max:100'],

            'services_banner_heading' => ['nullable', 'string', 'max:255'],
            'services_banner_text' => ['nullable', 'string', 'max:1000'],
            'services_banner_cta_text' => ['nullable', 'string', 'max:100'],

            'organization_eyebrow' => ['nullable', 'string', 'max:255'],
            'organization_heading' => ['nullable', 'string', 'max:255'],
            'organization_paragraph' => ['nullable', 'string', 'max:2000'],
            'organization_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'organization_programs' => ['nullable', 'array'],
            'organization_programs.*.icon' => ['nullable', 'string', 'max:50'],
            'organization_programs.*.title' => ['nullable', 'string', 'max:100'],
            'organization_programs.*.description' => ['nullable', 'string', 'max:255'],
        ]);

        $settings = LandingPageSetting::current();

        // Repeater rows arrive as a dense array from the form, including
        // any the admin left completely blank when trimming the list
        // down — drop those rather than render an empty stat/card.
        $validated['stats'] = collect($validated['stats'] ?? [])
            ->filter(fn ($row) => filled($row['value'] ?? null) && filled($row['label'] ?? null))
            ->values()->all();

        $validated['about_pillars'] = collect($validated['about_pillars'] ?? [])
            ->filter(fn ($row) => filled($row['label'] ?? null))
            ->values()->all();

        $validated['organization_programs'] = collect($validated['organization_programs'] ?? [])
            ->filter(fn ($row) => filled($row['title'] ?? null))
            ->values()->all();

        foreach (['hero_image' => 'hero_image_path', 'about_image' => 'about_image_path', 'organization_image' => 'organization_image_path'] as $upload => $pathField) {
            if ($request->hasFile($upload)) {
                $cloudinary->delete($settings->{$pathField});
                $validated[$pathField] = $cloudinary->upload($request->file($upload), 'landing-page');
            }
            unset($validated[$upload]);
        }

        $settings->update($validated);

        return redirect()->route('admin.landing-page.edit')->with('success', 'Landing page updated.');
    }
}
