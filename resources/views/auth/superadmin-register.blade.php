<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
            <i data-lucide="shield-check" class="h-7 w-7"></i>
        </span>
        <h1 class="mt-4 text-xl font-bold text-slate-900">Superadmin Setup</h1>
        <p class="mt-1.5 text-sm text-slate-500">Create the one admin account for Fosterheirs. This form works once — after you sign up, this link stops working for everyone, including you.</p>
    </div>

    <div class="mb-6 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
        <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"></i>
        <p class="text-xs leading-relaxed text-amber-800">Only do this once, as the site's very first setup step. If an admin account already exists, submitting this form will not create a second one.</p>
    </div>

    <form method="POST" action="{{ route('superadmin.register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="mt-1.5 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Dr. Anthonia Yemisi Soje" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@fosterheirs.com.ng" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5 block w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1.5 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-3">
            <i data-lucide="shield-check" class="h-4 w-4"></i>
            {{ __('Create Admin Account') }}
        </x-primary-button>

        <p class="text-center text-sm text-slate-500">
            Already set up?
            <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:underline">Log in instead</a>
        </p>
    </form>
</x-guest-layout>
