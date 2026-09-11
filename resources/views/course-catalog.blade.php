<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>All Courses | Fosterheirs Mental Health Consultancy</title>
<meta name="description" content="Browse every faith-integrated, clinically grounded course from the Fosterheirs team — addiction recovery, trauma healing, certifications, and relational wellness." />
<script src="https://unpkg.com/lucide@latest"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">

@include('partials.site-header')

<main>
<section class="bg-slate-50 pb-16 pt-32 sm:pt-40">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <a href="{{ route('home') }}#courses" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-emerald-700">
      <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Fosterheirs
    </a>

    <div class="mx-auto mt-6 max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Learn At Your Own Pace</span>
      <h1 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">All Fosterheirs Courses</h1>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Every faith-integrated, clinically grounded course from our team, browse the full catalog below.
      </p>
    </div>

    @if ($error)
      <div class="mx-auto mt-10 max-w-xl rounded-2xl border border-red-200 bg-red-50 p-6 text-center text-sm text-red-800">
        {{ $error }}
      </div>
    @elseif ($courses->isEmpty())
      <div class="mx-auto mt-14 max-w-md text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50">
          <i data-lucide="graduation-cap" class="h-8 w-8 text-emerald-400"></i>
        </div>
        <p class="mt-4 text-sm text-slate-500">No courses to show right now. Check back soon.</p>
      </div>
    @else
      <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($courses as $course)
          @include('partials.course-card', ['course' => $course])
        @endforeach
      </div>

      <div class="mt-12">
        {{ $courses->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</section>
</main>

@include('partials.site-footer')

<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
</body>
</html>
