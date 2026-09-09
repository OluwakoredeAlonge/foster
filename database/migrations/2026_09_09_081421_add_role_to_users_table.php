<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mirrors the partner app's users.role column, trimmed to the
            // two values the course subsystem actually branches on: an
            // 'admin' manages courses at /admin/courses, a 'student' buys
            // and takes them. Null covers a plain Breeze-registered user.
            $table->enum('role', ['admin', 'student'])->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
