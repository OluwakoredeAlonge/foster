<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPageSetting extends Model
{
    protected $fillable = [
        'eyebrow',
        'heading',
        'subheading',
        'empty_state_text',
        'author_name',
        'author_tagline',
        'author_cta_text',
    ];

    /** Sensible copy so /blog never renders blank before an admin fills this in. */
    public static function defaults(): array
    {
        return [
            'eyebrow' => 'From Our Therapists',
            'heading' => 'The Fosterheirs Blog',
            'subheading' => 'Reflections on trauma, faith, motherhood, and recovery from the Fosterheirs team.',
            'empty_state_text' => 'No articles yet. Check back soon.',
            'author_name' => 'Fosterheirs Team',
            'author_tagline' => 'Mental Health Consultancy',
            'author_cta_text' => 'Book a Session',
        ];
    }

    public static function current(): self
    {
        $setting = static::query()->first();

        if ($setting) {
            return $setting;
        }

        return static::create(static::defaults());
    }
}
