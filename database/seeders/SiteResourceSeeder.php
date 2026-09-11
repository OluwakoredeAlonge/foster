<?php

namespace Database\Seeders;

use App\Models\SiteResource;
use Illuminate\Database\Seeder;

class SiteResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            ['category' => 'Wisdom for Womanhood', 'title' => 'Marks of Motherhood', 'blurb' => 'On motherhood as privilege, blessing, and the scars, seen and unseen, it can leave behind.'],
            ['category' => 'Identity & Faith', 'title' => 'When Drops Become a Flood', 'blurb' => 'Rethinking the quiet moments that build into overwhelm, and why "not enough" deserves a second look.'],
            ['category' => 'Trauma Healing', 'title' => 'Trauma, Vows and Consequences', 'blurb' => 'A reflection on the story of Jephthah, and what it teaches about trauma and the weight of vows.'],
            ['category' => 'Mental Health Awareness', 'title' => 'Buried Treasure Within', 'blurb' => 'On beauty in its time, and the eternity set in every human heart: a note on hidden worth.'],
            ['category' => 'Mental Health Awareness', 'title' => "I'm Fine... Are You?", 'blurb' => 'On the smile that hides the strain, and the quiet cost of always seeming okay.'],
            ['category' => 'Trauma Healing', 'title' => 'Healing Has a Price. Trauma Has a Bigger One.', 'blurb' => 'Why the true cost of staying unhealed almost always outweighs the cost of therapy.'],
        ];

        foreach ($resources as $index => $resource) {
            SiteResource::updateOrCreate(
                ['title' => $resource['title']],
                [
                    'category' => $resource['category'],
                    'blurb' => $resource['blurb'],
                    'url' => 'https://sojeanthonia.laravel.cloud/blog',
                    'read_time' => '5 min read',
                    'is_visible' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
