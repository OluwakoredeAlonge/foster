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
    @case('twitter')
        <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $class ?? 'h-4 w-4' }}">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.259 5.631 5.905-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
        @break
    @case('whatsapp')
        <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $class ?? 'h-4 w-4' }}">
            <path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.78-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.62.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35z"/>
            <path d="M12.05 2C6.55 2 2.1 6.45 2.1 11.95c0 1.9.53 3.66 1.44 5.17L2 22l4.97-1.5a9.83 9.83 0 0 0 5.08 1.4h.01c5.5 0 9.94-4.45 9.94-9.95A9.9 9.9 0 0 0 12.05 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.18-1.14l-.3-.18-3.1.81.83-3.02-.2-.31a8.17 8.17 0 0 1-1.25-4.36c0-4.52 3.68-8.2 8.21-8.2a8.13 8.13 0 0 1 5.8 2.4 8.14 8.14 0 0 1 2.4 5.8c0 4.52-3.68 8.2-8.2 8.2z"/>
        </svg>
        @break
@endswitch
