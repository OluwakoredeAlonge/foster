<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Article/reflection teaser cards for the homepage's "Resources for
     * Your Healing Journey" section — deliberately not named "resources"
     * (the courses feature already uses that word for a course week's
     * YouTube links, see course_resources).
     */
    public function up(): void
    {
        Schema::create('site_resources', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('title');
            $table->text('blurb')->nullable();
            $table->string('url')->nullable();
            $table->string('read_time')->default('5 min read');
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_resources');
    }
};
