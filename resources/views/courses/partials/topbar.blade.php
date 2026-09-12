{{-- Slim utility strip --}}
<div class="bg-gray-900 text-gray-300 text-xs">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-9">
        <a href="{{ route('home') }}" class="flex items-center gap-1.5 hover:text-white transition">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Back to Fosterheirs
        </a>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-gray-400 hidden sm:inline">Hi, {{ Str::before(auth()->user()->name, ' ') }}</span>
                <a href="{{ route('courses.orders.index') }}" class="hover:text-white transition">My Courses</a>
                <form method="POST" action="{{ route('courses.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-white transition">Logout</button>
                </form>
            @else
                <a href="{{ route('courses.login') }}" class="hover:text-white transition">Login</a>
                <a href="{{ route('courses.register') }}" class="hover:text-white transition font-semibold">Register</a>
            @endauth
        </div>
    </div>
</div>

{{-- Brand header --}}
<header class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
        <a href="{{ route('courses.index') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/brand/logo-mark.png') }}" alt="Fosterheirs" class="h-11 w-11 object-contain flex-shrink-0">
            <div>
                <h1 class="text-lg font-extrabold text-gray-900 leading-tight tracking-tight">Fosterheirs</h1>
                <p class="text-[11px] uppercase tracking-wider text-emerald-600 font-bold">Courses &amp; Certification</p>
            </div>
        </a>

        <a href="{{ route('courses.index') }}"
           class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-emerald-700 transition">
            <i data-lucide="layout-grid" class="w-4 h-4"></i>
            Browse all courses
        </a>
    </div>
</header>
