<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['image' => 'echoes-of-eden.jpg', 'category' => 'Marriage & Relationships', 'title' => 'Echoes of Eden', 'blurb' => "God's design for marriage and sexuality, building healthy homes rooted in love and purpose.", 'link_url' => 'https://selar.com/361lf3'],
            ['image' => 'addiction-compass.jpg', 'category' => 'Addiction Recovery', 'title' => 'The Addiction Compass', 'blurb' => 'Navigating understanding, healing, and hope through the complex nature of addiction.', 'link_url' => 'https://selar.com/r6566n'],
            ['image' => 'unshackled.jpg', 'category' => 'Devotional', 'title' => 'Unshackled', 'blurb' => 'A devotional for addiction recovery, daily faith anchors for breaking free.', 'link_url' => 'https://selar.com/31b1y7'],
            ['image' => 'unmasking-you.jpg', 'category' => 'Psychology', 'title' => 'Unmasking You', 'blurb' => 'A guide to personality disorders: understanding human behaviour and emotional patterns.', 'link_url' => 'https://selar.com/77t4y9ao17'],
            ['image' => 'anchored.jpg', 'category' => 'Identity & Faith', 'title' => 'Anchored', 'blurb' => 'Finding your worth and identity in Christ, for solid ground when you feel not enough.', 'link_url' => 'https://selar.com/7pypylgx79'],
            ['image' => 'sanctuary.jpg', 'category' => 'Trauma Healing', 'title' => 'Sanctuary', 'blurb' => 'Finding psychological and spiritual wholeness after sexual assault.', 'link_url' => 'https://selar.com/5580711x85'],
            ['image' => 'fourfold-path.jpg', 'category' => 'Addiction Recovery', 'title' => 'The Fourfold Path to Freedom', 'blurb' => 'A biopsychosociospiritual approach to quitting addictions.', 'link_url' => 'https://selar.com/99m2616291'],
            ['image' => 'feelings-and-faith.jpg', 'category' => 'Parenting', 'title' => 'Feelings and Faith', 'blurb' => 'Helping parents guide children to manage feelings with the compass of faith.', 'link_url' => 'https://selar.com/2z3108'],
        ];

        foreach ($books as $index => $book) {
            Book::updateOrCreate(
                ['title' => $book['title']],
                [
                    'category' => $book['category'],
                    'blurb' => $book['blurb'],
                    'cover_image_path' => asset('images/books/'.$book['image']),
                    'link_url' => $book['link_url'],
                    'is_visible' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
