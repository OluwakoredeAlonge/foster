<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
