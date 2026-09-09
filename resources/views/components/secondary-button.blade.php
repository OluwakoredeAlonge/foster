<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
