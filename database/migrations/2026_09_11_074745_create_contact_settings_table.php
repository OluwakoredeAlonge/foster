<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Single-row settings table, same pattern as course_payment_settings. */
    public function up(): void
    {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('phone_display')->nullable();
            $table->string('phone_href')->nullable();
            $table->string('email')->nullable();
            $table->string('hours_weekday')->nullable();
            $table->string('hours_saturday')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
