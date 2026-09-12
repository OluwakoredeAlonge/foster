<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Blog | Fosterheirs Mental Health Consultancy</title>
<meta name="description" content="Reflections on trauma, faith, motherhood, and recovery from the Fosterheirs team." />
<script src="https://unpkg.com/lucide@latest"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">

@include('partials.site-header')

<main>
<section class="bg-slate-50 pb-16 pt-32 sm:pt-40">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <a href="{{ route('home') }}#resources" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-emerald-700">
      <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Fosterheirs
    </a>

    <div class="mx-auto mt-6 max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">From Our Therapists</span>
      <h1 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">The Fosterheirs Blog</h1>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Reflections on trauma, faith, motherhood, and recovery from the Fosterheirs team.
      </p>
    </div>

    @if($categories->count())
      <div class="mt-8 flex flex-wrap justify-center gap-2">
        <a href="{{ route('blog.index') }}"
           class="rounded-full px-4 py-2 text-xs font-semibold transition {{ !request('category') ? 'bg-emerald-700 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-300' }}">
          All
        </a>
        @foreach($categories as $cat)
          <a href="{{ route('blog.index', ['category' => $cat]) }}"
             class="rounded-full px-4 py-2 text-xs font-semibold transition {{ request('category') === $cat ? 'bg-emerald-700 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-300' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>

<div class="mx-auto max-w-7xl px-5 py-14 lg:px-8">

  @if($featuredPost)
    <a href="{{ route('blog.show', $featuredPost) }}" class="mb-10 flex flex-col overflow-hidden rounded-2xl border border-slate-200 shadow-sm transition hover:shadow-lg md:flex-row">
      <div class="md:w-2/5">
        @if($featuredPost->cover_image)
          <img src="{{ $featuredPost->cover_image }}" alt="{{ $featuredPost->title }}" class="h-56 w-full object-cover md:h-full">
        @else
          <div class="flex h-56 w-full items-center justify-center bg-gradient-to-br from-emerald-50 to-amber-50 md:h-full">
            <i data-lucide="feather" class="h-12 w-12 text-emerald-300"></i>
          </div>
        @endif
      </div>
      <div class="flex flex-1 flex-col justify-center gap-3 p-8">
        <div class="flex flex-wrap items-center gap-2">
          <span class="rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-amber-800">Featured</span>
          @if($featuredPost->category)
            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-emerald-700">{{ $featuredPost->category }}</span>
          @endif
          <span class="text-xs text-slate-400">{{ $featuredPost->read_time }} min read</span>
        </div>
        <h2 class="text-xl font-bold text-slate-900">{{ $featuredPost->title }}</h2>
        @if($featuredPost->excerpt)
          <p class="text-sm leading-relaxed text-slate-600">{{ Str::limit($featuredPost->excerpt, 180) }}</p>
        @endif
        <span class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700">Read article <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </div>
    </a>
  @endif

  @if($posts->count())
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach($posts as $post)
        <a href="{{ route('blog.show', $post) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
          @if($post->cover_image)
            <div class="h-40 overflow-hidden">
              <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
            </div>
          @else
            <div class="flex h-40 items-center justify-center bg-gradient-to-br from-emerald-50 to-amber-50">
              <i data-lucide="feather" class="h-10 w-10 text-emerald-300"></i>
            </div>
          @endif
          <div class="flex flex-1 flex-col gap-2 p-5">
            <div class="flex flex-wrap items-center gap-2">
              @if($post->category)
                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-emerald-700">{{ $post->category }}</span>
              @endif
              <span class="text-[11px] text-slate-400">{{ $post->read_time }} min read</span>
            </div>
            <h3 class="flex-1 text-base font-bold leading-snug text-slate-900 group-hover:text-emerald-700">{{ $post->title }}</h3>
            @if($post->excerpt)
              <p class="text-sm leading-relaxed text-slate-600">{{ Str::limit($post->excerpt, 100) }}</p>
            @endif
            <div class="mt-auto flex items-center justify-between border-t border-slate-50 pt-3">
              <span class="text-[11px] text-slate-400">{{ $post->published_at?->format('M j, Y') }}</span>
              <span class="text-[11px] font-semibold text-emerald-700">Read &rarr;</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <div class="mt-10">{{ $posts->onEachSide(1)->links() }}</div>
  @elseif(!$featuredPost)
    <div class="py-20 text-center">
      <i data-lucide="feather" class="mx-auto h-10 w-10 text-slate-300"></i>
      <p class="mt-4 text-sm text-slate-400">No articles yet. Check back soon.</p>
    </div>
  @endif

</div>
</main>

@include('partials.site-footer')

<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
</body>
</html>
