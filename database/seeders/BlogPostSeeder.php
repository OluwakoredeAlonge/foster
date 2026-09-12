<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Dr. Soje's real, already-published articles (previously only linked
     * to externally from the homepage's Resources section). Seeded here
     * with an external_link back to the originals since the full article
     * bodies live on that site — she can paste the full text into
     * `content` for any of these from /admin/blog whenever she wants it
     * to live natively here instead.
     */
    public function run(): void
    {
        $posts = [
            ['category' => 'Wisdom for Womanhood', 'title' => 'Marks of Motherhood', 'excerpt' => 'On motherhood as privilege, blessing, and the scars, seen and unseen, it can leave behind.'],
            ['category' => 'Identity & Faith', 'title' => 'When Drops Become a Flood', 'excerpt' => 'Rethinking the quiet moments that build into overwhelm, and why "not enough" deserves a second look.'],
            ['category' => 'Trauma Healing', 'title' => 'Trauma, Vows and Consequences', 'excerpt' => 'A reflection on the story of Jephthah, and what it teaches about trauma and the weight of vows.'],
            ['category' => 'Mental Health Awareness', 'title' => 'Buried Treasure Within', 'excerpt' => 'On beauty in its time, and the eternity set in every human heart: a note on hidden worth.'],
            ['category' => 'Mental Health Awareness', 'title' => "I'm Fine... Are You?", 'excerpt' => 'On the smile that hides the strain, and the quiet cost of always seeming okay.'],
            ['category' => 'Trauma Healing', 'title' => 'Healing Has a Price. Trauma Has a Bigger One.', 'excerpt' => 'Why the true cost of staying unhealed almost always outweighs the cost of therapy.'],
        ];

        foreach ($posts as $index => $post) {
            BlogPost::updateOrCreate(
                ['title' => $post['title']],
                [
                    'slug' => Str::slug($post['title']),
                    'category' => $post['category'],
                    'excerpt' => $post['excerpt'],
                    'external_link' => 'https://sojeanthonia.laravel.cloud/blog',
                    'status' => 'published',
                    'read_time' => 5,
                    'published_at' => now()->subDays(count($posts) - $index),
                ]
            );
        }
    }
}
