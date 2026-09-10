<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for {{ $course->title }} | Fosterheirs Courses</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-2xl mx-auto px-4 py-10 sm:py-16">
    <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-emerald-700 transition mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to course
    </a>

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
        <div class="flex items-center gap-2.5 mb-1">
            <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-700"></i>
            </div>
            <h1 class="text-xl font-extrabold text-gray-900">Course Registration</h1>
        </div>
        <p class="text-sm text-gray-500 mb-6">
            <strong>{{ $course->title }}</strong> requires a short registration before you can purchase it. This helps us understand who's taking the course.
        </p>

        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('courses.registration.store', $course) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Profession</label>
                <input type="text" name="profession" value="{{ old('profession') }}" required
                    placeholder="e.g., Nurse, Medical Doctor, Community Health Worker"
                    class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Workplace</label>
                <input type="text" name="workplace" value="{{ old('workplace') }}" required
                    placeholder="e.g., Fosterheirs Specialist Hospital"
                    class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Highest Qualification</label>
                <input type="text" name="qualification" value="{{ old('qualification') }}" required
                    placeholder="e.g., BSc Nursing, MBBS, RN"
                    class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Years of Experience</label>
                <input type="number" name="years_of_experience" value="{{ old('years_of_experience') }}" required min="0" max="70"
                    class="w-full max-w-[160px] border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow">
                Complete Registration
            </button>
        </form>
    </div>
</main>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>
