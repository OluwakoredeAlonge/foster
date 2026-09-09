@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-800 focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600']) }}>
