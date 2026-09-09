<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Courses Admin') | Fosterheirs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gray-50">

<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-700 text-white">
                <i data-lucide="cross" class="h-5 w-5"></i>
            </span>
            <span class="leading-tight">
                <span class="block text-sm font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
                <span class="block text-[10px] font-medium uppercase tracking-widest text-emerald-700">Courses Admin</span>
            </span>
        </a>

        <nav class="hidden items-center gap-5 lg:flex">
            <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Courses</a>
            <a href="{{ route('admin.courses.categories.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Categories</a>
            <a href="{{ route('admin.courses.orders.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Orders</a>
            <a href="{{ route('admin.courses.registrations.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Registrations</a>
            <a href="{{ route('admin.courses.reviews.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Reviews</a>
            <a href="{{ route('admin.courses.students.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Students</a>
            <a href="{{ route('admin.courses.payment-settings.edit') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Payment Settings</a>
        </nav>

        <div class="flex items-center gap-4">
            <span class="hidden text-sm text-slate-500 sm:inline">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-red-600">
                    <i data-lucide="log-out" class="h-4 w-4"></i> Log Out
                </button>
            </form>
        </div>
    </div>
</header>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
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

<script>document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });</script>
</body>
</html>
