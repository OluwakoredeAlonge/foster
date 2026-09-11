@php
    $seoDescription = 'Browse certified healthcare training courses from Fosterheirs — learn at your own pace and get certified.';
    $seoImage = null;
    $seoUrl = route('courses.index');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fosterheirs Courses &amp; Certification</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $seoUrl }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Fosterheirs">
    <meta property="og:title" content="Fosterheirs Courses &amp; Certification">
    <meta property="og:description" content="{{ $seoDescription }}">
    @if ($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
    @endif
    <meta property="og:url" content="{{ $seoUrl }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fosterheirs Courses &amp; Certification">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if ($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
    @endif

    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .course-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .course-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -8px rgba(5,150,105,0.12); }
        .thumb-fallback { background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 100%); }
    </style>
</head>
<body class="bg-white min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-7xl mx-auto px-4 pb-16">

    {{-- Page heading --}}
    <div class="pt-16 sm:pt-20 pb-8 border-b border-gray-100">
        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full mb-3">
            <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i>
            Fosterheirs Learning
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight max-w-2xl">
            Courses &amp; certification from our specialists
        </h1>
        <p class="mt-3 text-gray-500 max-w-xl">
            Practical, healthcare-focused courses you can learn at your own pace, with a certificate on completion.
        </p>

        {{-- Search --}}
        <form method="GET" action="{{ route('courses.index') }}" id="courseSearchForm" class="max-w-lg mt-6">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" name="search" id="courseSearchInput" value="{{ $search }}" placeholder="Search courses" autocomplete="off"
                        class="w-full pl-11 pr-4 py-3 text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white text-sm">
                </div>
                @if($sort !== 'newest')
                    <input type="hidden" name="sort" value="{{ $sort }}">
                @endif
                @if($categorySlug)
                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif
                @if($search)
                    <a href="{{ route('courses.index') }}" class="px-4 py-3 bg-gray-100 text-gray-500 rounded-xl hover:bg-gray-200 transition flex items-center">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>

        @if($categories->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-5">
                <a href="{{ route('courses.index', array_filter(['search' => $search, 'sort' => $sort !== 'newest' ? $sort : null])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ !$categorySlug ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All Categories
                </a>
                @foreach($categories as $category)
                    @if($category->courses_count > 0)
                        <a href="{{ route('courses.index', array_filter(['search' => $search, 'sort' => $sort !== 'newest' ? $sort : null, 'category' => $category->slug])) }}"
                           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ $categorySlug === $category->slug ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $category->name }} ({{ $category->courses_count }})
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                @if($search)
                    <i data-lucide="search" class="w-5 h-5 text-emerald-600"></i>
                    Results for "{{ $search }}"
                @else
                    <i data-lucide="layout-grid" class="w-5 h-5 text-emerald-600"></i>
                    All Courses
                @endif
            </h2>

            <form method="GET" action="{{ route('courses.index') }}" class="flex items-center gap-2">
                @if($search)
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif
                <label class="text-sm text-gray-500 whitespace-nowrap">Sort:</label>
                <select name="sort" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="newest" @selected($sort === 'newest')>Newest first</option>
                    <option value="price_low" @selected($sort === 'price_low')>Price: Low to high</option>
                    <option value="price_high" @selected($sort === 'price_high')>Price: High to low</option>
                </select>
            </form>
        </div>

        @if($courses->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <a href="{{ route('courses.show', $course) }}"
                       class="course-card group bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col">
                        <div class="relative flex items-center justify-center overflow-hidden {{ $course->course_image_path ? '' : 'thumb-fallback' }}" style="height:170px">
                            @if($course->course_image_path)
                                <img src="{{ $course->course_image_path }}" alt="{{ $course->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <i data-lucide="graduation-cap" class="w-14 h-14 text-emerald-500/50"></i>
                            @endif

                            @if($course->discount_percentage > 0)
                                <span class="absolute top-2.5 right-2.5 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                    -{{ $course->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                <span class="inline-flex w-fit items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                    <i data-lucide="book-open" class="w-3 h-3"></i>
                                    {{ $course->type }}
                                </span>
                                @if($course->has_certificate)
                                    <span class="inline-flex w-fit items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-blue-700 bg-blue-50 px-2 py-0.5 rounded">
                                        <i data-lucide="award" class="w-3 h-3"></i>
                                        Certificate
                                    </span>
                                @endif
                                @if($course->is_cohort)
                                    <span class="inline-flex w-fit items-center gap-1 text-[11px] font-bold uppercase tracking-wide text-amber-700 bg-amber-50 px-2 py-0.5 rounded">
                                        <i data-lucide="users" class="w-3 h-3"></i>
                                        Cohort
                                    </span>
                                @endif
                            </div>
                            @if($course->category)
                                <span class="text-[11px] text-gray-400 font-medium mb-1">{{ $course->category->name }}</span>
                            @endif
                            <h3 class="font-bold text-gray-900 leading-snug mb-2 line-clamp-2 group-hover:text-emerald-700 transition flex-1">
                                {{ $course->title }}
                            </h3>

                            @if($course->ratings_count > 0)
                                <div class="flex items-center gap-1 text-xs text-amber-500 mb-2">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                    <span class="text-gray-600 font-medium">{{ number_format($course->rating_avg, 1) }}</span>
                                    <span class="text-gray-400">({{ $course->ratings_count }})</span>
                                </div>
                            @endif

                            <div class="flex items-baseline gap-2 pt-2 mt-auto border-t border-gray-50">
                                @if($course->is_cohort)
                                    <span class="text-sm font-bold text-emerald-700 mt-2">Join the waitlist</span>
                                @else
                                    <span class="text-lg font-extrabold text-gray-900 mt-2">₦{{ number_format($course->price, 0) }}</span>
                                    @if($course->original_price)
                                        <span class="text-sm text-gray-400 line-through mt-2">₦{{ number_format($course->original_price, 0) }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $courses->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-full mb-5">
                    <i data-lucide="graduation-cap" class="text-emerald-400 w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No courses found</h3>
                <p class="text-gray-500 text-sm">
                    @if($search)
                        No courses match "{{ $search }}".
                    @else
                        Check back soon. New courses are on the way.
                    @endif
                </p>
                @if($search)
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center mt-5 px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition shadow">
                        <i data-lucide="arrow-left" class="mr-2 w-4 h-4"></i>
                        View All Courses
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- Why learn with us --}}
    <div class="mt-14 grid md:grid-cols-3 gap-4">
        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center gap-3">
            <div class="bg-emerald-100 p-2.5 rounded-xl flex-shrink-0"><i data-lucide="user-check" class="text-emerald-600 w-5 h-5"></i></div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Taught by our specialists</h3>
                <p class="text-xs text-gray-500 mt-0.5">Content built on real hospital experience</p>
            </div>
        </div>
        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center gap-3">
            <div class="bg-teal-100 p-2.5 rounded-xl flex-shrink-0"><i data-lucide="circle-play" class="text-teal-600 w-5 h-5"></i></div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Learn at your own pace</h3>
                <p class="text-xs text-gray-500 mt-0.5">Video lessons organised week by week</p>
            </div>
        </div>
        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center gap-3">
            <div class="bg-blue-100 p-2.5 rounded-xl flex-shrink-0"><i data-lucide="award" class="text-blue-600 w-5 h-5"></i></div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Certificate on completion</h3>
                <p class="text-xs text-gray-500 mt-0.5">Show it off once you have earned it</p>
            </div>
        </div>
    </div>
</main>

<footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm">
        &copy; {{ date('Y') }} Fosterheirs. All Rights Reserved.
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        const input = document.getElementById('courseSearchInput');
        const form = document.getElementById('courseSearchForm');
        let debounceTimer;

        input.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => form.submit(), 450);
        });
    });
</script>
</body>
</html>
