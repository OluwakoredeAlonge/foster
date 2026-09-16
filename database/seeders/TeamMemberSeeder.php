<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Dr. Anthonia Yemisi Soje',
                'title' => 'Founder & Lead Psycho-trauma Therapist',
                'bio' => 'Dr. Anthonia Soje is a Physician, Hospital Administrator, Entrepreneur, Psychotrauma-Informed Therapist, Addiction Recovery Therapist, Certified Transformational Life Coach and Strategist, Certified Christian Marriage and Sexuality Coach, Educator, Author, and Speaker. Her multidisciplinary work sits at the intersection of medicine, mental health, trauma, addiction, relationships, faith, and personal transformation. As a psychotrauma-informed therapist, she integrates approaches including CBT, Compassionate Inquiry, Inner Child Work, and Hypnotherapy to help individuals understand the patterns that shape their lives, heal from difficult experiences, and develop healthier ways of living and relating. Through addiction recovery therapy, transformational coaching, and Christian marriage and sexuality coaching, she supports individuals and couples in building healthier identities, relationships, emotional resilience, and purposeful lives. Beyond therapy and coaching, Dr. Soje is passionate about healthcare, education, leadership, entrepreneurship, and social impact. As an educator, author, and speaker, she translates complex ideas into practical knowledge that inspires insight, growth, and meaningful action. Her work reflects a commitment to holistic wellbeing—recognizing that healthy individuals contribute to healthier families, organizations, and communities. Beyond her professional roles, she is a wife, mother, and Christian, and these identities deeply inform her values and approach to life and service. Her overarching mission is to help people heal what has wounded them, understand what shapes them, discover who they can become, and intentionally build lives of purpose and impact.',
                'photo_url' => asset('images/team/dr-soje.jpg'),
                'tags' => ['Physician', 'Author'],
                'is_placeholder' => false,
            ],
            [
                'name' => 'Funmi Oladimeji',
                'title' => 'Office Manager',
                'bio' => 'Coordinates scheduling and client care for the team, the friendly first point of contact on your healing journey.',
                'photo_url' => asset('images/team/funmi-oladimeji.jpg'),
                'tags' => ['Office Manager'],
                'is_placeholder' => false,
            ],
            [
                'name' => 'Therapist Name',
                'title' => 'Licensed Marriage & Family Therapist',
                'bio' => "Supports couples and families through premarital counselling and marriage restoration, alongside Dr. Soje's clinical framework.",
                'tags' => [],
                'is_placeholder' => true,
            ],
            [
                'name' => 'Therapist Name',
                'title' => 'Addiction Recovery Counsellor',
                'bio' => 'Walks alongside clients through rehabilitation and relapse prevention as part of our fourfold recovery approach.',
                'tags' => [],
                'is_placeholder' => true,
            ],
        ];

        foreach ($members as $index => $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name'], 'title' => $member['title']],
                $member + ['is_visible' => true, 'sort_order' => $index]
            );
        }
    }
}
