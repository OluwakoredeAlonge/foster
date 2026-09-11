@php
    $price = is_numeric($course['price'] ?? null)
        ? ($course['price'] == 0 ? 'Free' : '₦' . number_format($course['price'], 0))
        : 'Paid';

    $format = ($course['is_lifetime_access'] ?? false)
        ? 'Lifetime Access'
        : (!empty($course['access_duration_months'])
            ? $course['access_duration_months'] . '-Month Access'
            : 'Course');

    $categoryLabel = $course['category']['name'] ?? $course['type'] ?? 'General';
@endphp
<div class="course-card group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <div class="relative overflow-hidden">
        @if (!empty($course['image_url']))
            <img src="{{ $course['image_url'] }}" alt="{{ $course['title'] }}" loading="lazy"
                 class="h-40 w-full object-cover transition duration-300 group-hover:scale-105" />
        @else
            <div class="flex h-40 w-full items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50">
                <i data-lucide="graduation-cap" class="h-12 w-12 text-emerald-300"></i>
            </div>
        @endif

        @if (($course['discount_percentage'] ?? 0) > 0)
            <span class="absolute right-2.5 top-2.5 rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white shadow">-{{ $course['discount_percentage'] }}%</span>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <div class="mb-2 flex flex-wrap items-center gap-1.5">
            <span class="inline-flex items-center gap-1 rounded bg-emerald-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-emerald-700">{{ $categoryLabel }}</span>
            @if ($course['has_certificate'] ?? false)
                <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-blue-700">
                    <i data-lucide="award" class="h-3 w-3"></i> Certificate
                </span>
            @endif
        </div>

        <h3 class="mb-2 line-clamp-2 flex-1 text-base font-bold leading-snug text-slate-900 transition group-hover:text-emerald-700">{{ $course['title'] }}</h3>
        <p class="mb-2 text-xs font-medium text-slate-400">{{ $format }}</p>

        @if (($course['ratings_count'] ?? 0) > 0)
            <div class="mb-2 flex items-center gap-1 text-xs text-amber-500">
                <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i>
                <span class="font-medium text-slate-600">{{ number_format($course['rating_avg'], 1) }}</span>
                <span class="text-slate-400">({{ $course['ratings_count'] }})</span>
            </div>
        @endif

        <div class="mt-auto flex items-baseline gap-2 border-t border-slate-50 pt-3">
            <span class="text-lg font-extrabold text-slate-900">{{ $price }}</span>
            @if (!empty($course['original_price']))
                <span class="text-sm text-slate-400 line-through">₦{{ number_format($course['original_price'], 0) }}</span>
            @endif
        </div>

        <a href="{{ $course['purchase_url'] ?? '#' }}" target="_blank" rel="noopener"
           class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800">
            Get Access <i data-lucide="arrow-right" class="h-4 w-4"></i>
        </a>
    </div>
</div>
