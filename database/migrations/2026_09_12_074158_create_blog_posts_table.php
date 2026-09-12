<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('featured')->default(false);
            $table->string('cover_image')->nullable();
            $table->string('external_link')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedInteger('read_time')->default(5);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
