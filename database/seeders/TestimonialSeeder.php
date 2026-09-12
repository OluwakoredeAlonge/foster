<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Famurewa Oluwafisayo',
                'client_role' => 'Fosterheirs Client',
                'quote' => 'One of the best experiences ever. I really had a very good and refreshing moment during my consultation and I am happy with myself again after overcoming all my difficult situations.',
            ],
            [
                'client_name' => 'Anonymous',
                'client_role' => 'Addiction Recovery Client',
                'quote' => "After years battling addiction alone, the team at Fosterheirs gave me something no other programme had: a real reason to believe recovery was possible. Today I'm three years clean.",
            ],
            [
                'client_name' => 'Mrs. T. Okonkwo',
                'client_role' => 'Marriage Counselling Client',
                'quote' => 'My husband and I were on the verge of divorce. Two months of marriage counselling completely transformed our communication and helped us rediscover our love for each other.',
            ],
            [
                'client_name' => 'B. Adeyemi',
                'client_role' => 'Trauma Therapy Client',
                'quote' => 'The trauma therapy sessions were life-altering. Our therapist has a rare ability to make you feel truly seen and heard. I healed more than I thought possible.',
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonial['client_name'], 'quote' => $testimonial['quote']],
                $testimonial + ['rating' => 5, 'is_visible' => true, 'sort_order' => $index]
            );
        }
    }
}
