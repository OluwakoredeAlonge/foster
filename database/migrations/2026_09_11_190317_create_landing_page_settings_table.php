<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Single-row settings table (same pattern as contact_settings and
     * course_payment_settings) holding every piece of copy and imagery
     * on welcome.blade.php that used to be hardcoded — hero, about,
     * services banner, and the organization/impact section. Repeatable
     * bits within a section (stat counters, about "pillars", impact
     * program cards) are stored as JSON arrays rather than their own
     * tables since they're edited as a fixed-shape group, not managed
     * one-by-one like Books or Team Members.
     */
    public function up(): void
    {
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();

            $table->string('hero_badge_text')->nullable();
            $table->string('hero_headline')->nullable();
            $table->string('hero_headline_highlight')->nullable();
            $table->text('hero_subheadline')->nullable();
            $table->string('hero_primary_cta_text')->nullable();
            $table->string('hero_secondary_cta_text')->nullable();
            $table->string('hero_image_path')->nullable();

            // Shared by the hero band and the organization/impact
            // section — [{value, suffix, label}, ...].
            $table->json('stats')->nullable();

            $table->string('about_eyebrow')->nullable();
            $table->string('about_heading')->nullable();
            $table->text('about_paragraph')->nullable();
            $table->string('about_image_path')->nullable();
            $table->text('about_quote')->nullable();
            $table->string('about_quote_citation')->nullable();
            // [{icon, label}, ...] — the 4 small "Medical Intervention"
            // style cards under the about paragraph.
            $table->json('about_pillars')->nullable();

            $table->string('services_banner_heading')->nullable();
            $table->text('services_banner_text')->nullable();
            $table->string('services_banner_cta_text')->nullable();

            $table->string('organization_eyebrow')->nullable();
            $table->string('organization_heading')->nullable();
            $table->text('organization_paragraph')->nullable();
            $table->string('organization_image_path')->nullable();
            // [{icon, title, description}, ...] — the 4 "Drug & Alcohol
            // Rehab" style cards.
            $table->json('organization_programs')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};
