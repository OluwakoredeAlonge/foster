{{--
    Lucide (loaded via unpkg in the admin/guest layouts) dropped brand/social
    marks years ago — <i data-lucide="instagram|facebook|youtube"> silently
    renders nothing. These are inline so the public site, which doesn't load
    Lucide at all, doesn't need to either.

    Usage: @include('partials.social-icon', ['platform' => 'instagram'])
--}}
@switch($platform)
    @case('instagram')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $class ?? 'h-4 w-4' }}">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
        </svg>
        @break
    @case('facebook')
        <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $class ?? 'h-4 w-4' }}">
            <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/>
        </svg>
        @break
    @case('youtube')
        <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $class ?? 'h-4 w-4' }}">
            <path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.51 3.5 12 3.5 12 3.5s-7.51 0-9.38.55A3.02 3.02 0 0 0 .5 6.19 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14c1.87.55 9.38.55 9.38.55s7.51 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.81zM9.75 15.57V8.43L15.82 12l-6.07 3.57z"/>
        </svg>
        @break
@endswitch
