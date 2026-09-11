<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
            <i data-lucide="key-round" class="h-7 w-7"></i>
        </span>
        <h1 class="mt-4 text-xl font-bold text-slate-900">Forgot Your Password?</h1>
        <p class="mt-1.5 text-sm text-slate-500">No problem. Enter your email and we'll send you a link to choose a new one.</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@fosterheirs.com.ng" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-3">
            <i data-lucide="send" class="h-4 w-4"></i>
            {{ __('Email Password Reset Link') }}
        </x-primary-button>

        <p class="text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 font-semibold text-emerald-700 hover:underline">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Back to login
            </a>
        </p>
    </form>
</x-guest-layout>
