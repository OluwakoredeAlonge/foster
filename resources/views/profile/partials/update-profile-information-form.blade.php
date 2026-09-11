<div class="flex items-center gap-2 mb-4">
    <i data-lucide="user" class="w-4.5 h-4.5 text-emerald-700"></i>
    <h3 class="text-lg font-semibold text-gray-900">Profile Information</h3>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-400 @else border-gray-300 @enderror">
        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('email') border-red-400 @else border-gray-300 @enderror">
        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-xs text-amber-700">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="font-semibold underline hover:text-amber-900">
                        {{ __('Resend verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-1 text-xs font-medium text-emerald-700">
                        {{ __('A new verification link has been sent.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-700 font-medium">
                Saved.
            </p>
        @endif
    </div>
</form>
