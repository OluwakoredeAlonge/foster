<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Heirs Hospital Courses</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>.hero-gradient { background: linear-gradient(135deg, #047857 0%, #0d9488 55%, #0369a1 100%); }</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-4xl mx-auto px-4 py-10 sm:py-16">
    <div class="grid md:grid-cols-2 rounded-3xl overflow-hidden shadow-xl border border-gray-100">

        {{-- Side panel --}}
        <div class="hero-gradient text-white p-8 sm:p-10 hidden md:flex flex-col justify-between">
            <div>
                <div class="w-11 h-11 rounded-full overflow-hidden ring-2 ring-white/30 mb-6">
                    <img src="{{ asset('asset/logo.jpeg') }}" alt="Heirs Hospital" class="w-full h-full object-cover">
                </div>
                <h2 class="text-2xl font-extrabold leading-tight mb-3">Welcome back</h2>
                <p class="text-white/80 text-sm leading-relaxed">
                    Log in to buy courses, pick up where you left off, and manage your reviews.
                </p>
            </div>
            <ul class="space-y-3 text-sm mt-8">
                <li class="flex items-center gap-2"><i data-lucide="badge-check" class="w-4 h-4"></i> Certificates on completion</li>
                <li class="flex items-center gap-2"><i data-lucide="circle-play" class="w-4 h-4"></i> Learn at your own pace</li>
                <li class="flex items-center gap-2"><i data-lucide="shield-check" class="w-4 h-4"></i> Taught by our specialists</li>
            </ul>
        </div>

        {{-- Form --}}
        <div class="bg-white p-8 sm:p-10">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Log in</h1>
            <p class="text-sm text-gray-500 mb-6">Access your courses and account.</p>

            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('courses.login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    Remember me
                </label>
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow">
                    Log in
                </button>
            </form>

            <p class="text-sm text-gray-500 mt-5 text-center">
                Don't have an account? <a href="{{ route('courses.register') }}" class="text-emerald-700 font-semibold hover:underline">Register</a>
            </p>
        </div>
    </div>
</main>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
