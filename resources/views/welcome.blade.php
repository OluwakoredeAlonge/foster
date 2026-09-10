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

<!-- ============ HEADER / NAV ============ -->
<header id="site-header" class="fixed inset-x-0 top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-100 transition-shadow">
  <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
    <a href="#home" class="flex items-center gap-2">
      <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-700 text-white">
        <i data-lucide="cross" class="h-5 w-5"></i>
      </span>
      <span class="leading-tight">
        <span class="block text-sm font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
        <span class="block text-[10px] font-medium uppercase tracking-widest text-emerald-700">Mental Health Consultancy</span>
      </span>
    </a>

    <div class="hidden items-center gap-7 lg:flex">
      <a href="#about" class="text-sm font-medium text-slate-600 hover:text-emerald-700">About</a>
      <a href="#team" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Our Therapists</a>
      <a href="#services" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Services</a>
      <a href="#courses" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Courses</a>
      <a href="#books" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Books</a>
      <a href="#resources" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Resources</a>
      <a href="#testimonials" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Testimonials</a>
    </div>

    <div class="flex items-center gap-3">
      <a href="#contact" class="hidden rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 sm:inline-flex">
        Book a Session
      </a>
      <button id="menu-btn" aria-expanded="false" aria-label="Toggle menu" class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-700 lg:hidden">
        <i data-lucide="menu" class="h-5 w-5"></i>
        <i data-lucide="x" class="hidden h-5 w-5"></i>
      </button>
    </div>
  </nav>

  <div id="mobile-nav" class="hidden border-t border-slate-100 bg-white px-5 py-4 lg:hidden">
    <div class="flex flex-col gap-4">
      <a href="#about" class="text-sm font-medium text-slate-700">About</a>
      <a href="#team" class="text-sm font-medium text-slate-700">Our Therapists</a>
      <a href="#services" class="text-sm font-medium text-slate-700">Services</a>
      <a href="#courses" class="text-sm font-medium text-slate-700">Courses</a>
      <a href="#books" class="text-sm font-medium text-slate-700">Books</a>
      <a href="#resources" class="text-sm font-medium text-slate-700">Resources</a>
      <a href="#testimonials" class="text-sm font-medium text-slate-700">Testimonials</a>
      <a href="#contact" class="mt-2 inline-flex justify-center rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white">Book a Session</a>
    </div>
  </div>
</header>

<main>

<!-- ============ HERO ============ -->
<section id="home" class="relative overflow-hidden bg-gradient-to-b from-emerald-50 via-white to-white pt-32 pb-20 lg:pt-40 lg:pb-28">
  <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-emerald-100 blur-3xl"></div>
  <div class="pointer-events-none absolute -left-24 top-1/2 h-72 w-72 rounded-full bg-amber-100 blur-3xl"></div>

  <div class="relative mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-3xl text-center">
      <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-800">
        <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
        Medicine &middot; Psychology &middot; Faith
      </span>
      <h1 class="mt-6 text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl lg:text-6xl">
        Healing Minds.<br class="hidden sm:block" /> Restoring Homes. <span class="text-emerald-700">Renewing Hope.</span>
      </h1>
      <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
        Fosterheirs Mental Health Consultancy is a team of licensed, faith-integrated therapists led by
        Dr. Anthonia Yemisi Soje, walking with individuals and families through trauma, addiction, and
        marital healing, because lasting recovery honours the whole person: mind, body, and soul.
      </p>
      <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
        <a href="#contact" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800 sm:w-auto">
          Book a Session <i data-lucide="arrow-right" class="h-4 w-4"></i>
        </a>
        <a href="#team" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-700 sm:w-auto">
          Meet Our Therapists
        </a>
      </div>
    </div>

    <!-- Stats -->
    <div class="mx-auto mt-16 grid max-w-4xl grid-cols-2 gap-6 sm:grid-cols-4">
      <div class="text-center">
        <p class="text-3xl font-extrabold text-emerald-700 sm:text-4xl"><span data-counter="10" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Published Books</p>
      </div>
      <div class="text-center">
        <p class="text-3xl font-extrabold text-emerald-700 sm:text-4xl"><span data-counter="180" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Lives Transformed</p>
      </div>
      <div class="text-center">
        <p class="text-3xl font-extrabold text-emerald-700 sm:text-4xl"><span data-counter="20" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Marriages Restored</p>
      </div>
      <div class="text-center">
        <p class="text-3xl font-extrabold text-emerald-700 sm:text-4xl"><span data-counter="18" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Addicts Rehabilitated</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section id="about" class="py-20 lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Who We Are</span>
      <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl">A Team Devoted to Whole-Person Healing</h2>
      <p class="mt-4 text-base leading-relaxed text-slate-600">
        Founded in 2023 and based within the Heirs Specialist Hospital Complex in Oye-Ekiti, Nigeria,
        Fosterheirs brings together medical practitioners, licensed therapists, and faith-integrated
        counsellors under one roof. We believe lasting healing must address the mind, the body, and the
        soul together, so every session blends clinical expertise with compassionate, faith-anchored care.
      </p>
    </div>

    <div class="mt-14 grid grid-cols-2 gap-5 lg:grid-cols-4">
      <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
          <i data-lucide="stethoscope" class="h-6 w-6"></i>
        </div>
        <p class="mt-4 text-sm font-bold text-slate-900">Medical Intervention</p>
      </div>
      <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
          <i data-lucide="brain" class="h-6 w-6"></i>
        </div>
        <p class="mt-4 text-sm font-bold text-slate-900">Psychological Therapy</p>
      </div>
      <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
          <i data-lucide="users" class="h-6 w-6"></i>
        </div>
        <p class="mt-4 text-sm font-bold text-slate-900">Social Rehabilitation</p>
      </div>
      <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
          <i data-lucide="sparkles" class="h-6 w-6"></i>
        </div>
        <p class="mt-4 text-sm font-bold text-slate-900">Spiritual Anchoring</p>
      </div>
    </div>

    <blockquote class="mx-auto mt-16 max-w-2xl text-center">
      <i data-lucide="quote" class="mx-auto h-8 w-8 text-emerald-200"></i>
      <p class="mt-4 text-xl font-medium italic text-slate-700 sm:text-2xl">
        &ldquo;God designed the mind just as He designed the soul.&rdquo;
      </p>
      <cite class="mt-3 block text-sm font-semibold not-italic text-emerald-700">Dr. Anthonia Yemisi Soje, Founder</cite>
    </blockquote>
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

      <!-- Dr. Soje -->
      <div class="flex flex-col rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-emerald-800 text-2xl font-bold text-white">
          AS
        </div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Dr. Anthonia Yemisi Soje</h3>
        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Founder &amp; Lead Psycho-trauma Therapist</p>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">
          A Nigerian medical practitioner, board-certified psycho-trauma therapist, and published author.
          Dr. Soje leads Fosterheirs with the conviction that faith and clinical science are partners,
          not rivals.
        </p>
        <div class="mt-4 flex flex-wrap justify-center gap-1.5">
          <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-800">Physician</span>
          <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-800">Author</span>
        </div>
      </div>

      <!-- Assistant (placeholder) -->
      <div class="flex flex-col rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-slate-400 to-slate-600 text-white">
          <i data-lucide="user-round" class="h-9 w-9"></i>
        </div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Practice Assistant</h3>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Clinical &amp; Client Care Assistant</p>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">
          Coordinates scheduling and client care for the team, the friendly first point of contact on
          your healing journey.
        </p>
        <span class="mx-auto mt-4 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-800">
          <i data-lucide="clock" class="h-3 w-3"></i> Profile coming soon
        </span>
      </div>

      <!-- Therapist placeholder 1 -->
      <div class="flex flex-col rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-slate-400 to-slate-600 text-white">
          <i data-lucide="user-round" class="h-9 w-9"></i>
        </div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Therapist Name</h3>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Licensed Marriage &amp; Family Therapist</p>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">
          Supports couples and families through premarital counselling and marriage restoration, alongside
          Dr. Soje's clinical framework.
        </p>
        <span class="mx-auto mt-4 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-800">
          <i data-lucide="clock" class="h-3 w-3"></i> Profile coming soon
        </span>
      </div>

      <!-- Therapist placeholder 2 -->
      <div class="flex flex-col rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-slate-400 to-slate-600 text-white">
          <i data-lucide="user-round" class="h-9 w-9"></i>
        </div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Therapist Name</h3>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Addiction Recovery Counsellor</p>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">
          Walks alongside clients through rehabilitation and relapse prevention as part of our fourfold
          recovery approach.
        </p>
        <span class="mx-auto mt-4 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-800">
          <i data-lucide="clock" class="h-3 w-3"></i> Profile coming soon
        </span>
      </div>
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
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="heart-handshake" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Psycho-trauma Therapy</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Evidence-based trauma processing for individuals carrying deep emotional wounds and post-traumatic stress.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="life-buoy" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Addiction Recovery</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Medical, psychological, and spiritual support for lasting freedom from drug, alcohol, and behavioural addictions.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="users" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Christian Marriage &amp; Sexuality Coaching</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Restoring intimacy and communication in marriages through faith-based conflict resolution.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="brain" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Mood Disorders Management</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Structured assessment and care for anxiety, depression, and bipolar disorder in children and adults.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="compass" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Life Coaching</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Goal-oriented coaching to help you discover purpose and unlock your fullest potential.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="heart" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-base font-bold text-slate-900">Premarital Counselling</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Equipping couples with communication skills and shared expectations to build a strong foundation.</p>
        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800">Book Session <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
      </div>
    </div>

    <!-- Speaking & Events banner -->
    <div class="mt-10 flex flex-col items-center gap-6 rounded-3xl bg-emerald-900 p-8 text-center lg:flex-row lg:justify-between lg:text-left">
      <div class="flex items-center gap-4">
        <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-800 text-amber-400 sm:flex">
          <i data-lucide="mic" class="h-7 w-7"></i>
        </div>
        <div>
          <h3 class="text-xl font-bold text-white">Invite Our Therapists to Speak</h3>
          <p class="mt-1 max-w-xl text-sm text-emerald-100">Available for corporate wellness sessions, churches, conferences, retreats, and school programmes.</p>
        </div>
      </div>
      <a href="#contact" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-amber-400 px-6 py-3 text-sm font-semibold text-emerald-950 transition hover:bg-amber-300">
        Book a Speaker
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

    <div id="courses-grid" class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <!-- Loading skeletons, replaced by assets/js/main.js via getAllCourses() -->
      <div class="h-72 animate-pulse rounded-2xl bg-slate-200"></div>
      <div class="h-72 animate-pulse rounded-2xl bg-slate-200"></div>
      <div class="h-72 animate-pulse rounded-2xl bg-slate-200"></div>
      <div class="h-72 animate-pulse rounded-2xl bg-slate-200"></div>
    </div>

    <p class="mt-8 text-center text-xs text-slate-400">
      Team member? <a href="{{ route('admin') }}" class="font-medium text-emerald-700 hover:underline">Manage courses in the admin portal</a>
    </p>
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

    <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Faith &amp; Identity</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Balance: Living Fully Without Losing Yourself</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">A roadmap to living intentionally and wholly, without sacrificing purpose or identity.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Memoir</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">July 19th: An Encounter With The Enigma</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">Pain transformed into purpose: a testament to healing after deep personal trial.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Marriage &amp; Relationships</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Echoes of Eden</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">Building healthy homes and nurturing relationships rooted in love and purpose.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Addiction Recovery</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">The Addiction Compass</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">A guide to understanding addiction, navigating recovery, and building lasting sobriety.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Devotional</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Unshackled</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">Daily faith anchors for those in recovery, breaking free from addiction's chains.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Psychology</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Unmasking You</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">A guide to personality disorders: understanding human behaviour and emotional patterns.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Identity &amp; Faith</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Anchored</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">Exploring identity and self-worth through faith-based encouragement for solid ground.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
      <div class="rounded-2xl border border-slate-100 p-5">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Trauma Healing</span>
        <h3 class="mt-2 text-sm font-bold text-slate-900">Sanctuary</h3>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">A journey through trauma healing, psychological restoration, and spiritual wholeness.</p>
        <a href="#" class="mt-4 inline-block text-xs font-semibold text-emerald-700 hover:underline">View Book &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ ORGANIZATION / IMPACT ============ -->
<section id="organization" class="bg-emerald-900 py-20 text-white lg:py-28">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-xs font-semibold uppercase tracking-widest text-amber-400">Our Impact</span>
      <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Restoration, Since 2023</h2>
      <p class="mt-4 text-base leading-relaxed text-emerald-100">
        Fosterheirs operates from within the Heirs Specialist Hospital Complex in Oye-Ekiti, Nigeria, a
        sanctuary for holistic healing addressing addiction, trauma, marital crises, and emotional
        instability.
      </p>
    </div>

    <div class="mx-auto mt-14 grid max-w-3xl grid-cols-3 gap-6 text-center">
      <div>
        <p class="text-3xl font-extrabold text-amber-400 sm:text-4xl"><span data-counter="18" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-200">Addicts Rehabilitated</p>
      </div>
      <div>
        <p class="text-3xl font-extrabold text-amber-400 sm:text-4xl"><span data-counter="20" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-200">Marriages Restored</p>
      </div>
      <div>
        <p class="text-3xl font-extrabold text-amber-400 sm:text-4xl"><span data-counter="180" data-suffix="+">0</span></p>
        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-200">Lives Transformed</p>
      </div>
    </div>

    <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-2xl bg-emerald-800/60 p-6">
        <i data-lucide="glass-water" class="h-6 w-6 text-amber-400"></i>
        <p class="mt-3 text-sm font-bold">Drug &amp; Alcohol Rehab</p>
        <p class="mt-1 text-xs text-emerald-200">Comprehensive recovery programmes</p>
      </div>
      <div class="rounded-2xl bg-emerald-800/60 p-6">
        <i data-lucide="heart-handshake" class="h-6 w-6 text-amber-400"></i>
        <p class="mt-3 text-sm font-bold">Marriage Restoration</p>
        <p class="mt-1 text-xs text-emerald-200">Rebuilding broken bonds</p>
      </div>
      <div class="rounded-2xl bg-emerald-800/60 p-6">
        <i data-lucide="brain" class="h-6 w-6 text-amber-400"></i>
        <p class="mt-3 text-sm font-bold">Trauma Recovery</p>
        <p class="mt-1 text-xs text-emerald-200">Psycho-trauma therapy</p>
      </div>
      <div class="rounded-2xl bg-emerald-800/60 p-6">
        <i data-lucide="shield-check" class="h-6 w-6 text-amber-400"></i>
        <p class="mt-3 text-sm font-bold">Relapse Prevention</p>
        <p class="mt-1 text-xs text-emerald-200">Ongoing support systems</p>
      </div>
    </div>

    <div class="mt-14 flex flex-col items-center justify-between gap-6 rounded-2xl bg-emerald-800/60 p-6 sm:flex-row">
      <div class="flex items-center gap-4">
        <i data-lucide="map-pin" class="h-6 w-6 shrink-0 text-amber-400"></i>
        <p class="text-sm text-emerald-100">Heirs Specialist Hospital Complex, Oye-Ekiti, Ekiti State, Nigeria</p>
      </div>
      <a href="https://www.google.com/maps/search/Heirs+Specialist+Hospital+Complex+Oye-Ekiti" target="_blank" rel="noopener" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-semibold text-emerald-950 transition hover:bg-amber-300">
        Get Directions
      </a>
    </div>
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
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Wisdom for Womanhood</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">Marks of Motherhood</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">On motherhood as privilege, blessing, and the scars, seen and unseen, it can leave behind.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Identity &amp; Faith</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">When Drops Become a Flood</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Rethinking the quiet moments that build into overwhelm, and why "not enough" deserves a second look.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Trauma Healing</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">Trauma, Vows and Consequences</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">A reflection on the story of Jephthah, and what it teaches about trauma and the weight of vows.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Mental Health Awareness</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">Buried Treasure Within</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">On beauty in its time, and the eternity set in every human heart: a note on hidden worth.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Mental Health Awareness</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">I'm Fine... Are You?</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">On the smile that hides the strain, and the quiet cost of always seeming okay.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="group rounded-2xl border border-slate-100 p-6 transition hover:shadow-lg">
        <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-700">Trauma Healing</span>
        <h3 class="mt-2 text-base font-bold text-slate-900 group-hover:text-emerald-700">Healing Has a Price. Trauma Has a Bigger One.</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">Why the true cost of staying unhealed almost always outweighs the cost of therapy.</p>
        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700">5 min read <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i></span>
      </a>
    </div>

    <div class="mt-10 text-center">
      <a href="https://sojeanthonia.laravel.cloud/blog" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-700 hover:text-emerald-700">
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

    <div class="mt-14 grid gap-6 lg:grid-cols-3">
      <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        <div class="flex gap-0.5 text-amber-400">
          <i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-slate-600">
          "After years battling addiction alone, the team at Fosterheirs gave me something no other
          programme had: a real reason to believe recovery was possible. Today I'm three years clean."
        </p>
        <p class="mt-4 text-sm font-bold text-slate-900">Anonymous</p>
        <p class="text-xs text-slate-500">Addiction Recovery Client</p>
      </div>
      <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        <div class="flex gap-0.5 text-amber-400">
          <i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-slate-600">
          "My husband and I were on the verge of divorce. Two months of marriage counselling completely
          transformed our communication and helped us rediscover our love for each other."
        </p>
        <p class="mt-4 text-sm font-bold text-slate-900">Mrs. T. Okonkwo</p>
        <p class="text-xs text-slate-500">Marriage Counselling Client</p>
      </div>
      <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        <div class="flex gap-0.5 text-amber-400">
          <i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i><i data-lucide="star" class="h-4 w-4 fill-current"></i>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-slate-600">
          "The trauma therapy sessions were life-altering. Our therapist has a rare ability to make you
          feel truly seen and heard. I healed more than I thought possible."
        </p>
        <p class="mt-4 text-sm font-bold text-slate-900">B. Adeyemi</p>
        <p class="text-xs text-slate-500">Trauma Therapy Client</p>
      </div>
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
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="map-pin" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Office Address</p>
            <p class="mt-1 text-sm text-slate-600">Fosterheirs, Heirs Specialist Hospital Complex,<br />Oye-Ekiti, Ekiti State, Nigeria</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="phone" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Phone / WhatsApp</p>
            <p class="mt-1 text-sm text-slate-600">0704 248 1085</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><i data-lucide="clock" class="h-5 w-5"></i></div>
          <div>
            <p class="text-sm font-bold text-slate-900">Working Hours</p>
            <p class="mt-1 text-sm text-slate-600">Mon – Fri: 8:00 AM – 6:00 PM<br />Saturday: 9:00 AM – 2:00 PM</p>
          </div>
        </div>
        <div class="flex items-center gap-3 pt-2">
          <a href="#" aria-label="Instagram" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white"><i data-lucide="instagram" class="h-4 w-4"></i></a>
          <a href="#" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white"><i data-lucide="facebook" class="h-4 w-4"></i></a>
          <a href="#" aria-label="YouTube" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-emerald-700 hover:text-white"><i data-lucide="youtube" class="h-4 w-4"></i></a>
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

<!-- ============ FOOTER ============ -->
<footer class="bg-slate-950 py-16 text-slate-300">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
      <div>
        <div class="flex items-center gap-2">
          <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-700 text-white"><i data-lucide="cross" class="h-5 w-5"></i></span>
          <span class="text-sm font-bold tracking-wide text-white">FOSTERHEIRS</span>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-slate-400">
          A team of licensed, faith-integrated therapists bridging medicine, psychology, and faith to
          restore lives and rebuild homes across Nigeria and beyond.
        </p>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Quick Links</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li><a href="#about" class="hover:text-white">About</a></li>
          <li><a href="#team" class="hover:text-white">Our Therapists</a></li>
          <li><a href="#courses" class="hover:text-white">Courses</a></li>
          <li><a href="#books" class="hover:text-white">Books</a></li>
          <li><a href="#resources" class="hover:text-white">Resources</a></li>
        </ul>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Services</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li><a href="#services" class="hover:text-white">Trauma Therapy</a></li>
          <li><a href="#services" class="hover:text-white">Addiction Recovery</a></li>
          <li><a href="#services" class="hover:text-white">Marriage Counselling</a></li>
          <li><a href="#contact" class="hover:text-white">Book a Session</a></li>
        </ul>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Contact</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li>Oye-Ekiti, Ekiti State, Nigeria</li>
          <li>0704 248 1085</li>
        </ul>
      </div>
    </div>
    <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 text-xs text-slate-500 sm:flex-row">
      <p>&copy; 2026 Fosterheirs Mental Health Consultancy. All rights reserved.</p>
      <p>Founded by Dr. Anthonia Yemisi Soje</p>
    </div>
  </div>
</footer>

<script src="{{ asset('assets/js/courses.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
