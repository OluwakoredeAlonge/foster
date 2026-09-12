<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $fillable = [
        'hero_badge_text',
        'hero_headline',
        'hero_headline_highlight',
        'hero_subheadline',
        'hero_primary_cta_text',
        'hero_secondary_cta_text',
        'hero_image_path',
        'stats',
        'about_eyebrow',
        'about_heading',
        'about_paragraph',
        'about_image_path',
        'about_quote',
        'about_quote_citation',
        'about_pillars',
        'services_banner_heading',
        'services_banner_text',
        'services_banner_cta_text',
        'organization_eyebrow',
        'organization_heading',
        'organization_paragraph',
        'organization_image_path',
        'organization_programs',
    ];

    protected $casts = [
        'stats' => 'array',
        'about_pillars' => 'array',
        'organization_programs' => 'array',
    ];

    /** Sensible copy so the homepage never renders blank before an admin fills this in. */
    public static function defaults(): array
    {
        return [
            'hero_badge_text' => 'Medicine · Psychology · Faith',
            'hero_headline' => 'Healing Minds. Restoring Homes.',
            'hero_headline_highlight' => 'Renewing Hope.',
            'hero_subheadline' => 'Fosterheirs Mental Health Consultancy is a team of licensed, faith-integrated therapists walking with individuals and families through trauma, addiction, and marital healing, because lasting recovery honours the whole person: mind, body, and soul.',
            'hero_primary_cta_text' => 'Book a Session',
            'hero_secondary_cta_text' => 'Meet Our Therapists',
            'stats' => [
                ['value' => 10, 'suffix' => '+', 'label' => 'Published Books'],
                ['value' => 180, 'suffix' => '+', 'label' => 'Lives Transformed'],
                ['value' => 20, 'suffix' => '+', 'label' => 'Marriages Restored'],
                ['value' => 18, 'suffix' => '+', 'label' => 'Addicts Rehabilitated'],
            ],
            'about_eyebrow' => 'Who We Are',
            'about_heading' => 'A Team Devoted to Whole-Person Healing',
            'about_paragraph' => 'Founded in 2023 and based within the Heirs Specialist Hospital Complex in Oye-Ekiti, Nigeria, Fosterheirs brings together medical practitioners, licensed therapists, and faith-integrated counsellors under one roof. We believe lasting healing must address the mind, the body, and the soul together, so every session blends clinical expertise with compassionate, faith-anchored care.',
            'about_quote' => 'God designed the mind just as He designed the soul.',
            'about_quote_citation' => 'Dr. Anthonia Yemisi Soje, Founder',
            'about_pillars' => [
                ['icon' => 'stethoscope', 'label' => 'Medical Intervention'],
                ['icon' => 'brain', 'label' => 'Psychological Therapy'],
                ['icon' => 'users', 'label' => 'Social Rehabilitation'],
                ['icon' => 'sparkles', 'label' => 'Spiritual Anchoring'],
            ],
            'services_banner_heading' => 'Invite Our Therapists to Speak',
            'services_banner_text' => 'Available for corporate wellness sessions, churches, conferences, retreats, and school programmes.',
            'services_banner_cta_text' => 'Book a Speaker',
            'organization_eyebrow' => 'Our Impact',
            'organization_heading' => 'Restoration, Since 2023',
            'organization_paragraph' => 'Fosterheirs operates from within the Heirs Specialist Hospital Complex in Oye-Ekiti, Nigeria, a sanctuary for holistic healing addressing addiction, trauma, marital crises, and emotional instability.',
            'organization_programs' => [
                ['icon' => 'glass-water', 'title' => 'Drug & Alcohol Rehab', 'description' => 'Comprehensive recovery programmes'],
                ['icon' => 'heart-handshake', 'title' => 'Marriage Restoration', 'description' => 'Rebuilding broken bonds'],
                ['icon' => 'brain', 'title' => 'Trauma Recovery', 'description' => 'Psycho-trauma therapy'],
                ['icon' => 'shield-check', 'title' => 'Relapse Prevention', 'description' => 'Ongoing support systems'],
            ],
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
