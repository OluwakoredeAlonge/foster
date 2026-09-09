<?php

// Minimal config for App\Services\CloudinaryService, which uses the
// framework-agnostic cloudinary/cloudinary_php SDK directly (not the
// cloudinary-labs/cloudinary-laravel wrapper — that package doesn't yet
// support Laravel 13, see composer.json history). Same three keys the
// wrapper package would have published, just hand-written.

return [
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
];
