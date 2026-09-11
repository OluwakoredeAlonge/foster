<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
            <i data-lucide="shield-alert" class="h-7 w-7"></i>
        </span>
        <h1 class="mt-4 text-xl font-bold text-slate-900">Confirm Your Password</h1>
        <p class="mt-1.5 text-sm text-slate-500">This is a secure area. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5 block w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-3">
            <i data-lucide="check" class="h-4 w-4"></i>
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
