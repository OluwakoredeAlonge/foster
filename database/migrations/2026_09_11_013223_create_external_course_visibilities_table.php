<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_course_visibilities', function (Blueprint $table) {
            $table->id();
            // Slug from the partner API (App\Http\Resources\CourseApiResource
            // on that app), not a local foreign key — these courses live on
            // heirsmultispecialisthospital.laravel.cloud, not in our DB.
            // Absence of a row for a slug means "visible" (opt-out model):
            // a brand-new course the partner publishes shows up here by
            // default, until an admin explicitly hides it.
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_course_visibilities');
    }
};
