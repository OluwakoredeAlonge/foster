<x-guest-layout>
    <div class="mb-6 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
            <i data-lucide="mail-check" class="h-7 w-7"></i>
        </span>
        <h1 class="mt-4 text-xl font-bold text-slate-900">Verify Your Email</h1>
        <p class="mt-1.5 text-sm text-slate-500">Thanks for signing up! Click the link we just emailed you to verify your address. Didn't get it? We can send another.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            <i data-lucide="check-circle" class="h-4 w-4 shrink-0 text-emerald-600"></i>
            {{ __('A new verification link has been sent to the email address you provided.') }}
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-3">
                <i data-lucide="send" class="h-4 w-4"></i>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm font-semibold text-slate-500 hover:text-emerald-700">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
