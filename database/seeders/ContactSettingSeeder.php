<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::current()->update([
            'address' => 'Heirs Specialist Hospital, Beside Aluko House, Irare Estate, Oye-Ekiti, Ekiti State',
            'phone_display' => '0704 248 1085 · 0806 643 5831',
            'phone_href' => '+2347042481085',
            'email' => 'heirsfosterproject@gmail.com',
            'hours_weekday' => 'Mon – Fri: 8:00 AM – 6:00 PM',
            'hours_saturday' => 'Saturday: 9:00 AM – 2:00 PM',
            'instagram_url' => 'https://www.instagram.com/dranthoniasoje',
            'facebook_url' => 'https://www.facebook.com/share/19B3DspqsS/',
            'youtube_url' => 'https://www.youtube.com/@fosterproject2425',
        ]);
    }
}
