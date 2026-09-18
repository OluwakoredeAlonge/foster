<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPageSettingController extends Controller
{
    public function edit(): View
    {
        $settings = BlogPageSetting::current();

        return view('admin.blog-page.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'subheading' => ['nullable', 'string', 'max:1000'],
            'empty_state_text' => ['nullable', 'string', 'max:255'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'author_tagline' => ['nullable', 'string', 'max:255'],
            'author_cta_text' => ['nullable', 'string', 'max:100'],
        ]);

        BlogPageSetting::current()->update($validated);

        return redirect()->route('admin.blog-page.edit')->with('success', 'Blog page updated.');
    }
}
