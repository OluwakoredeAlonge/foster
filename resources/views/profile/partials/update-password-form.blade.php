<div class="flex items-center gap-2 mb-4">
    <i data-lucide="key-round" class="w-4.5 h-4.5 text-emerald-700"></i>
    <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
</div>
<p class="text-sm text-gray-500 -mt-3 mb-4">Use a long, unique password you don't use anywhere else.</p>

<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Current Password</label>
        <input id="update_password_current_password" type="password" name="current_password" autocomplete="current-password"
            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('current_password', 'updatePassword') border-red-400 @else border-gray-300 @enderror">
        @error('current_password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
        <input id="update_password_password" type="password" name="password" autocomplete="new-password"
            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('password', 'updatePassword') border-red-400 @else border-gray-300 @enderror">
        @error('password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
        <input id="update_password_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('password_confirmation', 'updatePassword') border-red-400 @else border-gray-300 @enderror">
        @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
            Update Password
        </button>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-700 font-medium">
                Saved.
            </p>
        @endif
    </div>
</form>
