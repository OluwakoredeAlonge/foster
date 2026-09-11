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
                'bio' => 'A Nigerian medical practitioner, board-certified psycho-trauma therapist, and published author. Dr. Soje leads Fosterheirs with the conviction that faith and clinical science are partners, not rivals.',
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
