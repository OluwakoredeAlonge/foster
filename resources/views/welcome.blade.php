<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Fosterheirs Mental Health Consultancy | Therapy, Faith &amp; Healing</title>
<meta name="description" content="Fosterheirs Mental Health Consultancy is a team of licensed, faith-integrated therapists offering trauma therapy, addiction recovery, marriage counselling, and courses, led by Dr. Anthonia Yemisi Soje." />
<script src="https://unpkg.com/lucide@latest"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">

@include('partials.site-header')

<main>

<!-- ============ HERO ============ -->
<section id="home" class="relative isolate overflow-hidden">
  <div class="absolute inset-0 -z-10">
    <img src="{{ $landingPage->hero_image_path ?: asset('images/hero/slider2.jpg') }}" alt="" class="h-full w-full object-cover object-top" />
    <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/85 via-emerald-950/75 to-emerald-950"></div>
  </div>

  <div class="relative mx-auto max-w-7xl px-5 pb-20 pt-40 lg:px-8 lg:pb-28 lg:pt-52">
    <div class="mx-auto max-w-3xl text-center">
      @if($landingPage->hero_badge_text)
        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-50 backdrop-blur">
          <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
          {{ $landingPage->hero_badge_text }}
        </span>
      @endif
      <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
        {{ $landingPage->hero_headline }}
        @if($landingPage->hero_headline_highlight)
          <span class="text-amber-400">{{ $landingPage->hero_headline_highlight }}</span>
        @endif
      </h1>
      @if($landingPage->hero_subheadline)
        <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-emerald-50/90 sm:text-lg">
          {{ $landingPage->hero_subheadline }}
        </p>
      @endif
      <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
        @if($landingPage->hero_primary_cta_text)
          <a href="#contact" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-amber-400 px-6 py-3 text-sm font-semibold text-emerald-950 shadow-lg shadow-black/20 transition hover:bg-amber-300 sm:w-auto">
            {{ $landingPage->hero_primary_cta_text }} <i data-lucide="arrow-right" class="h-4 w-4"></i>
          </a>
        @endif
        @if($landingPage->hero_secondary_cta_text)
          <a href="#team" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10 sm:w-auto">
            {{ $landingPage->hero_secondary_cta_text }}
          </a>
        @endif
      </div>
    </div>

    <!-- Stats -->
    @if(!empty($landingPage->stats))
      <div class="mx-auto mt-16 grid max-w-4xl grid-cols-2 gap-6 sm:grid-cols-4">
        @foreach($landingPage->stats as $stat)
          <div class="text-center">
            <p class="text-3xl font-extrabold text-amber-400 sm:text-4xl"><span data-counter="{{ (int) $stat['value'] }}" data-suffix="{{ $stat['suffix'] ?? '' }}">0</span></p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-100">{{ $stat['label'] }}</p>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section id="about" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="grid items-center gap-12 lg:grid-cols-2">
      <div class="order-2 lg:order-1">
        <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">{{ $landingPage->about_eyebrow }}</span>
        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $landingPage->about_heading }}</h2>
        <p class="mt-4 text-base leading-relaxed text-slate-600">
          {{ $landingPage->about_paragraph }}
        </p>

        @if(!empty($landingPage->about_pillars))
          <div class="mt-8 grid grid-cols-2 gap-5">
            @foreach($landingPage->about_pillars as $pillar)
              <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                  <i data-lucide="{{ $pillar['icon'] ?: 'sparkles' }}" class="h-5 w-5"></i>
                </div>
                <p class="text-sm font-bold text-slate-900">{{ $pillar['label'] }}</p>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div class="order-1 lg:order-2">
        <div class="relative">
          <div class="absolute -inset-4 -z-10 rounded-[2rem] bg-emerald-50"></div>
          <img src="{{ $landingPage->about_image_path ?: asset('images/hero/psychotherapy.jpg') }}" alt="Difficult roads lead to beautiful destinations"
               class="aspect-[4/5] w-full rounded-2xl object-cover shadow-xl" />
        </div>
      </div>
    </div>

    @if($landingPage->about_quote)
      <blockquote class="mx-auto mt-16 max-w-2xl text-center">
        <i data-lucide="quote" class="mx-auto h-8 w-8 text-emerald-200"></i>
        <p class="mt-4 text-xl font-medium italic text-slate-700 sm:text-2xl">
          &ldquo;{{ $landingPage->about_quote }}&rdquo;
        </p>
        @if($landingPage->about_quote_citation)
          <cite class="mt-3 block text-sm font-semibold not-italic text-emerald-700">{{ $landingPage->about_quote_citation }}</cite>
        @endif
      </blockquote>
    @endif
  </div>
</section>

<!-- ============ TEAM ============ -->
<section id="team" class="bg-slate-50 py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Our Therapists</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Meet the Team Behind Your Healing Journey</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Every member of the Fosterheirs team is committed to the same conviction: healing must honour the
        whole person.
      </p>
    </div>

    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($teamMembers as $member)
        <div class="flex flex-col rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
          <div class="mx-auto flex h-24 w-24 items-center justify-center overflow-hidden rounded-full {{ $member->photo_url ? '' : 'bg-gradient-to-br from-emerald-600 to-emerald-800' }} text-2xl font-bold text-white">
            @if ($member->photo_url)
              <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="h-full w-full object-cover" />
            @elseif ($member->is_placeholder)
              <i data-lucide="user-round" class="h-9 w-9"></i>
            @else
              {{ $member->initials() }}
            @endif
          </div>
          <h3 class="mt-5 text-base font-bold text-slate-900">{{ $member->name }}</h3>
          <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">{{ $member->title }}</p>
          <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $member->bio }}</p>
          @if ($member->is_placeholder)
            <span class="mx-auto mt-4 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-800">
              <i data-lucide="clock" class="h-3 w-3"></i> Profile coming soon
            </span>
          @elseif (!empty($member->tags))
            <div class="mt-4 flex flex-wrap justify-center gap-1.5">
              @foreach ($member->tags as $tag)
                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-800">{{ $tag }}</span>
              @endforeach
            </div>
          @endif
        </div>
      @empty
        <p class="col-span-full text-center text-sm text-slate-400">Team profiles are being updated.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ============ SERVICES ============ -->
<section id="services" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">What We Offer</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Services &amp; Clinical Care</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Every service flows from one conviction: where faith meets science, whole people are formed.
      </p>
    </div>

    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($services as $service)
        <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="{{ $service->icon }}" class="h-6 w-6"></i></div>
          <h3 class="mt-5 text-base font-bold text-slate-900">{{ $service->title }}</h3>
          <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $service->description }}</p>
          <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
        </div>
      @empty
        <p class="col-span-full text-center text-sm text-slate-400">Services are being updated.</p>
      @endforelse
    </div>

    <!-- Speaking & Events banner -->
    <div class="mt-10 flex flex-col items-center gap-6 rounded-3xl bg-emerald-900 p-8 text-center lg:flex-row lg:justify-between lg:text-left">
      <div class="flex items-center gap-4">
        <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-800 text-amber-400 sm:flex">
          <i data-lucide="mic" class="h-7 w-7"></i>
        </div>
        <div>
          <h3 class="text-xl font-bold text-white">{{ $landingPage->services_banner_heading }}</h3>
          <p class="mt-1 max-w-xl text-sm text-emerald-100">{{ $landingPage->services_banner_text }}</p>
        </div>
      </div>
      <a href="#contact" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-amber-400 px-6 py-3 text-sm font-semibold text-emerald-950 transition hover:bg-amber-300">
        {{ $landingPage->services_banner_cta_text }}
      </a>
    </div>
  </div>
</section>

<!-- ============ COURSES ============ -->
<section id="courses" class="bg-slate-50 py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Learn At Your Own Pace</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Fosterheirs Courses Platform</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Faith-integrated, clinically grounded courses on addiction recovery, trauma healing, and relational
        wellness, created by our therapists, available anywhere.
      </p>
    </div>

    @if (empty($featuredCourses))
      <p class="mt-14 text-center text-sm text-slate-400">Check back soon, new courses are on the way.</p>
    @else
      <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($featuredCourses as $course)
          @include('partials.course-card', ['course' => $course])
        @endforeach
      </div>
    @endif

    <div class="mt-10 text-center">
      <a href="{{ route('course-catalog') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-700">
        Load More Courses <i data-lucide="arrow-right" class="h-4 w-4"></i>
      </a>
    </div>
  </div>
</section>

<!-- ============ BOOKS ============ -->
<section id="books" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Published Works</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Books &amp; Publications</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        A growing library on mental health, relationships, addiction recovery, and faith-based healing,
        authored by our founder, Dr. A.Y. Soje.
      </p>
    </div>

    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($books as $book)
        <div class="group overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:shadow-lg">
          @if ($book->cover_image_path)
            <div class="aspect-[4/5] overflow-hidden bg-slate-50">
              <img src="{{ $book->cover_image_path }}" alt="{{ $book->title }}"
                   class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
            </div>
          @else
            <div class="flex aspect-[4/5] items-center justify-center bg-gradient-to-br from-amber-50 to-emerald-50">
              <i data-lucide="book-open" class="h-10 w-10 text-emerald-300"></i>
            </div>
          @endif
          <div class="p-5">
            <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">{{ $book->category }}</span>
            <h3 class="mt-2 text-sm font-bold text-slate-900">{{ $book->title }}</h3>
            <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ $book->blurb }}</p>
            @if($book->link_url)
              <a href="{{ $book->link_url }}" target="_blank" rel="noopener" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
            @endif
          </div>
        </div>
      @empty
        <p class="col-span-full text-center text-sm text-slate-400">Books coming soon.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ============ ORGANIZATION / IMPACT ============ -->
<section id="organization" class="relative isolate overflow-hidden py-20 text-white lg:py-28">
  <div class="absolute inset-0 -z-10">
    {{--
      blur-sm + scale-110: this photo (and any admin-uploaded replacement)
      can carry its own bold text/signage baked into the pixels — a plain
      opacity overlay alone let that bleed through and fight with the
      heading/stat text on top of it. Blurring it into a soft, indistinct
      backdrop (scaled up so the blur doesn't reveal edges) plus a near-opaque
      overlay keeps the mood of the photo without competing with real content.
    --}}
    <img src="{{ $landingPage->organization_image_path ?: asset('images/hero/dont-give-up.jpg') }}" alt="" class="h-full w-full scale-110 object-cover blur-sm" />
    <div class="absolute inset-0 bg-emerald-950/95"></div>
  </div>

  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-amber-400">{{ $landingPage->organization_eyebrow }}</span>
      <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">{{ $landingPage->organization_heading }}</h2>
      <p class="mt-4 text-base leading-relaxed text-emerald-100">
        {{ $landingPage->organization_paragraph }}
      </p>
    </div>

    @if(!empty($landingPage->stats))
      <div class="mx-auto mt-14 grid max-w-4xl grid-cols-2 gap-6 text-center sm:grid-cols-4">
        @foreach($landingPage->stats as $stat)
          <div>
            <p class="text-3xl font-extrabold text-amber-400 sm:text-4xl"><span data-counter="{{ (int) $stat['value'] }}" data-suffix="{{ $stat['suffix'] ?? '' }}">0</span></p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-200">{{ $stat['label'] }}</p>
          </div>
        @endforeach
      </div>
    @endif

    @if(!empty($landingPage->organization_programs))
      <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($landingPage->organization_programs as $program)
          <div class="rounded-2xl bg-emerald-900/70 p-6 backdrop-blur">
            <i data-lucide="{{ $program['icon'] ?: 'sparkles' }}" class="h-6 w-6 text-amber-400"></i>
            <p class="mt-3 text-sm font-bold">{{ $program['title'] }}</p>
            <p class="mt-1 text-xs text-emerald-200">{{ $program['description'] }}</p>
          </div>
        @endforeach
      </div>
    @endif

    @if($contactSettings->address)
      <div class="mt-14 flex flex-col items-center justify-between gap-6 rounded-2xl bg-emerald-900/70 p-6 backdrop-blur sm:flex-row">
        <div class="flex items-center gap-4">
          <i data-lucide="map-pin" class="h-6 w-6 shrink-0 text-amber-400"></i>
          <p class="text-sm text-emerald-100">{{ $contactSettings->address }}</p>
        </div>
        <a href="https://www.google.com/maps/search/{{ urlencode($contactSettings->address) }}" target="_blank" rel="noopener" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-semibold text-emerald-950 transition hover:bg-amber-300">
          Get Directions
        </a>
      </div>
    @endif
  </div>
</section>

<!-- ============ RESOURCES / BLOG ============ -->
<section id="resources" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">From Our Therapists</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Resources for Your Healing Journey</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Reflections on trauma, faith, motherhood, and recovery from the Fosterheirs team.
      </p>
    </div>

    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($blogPosts as $post)
        <a href="{{ route('blog.show', $post) }}" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
          @if($post->category)
            <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">{{ $post->category }}</span>
          @endif
          <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">{{ $post->title }}</h3>
          @if($post->excerpt)
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}</p>
          @endif
          <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">{{ $post->read_time }} min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
        </a>
      @empty
        <p class="col-span-full text-center text-sm text-slate-400">More reflections coming soon.</p>
      @endforelse
    </div>

    <div class="mt-10 text-center">
      <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-700">
        Read All Articles <i data-lucide="arrow-right" class="h-4 w-4"></i>
      </a>
    </div>
  </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section id="testimonials" class="bg-slate-50 py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Stories of Transformation</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">What Our Clients Say</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">Real stories from clients who've walked through healing with our therapists.</p>
    </div>

    <div class="mt-14 grid gap-6 lg:grid-cols-2">
      @forelse($testimonials as $testimonial)
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
          <div class="flex gap-0.5 text-amber-400">
            @for($i = 1; $i <= 5; $i++)
              <i data-lucide="star" class="h-4 w-4 {{ $i <= $testimonial->rating ? 'fill-current' : '' }}"></i>
            @endfor
          </div>
          <p class="mt-4 text-sm leading-relaxed text-slate-600">
            "{{ $testimonial->quote }}"
          </p>
          <p class="mt-4 text-sm font-bold text-slate-900">{{ $testimonial->client_name }}</p>
          @if($testimonial->client_role)
            <p class="text-xs text-slate-500">{{ $testimonial->client_role }}</p>
          @endif
        </div>
      @empty
        <p class="col-span-full text-center text-sm text-slate-400">Client stories coming soon.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ============ CONTACT / ENQUIRY ============ -->
<section id="contact" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Get In Touch</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">Begin Your Healing Journey</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">Take the first step toward wholeness. Reach out to schedule a consultation; we respond within 24 hours.</p>
    </div>

    <div class="mt-14 grid gap-10 lg:grid-cols-5">
      <!-- Info -->
      <div class="space-y-6 lg:col-span-2">
        @if($contactSettings->address)
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="map-pin" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Office Address</p>
            <p class="mt-1 text-sm text-slate-600">{{ $contactSettings->address }}</p>
          </div>
        </div>
        @endif
        @if($contactSettings->phone_display)
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="phone" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Phone / WhatsApp</p>
            <p class="mt-1 text-sm text-slate-600">{{ $contactSettings->phone_display }}</p>
          </div>
        </div>
        @endif
        @if($contactSettings->email)
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="mail" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Email</p>
            <p class="mt-1 text-sm text-slate-600">{{ $contactSettings->email }}</p>
          </div>
        </div>
        @endif
        @if($contactSettings->hours_weekday || $contactSettings->hours_saturday)
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="clock" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Working Hours</p>
            <p class="mt-1 text-sm text-slate-600">{{ $contactSettings->hours_weekday }}@if($contactSettings->hours_weekday && $contactSettings->hours_saturday)<br />@endif{{ $contactSettings->hours_saturday }}</p>
          </div>
        </div>
        @endif
        <div class="flex items-center gap-3 pt-2">
          @if($contactSettings->instagram_url)
            <a href="{{ $contactSettings->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'instagram'])
            </a>
          @endif
          @if($contactSettings->facebook_url)
            <a href="{{ $contactSettings->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'facebook'])
            </a>
          @endif
          @if($contactSettings->youtube_url)
            <a href="{{ $contactSettings->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'youtube'])
            </a>
          @endif
        </div>
      </div>

      <!-- Form -->
      <div class="lg:col-span-3">
        <form id="enquiry-form" class="space-y-5 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Full Name</label>
              <input type="text" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" />
            </div>
            <div>
              <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email Address</label>
              <input type="email" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" />
            </div>
          </div>
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">WhatsApp Number</label>
              <input type="tel" class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" />
            </div>
            <div>
              <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Preferred Feedback</label>
              <select class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                <option>WhatsApp text message</option>
                <option>Email reply</option>
                <option>Phone call</option>
                <option>Any, I'm flexible</option>
              </select>
            </div>
          </div>
          <div>
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">How Can We Help?</label>
            <select class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
              <option>Psycho-trauma Therapy</option>
              <option>Addiction Recovery</option>
              <option>Marriage Counselling</option>
              <option>Premarital Counselling</option>
              <option>Life Coaching</option>
              <option>Emotional Wellness</option>
              <option>Speaking / Event Booking</option>
              <option>Course / Book Inquiry</option>
              <option>General Inquiry</option>
            </select>
          </div>
          <div>
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Message</label>
            <textarea rows="4" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"></textarea>
          </div>
          <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800">
            Send Message <i data-lucide="send" class="h-4 w-4"></i>
          </button>
          <p class="text-center text-[11px] text-slate-400">This form is a prototype and isn't wired up to send messages yet.</p>
        </form>

        <div id="enquiry-success" class="hidden flex-col items-center justify-center rounded-2xl border border-emerald-100 bg-emerald-50 p-10 text-center">
          <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white"><i data-lucide="check" class="h-6 w-6"></i></div>
          <h3 class="mt-4 text-base font-bold text-slate-900">Thank you!</h3>
          <p class="mt-1 max-w-sm text-sm text-slate-600">Your message has been noted. Our team will reach out within 24 hours.</p>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

@include('partials.site-footer')

<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
</body>
</html>
