<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Partner Courses API
    |--------------------------------------------------------------------------
    |
    | Connection details for the upstream courses API (the one documented
    | with GET /api/courses and GET /api/courses/{slug}, authenticated via
    | a Sanctum bearer token). This app calls it server-side only; the
    | token must never reach the browser.
    |
    */

    'base_url' => env('COURSES_API_BASE_URL'),

    'token' => env('COURSES_API_TOKEN'),

    'timeout' => env('COURSES_API_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Public Storefront URL Template
    |--------------------------------------------------------------------------
    |
    | Where a visitor on the static Fosterheirs site should land to actually
    | purchase/access a course (the partner's own course page), since this
    | proxy only serves catalog data, not checkout. {slug} is replaced with
    | the course slug.
    |
    */

    'storefront_url_template' => env('COURSES_STOREFRONT_URL_TEMPLATE'),

    /*
    |--------------------------------------------------------------------------
    | Response Caching
    |--------------------------------------------------------------------------
    |
    | How long (seconds) trimmed catalog responses are cached, to avoid
    | hammering the partner API on every visitor page load.
    |
    */

    'cache_ttl' => env('COURSES_API_CACHE_TTL', 300),

    /*
    |--------------------------------------------------------------------------
    | Public Fields Allow-List
    |--------------------------------------------------------------------------
    |
    | Only these fields are ever forwarded to the public site. Everything
    | else the partner API returns (gated week/resource titles, YouTube
    | links, PDF download URLs, etc.) is stripped before the response
    | leaves this server. Adjust keys here once the partner's real field
    | names are confirmed, no controller changes needed.
    |
    */

    'public_fields' => [
        'id',
        'slug',
        'title',
        'price',
        'currency',
        'description',
        'category',
        'certificate',
        'access_duration',
        'rating',
        'thumbnail',
    ],

];
