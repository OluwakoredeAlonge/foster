<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Courses Admin') | Fosterheirs</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">

@php
    $navGroups = [
        'Site Content' => [
            ['route' => 'admin.landing-page.edit', 'label' => 'Landing Page', 'icon' => 'layout-template'],
            ['route' => 'admin.team-members.index', 'label' => 'Our Therapists', 'icon' => 'user-round'],
            ['route' => 'admin.services.index', 'label' => 'Services', 'icon' => 'heart-handshake'],
            ['route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'icon' => 'quote'],
            ['route' => 'admin.books.index', 'label' => 'Books', 'icon' => 'book-open'],
            ['route' => 'admin.site-resources.index', 'label' => 'Resources', 'icon' => 'newspaper'],
            ['route' => 'admin.contact-settings.edit', 'label' => 'Contact Settings', 'icon' => 'phone'],
            ['route' => 'admin.external-courses.index', 'label' => 'Pulled Courses', 'icon' => 'download-cloud'],
        ],
        'Course Platform' => [
            ['route' => 'admin.courses.index', 'label' => 'Courses', 'icon' => 'book-open'],
            ['route' => 'admin.courses.categories.index', 'label' => 'Categories', 'icon' => 'tags'],
            ['route' => 'admin.courses.orders.index', 'label' => 'Orders', 'icon' => 'shopping-cart'],
            ['route' => 'admin.courses.registrations.index', 'label' => 'Registrations', 'icon' => 'clipboard-list'],
            ['route' => 'admin.courses.reviews.index', 'label' => 'Reviews', 'icon' => 'star'],
            ['route' => 'admin.courses.students.index', 'label' => 'Students', 'icon' => 'users'],
            ['route' => 'admin.courses.payment-settings.edit', 'label' => 'Payment Settings', 'icon' => 'credit-card'],
        ],
    ];
@endphp

<!-- Mobile top bar -->
<div class="flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-700 text-white">
            <i data-lucide="cross" class="h-4 w-4"></i>
        </span>
        <span class="text-sm font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
    </a>
    <button @click="sidebarOpen = true" class="rounded-lg border border-slate-200 p-2 text-slate-600">
        <i data-lucide="menu" class="h-5 w-5"></i>
    </button>
</div>

<!-- Mobile backdrop -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

<!-- Sidebar -->
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-200 ease-in-out lg:translate-x-0"
>
    <div class="flex items-center justify-between px-5 py-5">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-700 text-white">
                <i data-lucide="cross" class="h-5 w-5"></i>
            </span>
            <span class="leading-tight">
                <span class="block text-sm font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
                <span class="block text-[10px] font-medium uppercase tracking-widest text-emerald-700">Admin Panel</span>
            </span>
        </a>
        <button @click="sidebarOpen = false" class="text-slate-400 hover:text-slate-600 lg:hidden">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>

    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-2">
        @foreach ($navGroups as $groupLabel => $links)
            <div>
                <p class="px-3 pb-1.5 text-[11px] font-bold uppercase tracking-widest text-slate-400">{{ $groupLabel }}</p>
                <div class="space-y-1">
                    @foreach ($links as $link)
                        @php $active = request()->routeIs($link['route']); @endphp
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                                  {{ $active ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-700' }}">
                            <i data-lucide="{{ $link['icon'] }}" class="h-4.5 w-4.5 shrink-0"></i>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="border-t border-slate-200 p-4">
        <a href="{{ route('profile.edit') }}" class="mb-2 flex items-center gap-2 rounded-lg px-1 py-1.5 hover:bg-slate-50">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                {{ Str::of(auth()->user()->name)->substr(0, 1)->upper() }}
            </span>
            <span class="truncate text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-emerald-700">
            <i data-lucide="settings" class="h-4 w-4"></i> My Account
        </a>
        <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-emerald-700">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Site
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600">
                <i data-lucide="log-out" class="h-4 w-4"></i> Log Out
            </button>
        </form>
    </div>
</aside>

<!-- Main content -->
<div class="lg:pl-64">
    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                <i data-lucide="check-circle" class="h-5 w-5 shrink-0 text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                <i data-lucide="alert-circle" class="h-5 w-5 shrink-0 text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-800">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });</script>
</body>
</html>
