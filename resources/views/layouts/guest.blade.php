<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fosterheirs') }}</title>

        <script src="https://unpkg.com/lucide@latest"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased">
        <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-gradient-to-b from-emerald-50 via-white to-white px-4 py-10">
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-emerald-100 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-24 top-1/2 h-72 w-72 rounded-full bg-amber-100 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative z-10 mb-6 flex items-center gap-2">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-700 text-white">
                    <i data-lucide="cross" class="h-6 w-6"></i>
                </span>
                <span class="leading-tight">
                    <span class="block text-base font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
                    <span class="block text-[10px] font-medium uppercase tracking-widest text-emerald-700">Mental Health Consultancy</span>
                </span>
            </a>

            <div class="relative z-10 w-full sm:max-w-md overflow-hidden rounded-2xl border border-slate-100 bg-white px-6 py-8 shadow-lg sm:px-8">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}" class="relative z-10 mt-6 inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-emerald-700">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Fosterheirs
            </a>
        </div>

        <script>document.addEventListener('DOMContentLoaded', () => { if (window.lucide) lucide.createIcons(); });</script>
    </body>
</html>
