<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingController extends Controller
{
    public function edit(): View
    {
        $settings = ContactSetting::current();

        return view('admin.contact-settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address' => ['nullable', 'string', 'max:500'],
            'phone_display' => ['nullable', 'string', 'max:255'],
            'phone_href' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'hours_weekday' => ['nullable', 'string', 'max:255'],
            'hours_saturday' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:2048'],
            'facebook_url' => ['nullable', 'url', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:2048'],
        ]);

        ContactSetting::current()->update($validated);

        return redirect()->route('admin.contact-settings.edit')->with('success', 'Contact settings updated.');
    }
}
