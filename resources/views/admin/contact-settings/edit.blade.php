@extends('layouts.admin')

@section('title', 'Contact Settings')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-2xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Contact Settings</h2>
        <p class="mt-1 text-sm text-gray-600">
            This information appears in the site header, footer, and the "Begin Your Healing Journey" contact section.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.contact-settings.update') }}"
          class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Office Address</label>
                <input type="text" name="address" value="{{ old('address', $settings->address) }}"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('address') border-red-400 @else border-gray-300 @enderror">
                @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone / WhatsApp (displayed)</label>
                <input type="text" name="phone_display" value="{{ old('phone_display', $settings->phone_display) }}"
                    placeholder="e.g. 0704 248 1085 &middot; 0806 643 5831"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('phone_display') border-red-400 @else border-gray-300 @enderror">
                @error('phone_display') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone (click-to-call number)</label>
                <input type="text" name="phone_href" value="{{ old('phone_href', $settings->phone_href) }}"
                    placeholder="e.g. +2347042481085"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('phone_href') border-red-400 @else border-gray-300 @enderror">
                @error('phone_href') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">One number, in international format — used for the "tap to call" link.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                    class="w-full max-w-sm px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('email') border-red-400 @else border-gray-300 @enderror">
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Working Hours (weekday)</label>
                <input type="text" name="hours_weekday" value="{{ old('hours_weekday', $settings->hours_weekday) }}"
                    placeholder="e.g. Mon &ndash; Fri: 8:00 AM &ndash; 6:00 PM"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Working Hours (Saturday)</label>
                <input type="text" name="hours_saturday" value="{{ old('hours_saturday', $settings->hours_saturday) }}"
                    placeholder="e.g. Saturday: 9:00 AM &ndash; 2:00 PM"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
        </div>

        <div class="pt-2 border-t border-gray-100">
            <p class="text-sm font-semibold text-gray-700 mb-3 pt-4">Social Media Links</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Instagram URL</label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}" placeholder="https://instagram.com/..."
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('instagram_url') border-red-400 @else border-gray-300 @enderror">
                    @error('instagram_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}" placeholder="https://facebook.com/..."
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('facebook_url') border-red-400 @else border-gray-300 @enderror">
                    @error('facebook_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings->youtube_url) }}" placeholder="https://youtube.com/@..."
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('youtube_url') border-red-400 @else border-gray-300 @enderror">
                    @error('youtube_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Leave a link blank to hide that icon from the site.</p>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
