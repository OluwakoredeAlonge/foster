<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_resource_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->unsignedInteger('week_number');
            $table->unsignedInteger('resource_sort_order');
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->unique(
                ['user_id', 'course_id', 'week_number', 'resource_sort_order'],
                'course_resource_progress_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_resource_progress');
    }
};
