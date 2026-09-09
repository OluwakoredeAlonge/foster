@php
    $seoDescription = $course->details
        ? \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', trim($course->details)), 160)
        : "{$course->title} — a course from Heirs Hospital. ₦" . number_format($course->price, 2) . ", {$course->weeks->count()} week" . ($course->weeks->count() === 1 ? '' : 's') . " of content.";
    $seoImage = $course->course_image_path ?: asset('asset/logo.jpeg');
    $seoUrl = route('courses.show', $course);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} | Heirs Hospital</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $seoUrl }}">

    {{-- Open Graph / social share preview --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Heirs Hospital">
    <meta property="og:title" content="{{ $course->title }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:url" content="{{ $seoUrl }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $course->title }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $course->title,
            'description' => $seoDescription,
            'image' => $seoImage,
            'provider' => [
                '@type' => 'Organization',
                'name' => 'Heirs Hospital',
                'sameAs' => route('home'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => number_format((float) $course->price, 2, '.', ''),
                'priceCurrency' => 'NGN',
                'url' => $seoUrl,
                'availability' => 'https://schema.org/InStock',
            ],
            ...($course->ratings_count > 0 ? [
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => (float) $course->rating_avg,
                    'reviewCount' => $course->ratings_count,
                ],
            ] : []),
        ], JSON_UNESCAPED_SLASHES) !!}
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        [x-cloak] { display: none !important; }
        .thumb-fallback { background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 100%); }
    </style>
</head>
<body class="bg-white min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-6xl mx-auto px-4 pb-16" x-data="{ tab: 'content', imageOpen: false, allOpen: false }">

    {{-- Header --}}
    <div class="pt-10 sm:pt-14 pb-6 border-b border-gray-100">
        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-emerald-700 transition mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            All courses
        </a>

        <div class="flex flex-wrap items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                <i data-lucide="book-open" class="w-3 h-3"></i>
                {{ $course->type }}
            </span>
            @if($course->category)
                <span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">
                    {{ $course->category->name }}
                </span>
            @endif
            @if($course->has_certificate)
                <span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                    <i data-lucide="award" class="w-3 h-3"></i>
                    Certificate
                </span>
            @endif
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight max-w-2xl">{{ $course->title }}</h1>

        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm">
            <div class="flex items-center gap-1.5">
                <div class="w-6 h-6 rounded-full overflow-hidden bg-emerald-600 flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('asset/logo.jpeg') }}" alt="Heirs Hospital" class="w-full h-full object-cover">
                </div>
                <span class="font-medium text-gray-700">Heirs Hospital</span>
            </div>
            <div class="flex items-center gap-1 text-amber-500">
                @for($i = 1; $i <= 5; $i++)
                    <i data-lucide="star" class="w-4 h-4 {{ $i <= round($course->rating_avg) ? 'fill-current' : '' }}"></i>
                @endfor
                <span class="text-gray-500 ml-1">({{ $course->ratings_count }} Rating{{ $course->ratings_count === 1 ? '' : 's' }})</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mt-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8 items-start mt-8">

        {{-- Left: content --}}
        <div class="lg:col-span-2">
            {{-- Tabs --}}
            <div id="course-content-tabs" class="flex gap-6 border-b border-gray-200 mb-6">
                <button @click="tab = 'content'"
                    :class="tab === 'content' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-800'"
                    class="pb-3 border-b-2 font-semibold text-sm transition flex items-center gap-1.5">
                    <i data-lucide="circle-play" class="w-4 h-4"></i> Course Content
                </button>
                <button @click="tab = 'details'"
                    :class="tab === 'details' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-800'"
                    class="pb-3 border-b-2 font-semibold text-sm transition flex items-center gap-1.5">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Details
                </button>
                <button @click="tab = 'reviews'"
                    :class="tab === 'reviews' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-800'"
                    class="pb-3 border-b-2 font-semibold text-sm transition flex items-center gap-1.5">
                    <i data-lucide="star" class="w-4 h-4"></i> Reviews
                    @if($course->ratings_count > 0)
                        <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full">{{ $course->ratings_count }}</span>
                    @endif
                </button>
            </div>

            {{-- Course Content tab --}}
            <div x-show="tab === 'content'" x-cloak x-transition.opacity class="space-y-3">
                @unless($hasAccess)
                    <div class="border border-emerald-200 bg-emerald-50 rounded-2xl p-4 mb-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="lock" class="w-4 h-4 text-emerald-700"></i>
                        </div>
                        <p class="text-sm text-emerald-800 flex-1">
                            <strong>Buy this course</strong> to unlock the videos and materials below.
                        </p>
                    </div>
                @endunless

                @if($generalMaterials->isNotEmpty())
                    <div class="border border-gray-100 rounded-2xl p-4 mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-2 px-1">Downloadable Materials</h3>
                        <div class="space-y-2">
                            @foreach($generalMaterials as $material)
                                @if($hasAccess)
                                    <a href="{{ route('courses.materials.download', [$course, $material]) }}" target="_blank"
                                       class="flex items-center gap-3 bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 rounded-xl p-3 transition group">
                                        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="file-text" class="w-4 h-4 text-red-500"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-800 flex-1 truncate group-hover:text-emerald-700">{{ $material->label }}.pdf</span>
                                        <i data-lucide="download" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                                    </a>
                                @else
                                    <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-xl p-3 opacity-60">
                                        <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-500 flex-1 truncate">{{ $material->label }}.pdf</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($course->weeks->isNotEmpty())
                    <div class="flex items-center justify-between px-1 mb-1">
                        <p class="text-xs text-gray-400">
                            {{ $course->weeks->count() }} week{{ $course->weeks->count() === 1 ? '' : 's' }} &middot;
                            {{ $course->weeks->sum(fn($w) => $w->resources->count()) }} resources
                        </p>
                        <button @click="allOpen = !allOpen; $dispatch('toggle-all-weeks', allOpen)" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1">
                            <i data-lucide="chevrons-down-up" class="w-3.5 h-3.5" x-show="allOpen"></i>
                            <i data-lucide="chevrons-up-down" class="w-3.5 h-3.5" x-show="!allOpen"></i>
                            <span x-text="allOpen ? 'Collapse all' : 'Expand all'"></span>
                        </button>
                    </div>

                    @if($hasAccess)
                        @php
                            $totalResourceCount = $course->weeks->sum(fn($w) => $w->resources->count());
                            $completedResourceCount = count($completedResourceKeys);
                        @endphp
                        @if($totalResourceCount > 0)
                            <div class="border border-gray-100 rounded-2xl p-4 mb-3">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Your Progress</p>
                                    <p id="courseProgressLabel" class="text-xs font-semibold text-emerald-700">{{ $completedResourceCount }} of {{ $totalResourceCount }} complete</p>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div id="courseProgressBar" class="h-full bg-emerald-500 transition-all duration-300"
                                         style="width: {{ $totalResourceCount > 0 ? round($completedResourceCount / $totalResourceCount * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif

                @forelse($course->weeks as $week)
                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" @toggle-all-weeks.window="open = $event.detail"
                         class="border border-gray-100 rounded-2xl overflow-hidden">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                            <span class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="font-bold text-gray-900 text-sm">{{ $week->display_title }}</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">{{ $week->resources->count() }} resource{{ $week->resources->count() === 1 ? '' : 's' }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            </span>
                        </button>
                        <div x-show="open" x-cloak x-transition class="border-t border-gray-100">
                            @if($week->details)
                                <p class="px-5 py-3 text-sm text-gray-600 bg-gray-50/60 border-b border-gray-50">{{ $week->details }}</p>
                            @endif
                            @forelse($week->resources as $resource)
                                @if($hasAccess)
                                    <div class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition border-b border-gray-50 last:border-b-0 group">
                                        <input type="checkbox" class="progress-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 flex-shrink-0"
                                            data-week="{{ $week->week_number }}" data-sort="{{ $resource->sort_order }}"
                                            {{ isset($completedResourceKeys["{$week->week_number}:{$resource->sort_order}"]) ? 'checked' : '' }}
                                            title="Mark as watched">
                                        <a href="{{ $resource->youtube_url }}" target="_blank" class="flex items-center gap-3 flex-1 min-w-0">
                                            <i data-lucide="circle-play" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                                            <span class="flex-1 truncate group-hover:text-emerald-700">{{ $resource->title }}</span>
                                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-gray-300 flex-shrink-0"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center gap-3 px-5 py-3 text-sm text-gray-400 border-b border-gray-50 last:border-b-0">
                                        <i data-lucide="lock" class="w-4 h-4 text-gray-300 flex-shrink-0"></i>
                                        <span class="flex-1">{{ $resource->title }}</span>
                                    </div>
                                @endif
                            @empty
                                <p class="px-5 py-3 text-sm text-gray-400">No resources added yet.</p>
                            @endforelse

                            @php
                                $weekMaterials = $course->materials->where('week_number', $week->week_number);
                            @endphp
                            @if($weekMaterials->isNotEmpty())
                                <div class="px-5 py-3 border-t border-gray-50 space-y-2">
                                    @foreach($weekMaterials as $material)
                                        @if($hasAccess)
                                            <a href="{{ route('courses.materials.download', [$course, $material]) }}" target="_blank"
                                               class="flex items-center gap-2.5 text-sm text-gray-700 hover:text-emerald-700 transition group">
                                                <i data-lucide="file-text" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                                                <span class="flex-1 truncate">{{ $material->label }}.pdf</span>
                                                <i data-lucide="download" class="w-3.5 h-3.5 text-gray-300 group-hover:text-emerald-600"></i>
                                            </a>
                                        @else
                                            <div class="flex items-center gap-2.5 text-sm text-gray-400">
                                                <i data-lucide="lock" class="w-4 h-4 text-gray-300 flex-shrink-0"></i>
                                                <span class="flex-1 truncate">{{ $material->label }}.pdf</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    @if($course->materials->isEmpty())
                        <div class="text-center py-16 border border-gray-100 rounded-2xl">
                            <i data-lucide="clock" class="w-10 h-10 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500 text-sm">Course content will be added soon.</p>
                        </div>
                    @endif
                @endforelse
            </div>

            {{-- Details tab --}}
            <div x-show="tab === 'details'" x-cloak x-transition.opacity class="border border-gray-100 rounded-2xl p-6 text-sm text-gray-700 leading-relaxed">
                @if($course->details)
                    {!! nl2br(e($course->details)) !!}
                @else
                    <p class="text-gray-400">No additional details provided for this course.</p>
                @endif
            </div>

            {{-- Reviews tab --}}
            <div x-show="tab === 'reviews'" x-cloak x-transition.opacity class="space-y-4">
                @if($course->ratings_count > 0)
                    <div class="flex items-center gap-4 border border-gray-100 rounded-2xl p-5">
                        <span class="text-3xl font-extrabold text-gray-900">{{ number_format($course->rating_avg, 1) }}</span>
                        <div>
                            <div class="flex items-center gap-0.5 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-4 h-4 {{ $i <= round($course->rating_avg) ? 'fill-current' : '' }}"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">Based on {{ $course->ratings_count }} rating{{ $course->ratings_count === 1 ? '' : 's' }}</p>
                        </div>
                    </div>
                @endif

                @auth
                    <div class="border border-gray-100 rounded-2xl p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-3">{{ $myReview ? 'Update your review' : 'Leave a review' }}</h3>
                        <form method="POST" action="{{ route('courses.reviews.store', $course) }}" x-data="{ rating: {{ $myReview->rating ?? 5 }} }">
                            @csrf
                            <div class="flex items-center gap-1 mb-3">
                                <template x-for="i in 5" :key="i">
                                    <button type="button" @click="rating = i" class="text-amber-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6" :fill="i <= rating ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                        </svg>
                                    </button>
                                </template>
                                <input type="hidden" name="rating" x-model="rating">
                            </div>
                            <textarea name="comment" rows="3" placeholder="Share your experience with this course (optional)"
                                class="w-full border border-gray-300 rounded-lg text-sm p-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 mb-3">{{ $myReview->comment ?? '' }}</textarea>
                            <button type="submit" class="px-5 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border border-gray-100 rounded-2xl p-5 text-sm text-gray-600">
                        <a href="{{ route('courses.login') }}" class="text-emerald-700 font-semibold hover:underline">Log in</a> to leave a review.
                    </div>
                @endauth

                @forelse($course->reviews as $review)
                    <div class="border border-gray-100 rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-gray-900 text-sm">{{ $review->user->name }}</span>
                            <div class="flex items-center gap-0.5 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12 border border-gray-100 rounded-2xl">
                        <i data-lucide="message-circle" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                        <p class="text-gray-400 text-sm">No reviews yet. Be the first to review this course.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right: sticky purchase card --}}
        <div class="lg:sticky lg:top-6">
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                @if($course->course_image_path)
                    <button type="button" @click="imageOpen = true"
                        class="relative flex items-center justify-center overflow-hidden w-full group cursor-zoom-in" style="height:180px">
                        <img src="{{ $course->course_image_path }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                            <i data-lucide="expand" class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition"></i>
                        </span>
                    </button>
                @else
                    <div class="relative flex items-center justify-center overflow-hidden thumb-fallback" style="height:180px">
                        <i data-lucide="graduation-cap" class="w-14 h-14 text-emerald-500/50"></i>
                    </div>
                @endif

                <div class="p-5">
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="text-2xl font-extrabold text-gray-900">₦{{ number_format($course->price, 2) }}</span>
                        @if($course->original_price)
                            <span class="text-sm text-gray-400 line-through">₦{{ number_format($course->original_price, 0) }}</span>
                        @endif
                        @if($course->discount_percentage > 0)
                            <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">-{{ $course->discount_percentage }}%</span>
                        @endif
                    </div>

                    @if(!$myOrder)
                        @if($course->needsRegistrationFrom(auth()->user()))
                            <a href="{{ route('courses.registration.create', $course) }}"
                               class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow flex items-center justify-center gap-2">
                                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                                Register for this course
                            </a>
                            <p class="text-center mt-2 text-xs text-gray-400">A short registration is required before you can buy this course.</p>
                        @else
                            <form method="POST" action="{{ route('courses.buy', $course) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow flex items-center justify-center gap-2">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                    Buy now
                                </button>
                            </form>
                        @endif
                    @elseif($myOrder->status === 'pending')
                        <a href="{{ route('courses.orders.show', $myOrder) }}"
                           class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition shadow flex items-center justify-center gap-2">
                            <i data-lucide="landmark" class="w-4 h-4"></i>
                            Complete Payment
                        </a>
                    @elseif($myOrder->status === 'awaiting_confirmation')
                        <a href="{{ route('courses.orders.show', $myOrder) }}"
                           class="w-full py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl transition flex items-center justify-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            Awaiting Confirmation
                        </a>
                    @elseif($myOrder->status === 'confirmed' && $myOrder->hasActiveAccess())
                        <div class="w-full py-3.5 bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold rounded-xl flex items-center justify-center gap-2">
                            <i data-lucide="badge-check" class="w-4 h-4"></i>
                            You Have Access
                        </div>
                        <a href="{{ route('courses.orders.show', $myOrder) }}"
                           class="block text-center mt-2 text-xs text-gray-500 hover:text-emerald-700 hover:underline">
                            View access code / receipt
                        </a>
                        @if($myOrder->access_expires_at)
                            <p class="text-center mt-2 text-xs text-amber-600">Access until {{ $myOrder->access_expires_at->format('M j, Y') }}</p>
                        @endif
                    @elseif($myOrder->status === 'confirmed' && $myOrder->isExpired())
                        <a href="{{ route('courses.orders.show', $myOrder) }}"
                           class="w-full py-3.5 bg-red-50 text-red-700 border border-red-200 font-bold rounded-xl transition flex items-center justify-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            Access Expired
                        </a>
                    @elseif($myOrder->status === 'revoked')
                        <a href="{{ route('courses.orders.show', $myOrder) }}"
                           class="w-full py-3.5 bg-red-50 text-red-700 border border-red-200 font-bold rounded-xl transition flex items-center justify-center gap-2">
                            <i data-lucide="circle-x" class="w-4 h-4"></i>
                            Access Revoked
                        </a>
                    @endif

                    <ul class="mt-5 space-y-2.5 text-sm text-gray-600">
                        <li class="flex items-center gap-2">
                            <i data-lucide="calendar-days" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            {{ $course->weeks->count() }} week{{ $course->weeks->count() === 1 ? '' : 's' }} of content
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="circle-play" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            {{ $course->weeks->sum(fn($w) => $w->resources->count()) }} video resources
                        </li>
                        @if($course->materials->isNotEmpty())
                            <li class="flex items-center gap-2">
                                <i data-lucide="file-text" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                {{ $course->materials->count() }} downloadable material{{ $course->materials->count() === 1 ? '' : 's' }}
                            </li>
                        @endif
                        @if($course->has_certificate)
                            <li class="flex items-center gap-2">
                                <i data-lucide="badge-check" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                Certificate of completion
                            </li>
                        @endif
                        <li class="flex items-center gap-2">
                            @if($course->access_duration_months)
                                <i data-lucide="calendar-clock" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                {{ $course->access_duration_months }} month{{ $course->access_duration_months === 1 ? '' : 's' }} access
                            @else
                                <i data-lucide="infinity" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                Lifetime access
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Course image lightbox --}}
    @if($course->course_image_path)
        <div x-show="imageOpen" x-cloak x-transition.opacity @keydown.escape.window="imageOpen = false"
             class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-6 sm:p-10"
             @click.self="imageOpen = false">
            <button type="button" @click="imageOpen = false"
                class="absolute top-4 right-4 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <div class="max-w-4xl w-full text-center">
                {{-- Fixed, bordered box — the image is always constrained inside it and can
                     never spill past its edges. The admin's Display setting only changes how
                     the image fills this box: "Fill & crop" covers it edge-to-edge (cropped),
                     "Show full image" fits the whole image inside with no cropping. --}}
                <div class="relative w-full rounded-xl overflow-hidden mx-auto bg-black/30" style="height: min(70vh, 700px);">
                    <img src="{{ $course->course_image_path }}" alt="{{ $course->title }}"
                         class="w-full h-full" style="object-fit: {{ $course->course_image_fit }};">
                </div>
                <p class="text-white font-semibold mt-4">{{ $course->title }}</p>
            </div>
        </div>
    @endif
</main>

<footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm">
        &copy; {{ date('Y') }} Heirs Hospital. All Rights Reserved.
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const checkboxes = document.querySelectorAll('.progress-checkbox');
        const progressBar = document.getElementById('courseProgressBar');
        const progressLabel = document.getElementById('courseProgressLabel');

        function updateProgressDisplay() {
            if (!progressBar || !progressLabel) return;
            const total = checkboxes.length;
            const completed = document.querySelectorAll('.progress-checkbox:checked').length;
            const pct = total > 0 ? Math.round((completed / total) * 100) : 0;
            progressBar.style.width = pct + '%';
            progressLabel.textContent = `${completed} of ${total} complete`;
        }

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                const wasChecked = checkbox.checked;
                updateProgressDisplay();

                fetch(@json(route('courses.progress.toggle', $course)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        week_number: checkbox.dataset.week,
                        resource_sort_order: checkbox.dataset.sort,
                        completed: wasChecked,
                    }),
                }).then((response) => {
                    if (!response.ok) throw new Error('save failed');
                }).catch(() => {
                    // Network hiccup or the save was rejected server-side —
                    // revert so the checkbox reflects reality rather than
                    // silently drifting from what's actually saved.
                    checkbox.checked = !wasChecked;
                    updateProgressDisplay();
                });
            });
        });
    });
</script>
</body>
</html>
