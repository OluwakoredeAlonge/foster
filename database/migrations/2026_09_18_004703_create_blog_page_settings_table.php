<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Single-row settings table (same pattern as landing_page_settings and
     * contact_settings) for the copy on /blog and /blog/{post} that isn't
     * any individual post's own content — the page intro, empty state, and
     * the "about the author" sidebar card shown on every post.
     */
    public function up(): void
    {
        Schema::create('blog_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->string('empty_state_text')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_tagline')->nullable();
            $table->string('author_cta_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_page_settings');
    }
};
