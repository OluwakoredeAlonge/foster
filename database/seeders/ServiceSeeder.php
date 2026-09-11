<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * The exact preset list Dr. Soje provided for Fosterheirs. Seeded once,
 * all visible by default — the admin panel (Admin\ServiceController)
 * lets her toggle any of these off, edit the wording, reorder, or add
 * services beyond this starting list.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Trauma Therapy & Recovery',
                'description' => 'Evidence-based trauma processing for individuals carrying deep emotional wounds and post-traumatic stress.',
                'icon' => 'heart-handshake',
            ],
            [
                'title' => 'Outpatient Addiction Recovery Clinic & Support Group',
                'description' => 'Ongoing outpatient care and peer support groups for individuals working through addiction recovery.',
                'icon' => 'life-buoy',
            ],
            [
                'title' => 'Christian Marriage & Sexuality Coaching',
                'description' => 'Restoring intimacy and communication in marriages through faith-based conflict resolution.',
                'icon' => 'users',
            ],
            [
                'title' => 'Premarital Counselling',
                'description' => 'Equipping couples with communication skills and shared expectations to build a strong foundation.',
                'icon' => 'heart',
            ],
            [
                'title' => 'Residential Addiction Recovery & Rehabilitation',
                'description' => 'Structured, live-in rehabilitation combining medical, psychological, and spiritual care.',
                'icon' => 'home',
            ],
            [
                'title' => 'Certifications & CPDs for Counsellors, Psychologists & Mental Health Professionals',
                'description' => 'Professional certification and continuing development programmes for mental health practitioners.',
                'icon' => 'graduation-cap',
            ],
            [
                'title' => 'Self-Help Recovery Courses',
                'description' => 'Structured recovery courses you can take self-paced or alongside a cohort.',
                'icon' => 'book-open',
            ],
            [
                'title' => 'Individual Therapy',
                'description' => 'One-on-one sessions tailored to your personal mental health and emotional wellbeing needs.',
                'icon' => 'brain',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service + ['is_visible' => true, 'sort_order' => $index]
            );
        }
    }
}
