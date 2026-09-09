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
    | Only these fields are ever forwarded to the public site. Matches
    | App\Http\Resources\CourseApiResource on the partner app (confirmed
    | by reading its source directly). 'weeks' and 'materials' hold the
    | gated week/resource titles, YouTube links and PDF download URLs,
    | those are deliberately left off this list and never reach the
    | browser. If the partner's resource shape changes, update this list,
    | no controller changes needed.
    |
    */

    'public_fields' => [
        'id',
        'slug',
        'title',
        'type',
        'details',
        'price',
        'original_price',
        'discount_percentage',
        'image_url',
        'has_certificate',
        'requires_registration',
        'access_duration_months',
        'is_lifetime_access',
        'rating_avg',
        'ratings_count',
        'category',
    ],

];
