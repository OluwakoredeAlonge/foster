<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Deliberately no placeholder User::factory() call here — it depends
     * on fakerphp/faker, a require-dev package that isn't installed on a
     * production `composer install --no-dev` deploy, so calling it there
     * crashes seeding outright ("Call to a member function name() on
     * null") before any of the real seeders below get to run. This app's
     * real users come from /superadmin/register (the one admin account)
     * and student self-registration, not a seeded placeholder.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            TeamMemberSeeder::class,
            BookSeeder::class,
            SiteResourceSeeder::class,
            ContactSettingSeeder::class,
            TestimonialSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
