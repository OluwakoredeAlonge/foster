<footer class="bg-slate-950 py-16 text-slate-300">
  <div class="mx-auto max-w-7xl px-5 lg:px-8">
    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
      <div>
        <div class="flex items-center gap-2">
          <img src="{{ asset('images/brand/logo-mark.png') }}" alt="Fosterheirs" class="h-9 w-9 object-contain" />
          <span class="text-sm font-bold tracking-wide text-white">FOSTERHEIRS</span>
        </div>
        <p class="mt-4 text-sm leading-relaxed text-slate-400">
          A team of licensed, faith-integrated therapists bridging medicine, psychology, and faith to
          restore lives and rebuild homes across Nigeria and beyond.
        </p>
        <div class="mt-4 flex items-center gap-3">
          @if($contactSettings->instagram_url)
            <a href="{{ $contactSettings->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-slate-400 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'instagram'])
            </a>
          @endif
          @if($contactSettings->facebook_url)
            <a href="{{ $contactSettings->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-slate-400 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'facebook'])
            </a>
          @endif
          @if($contactSettings->youtube_url)
            <a href="{{ $contactSettings->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-slate-400 transition hover:bg-emerald-700 hover:text-white">
              @include('partials.social-icon', ['platform' => 'youtube'])
            </a>
          @endif
        </div>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Quick Links</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li><a href="{{ route('home') }}#about" class="hover:text-white">About</a></li>
          <li><a href="{{ route('home') }}#team" class="hover:text-white">Our Therapists</a></li>
          <li><a href="{{ route('course-catalog') }}" class="hover:text-white">Courses</a></li>
          <li><a href="{{ route('home') }}#books" class="hover:text-white">Books</a></li>
          <li><a href="{{ route('home') }}#resources" class="hover:text-white">Resources</a></li>
        </ul>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Services</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          <li><a href="{{ route('home') }}#services" class="hover:text-white">Trauma Therapy</a></li>
          <li><a href="{{ route('home') }}#services" class="hover:text-white">Addiction Recovery</a></li>
          <li><a href="{{ route('home') }}#services" class="hover:text-white">Marriage Counselling</a></li>
          <li><a href="{{ route('home') }}#contact" class="hover:text-white">Book a Session</a></li>
        </ul>
      </div>
      <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-white">Contact</p>
        <ul class="mt-4 space-y-2 text-sm text-slate-400">
          @if($contactSettings->address)
            <li>{{ $contactSettings->address }}</li>
          @endif
          @if($contactSettings->phone_href)
            <li><a href="tel:{{ $contactSettings->phone_href }}" class="hover:text-white">{{ $contactSettings->phone_display }}</a></li>
          @endif
          @if($contactSettings->email)
            <li><a href="mailto:{{ $contactSettings->email }}" class="hover:text-white">{{ $contactSettings->email }}</a></li>
          @endif
        </ul>
      </div>
    </div>
    <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 text-xs text-slate-500 sm:flex-row">
      <p>&copy; {{ date('Y') }} Fosterheirs Mental Health Consultancy. All rights reserved.</p>
      <p>Founded by Dr. Anthonia Yemisi Soje</p>
    </div>
  </div>
</footer>
