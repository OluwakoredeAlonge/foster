@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800']) }}>
        <i data-lucide="check-circle" class="h-4 w-4 shrink-0 text-emerald-600"></i>
        {{ $status }}
    </div>
@endif
