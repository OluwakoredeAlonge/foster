<div id="site-header" class="fixed inset-x-0 top-0 z-50 transition-shadow">
  <!-- Utility bar -->
  <div class="hidden bg-emerald-950 py-2 text-emerald-100 sm:block">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-5 text-xs lg:px-8">
      <div class="flex items-center gap-5">
        <a href="tel:+2347042481085" class="flex items-center gap-1.5 hover:text-white">
          <i data-lucide="phone" class="h-3.5 w-3.5"></i> 0704 248 1085
        </a>
        <a href="mailto:heirsfosterproject@gmail.com" class="flex items-center gap-1.5 hover:text-white">
          <i data-lucide="mail" class="h-3.5 w-3.5"></i> heirsfosterproject@gmail.com
        </a>
      </div>
      <div class="flex items-center gap-3">
        <a href="#" aria-label="Instagram" class="hover:text-white"><i data-lucide="instagram" class="h-3.5 w-3.5"></i></a>
        <a href="#" aria-label="Facebook" class="hover:text-white"><i data-lucide="facebook" class="h-3.5 w-3.5"></i></a>
        <a href="#" aria-label="YouTube" class="hover:text-white"><i data-lucide="youtube" class="h-3.5 w-3.5"></i></a>
      </div>
    </div>
  </div>

  <!-- Main nav -->
  <header class="bg-white/95 backdrop-blur border-b border-slate-100">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 lg:px-8">
      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/brand/logo-mark.png') }}" alt="Fosterheirs" class="h-10 w-10 object-contain" />
        <span class="leading-tight">
          <span class="block text-sm font-bold tracking-wide text-slate-900">FOSTERHEIRS</span>
          <span class="block text-[10px] font-medium uppercase tracking-widest text-emerald-700">Mental Health Consultancy</span>
        </span>
      </a>

      <div class="hidden items-center gap-7 lg:flex">
        <a href="{{ route('home') }}#about" class="text-sm font-medium text-slate-600 hover:text-emerald-700">About</a>
        <a href="{{ route('home') }}#team" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Our Therapists</a>
        <a href="{{ route('home') }}#services" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Services</a>
        <a href="{{ route('course-catalog') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Courses</a>
        <a href="{{ route('home') }}#books" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Books</a>
        <a href="{{ route('home') }}#resources" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Resources</a>
        <a href="{{ route('home') }}#testimonials" class="text-sm font-medium text-slate-600 hover:text-emerald-700">Testimonials</a>
      </div>

      <div class="flex items-center gap-3">
        <a href="{{ route('home') }}#contact" class="hidden rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 sm:inline-flex">
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
        <a href="{{ route('home') }}#about" class="text-sm font-medium text-slate-700">About</a>
        <a href="{{ route('home') }}#team" class="text-sm font-medium text-slate-700">Our Therapists</a>
        <a href="{{ route('home') }}#services" class="text-sm font-medium text-slate-700">Services</a>
        <a href="{{ route('course-catalog') }}" class="text-sm font-medium text-slate-700">Courses</a>
        <a href="{{ route('home') }}#books" class="text-sm font-medium text-slate-700">Books</a>
        <a href="{{ route('home') }}#resources" class="text-sm font-medium text-slate-700">Resources</a>
        <a href="{{ route('home') }}#testimonials" class="text-sm font-medium text-slate-700">Testimonials</a>
        <a href="{{ route('home') }}#contact" class="mt-2 inline-flex justify-center rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white">Book a Session</a>
      </div>
    </div>
  </header>
</div>
