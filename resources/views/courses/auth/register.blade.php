<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Fosterheirs Courses</title>
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
                <div class="w-11 h-11 rounded-full overflow-hidden ring-2 ring-white/30 mb-6 bg-white/10 flex items-center justify-center">
                    <i data-lucide="cross" class="w-5 h-5 text-white"></i>
                </div>
                <h2 class="text-2xl font-extrabold leading-tight mb-3">Start learning with Fosterheirs</h2>
                <p class="text-white/80 text-sm leading-relaxed">
                    Create a free account to buy courses, track your progress, and leave reviews.
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
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Create your account</h1>
            <p class="text-sm text-gray-500 mb-6">It only takes a minute.</p>

            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('courses.register.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow">
                    Create account
                </button>
            </form>

            <p class="text-sm text-gray-500 mt-5 text-center">
                Already have an account? <a href="{{ route('courses.login') }}" class="text-emerald-700 font-semibold hover:underline">Log in</a>
            </p>
        </div>
    </div>
</main>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
