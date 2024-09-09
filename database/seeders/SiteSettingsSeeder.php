<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_settings')->insert([
            'email' => 'info@example.com',
            'phone' => '+012 345 6789',
            'address' => '123 Street, New York, USA',
            'facebook' => 'https://facebook.com/yourpage',
            'twitter' => 'https://twitter.com/yourprofile',
            'linkedin' => 'https://linkedin.com/in/yourprofile',
            'youtube' => 'https://youtube.com/yourchannel',
            'instagram' => 'https://instagram.com/yourprofile',
            'copyright' => '© 2024 Your Company. All rights reserved.',
            'copyright_links' =>'#',
            'ui_logo' =>'#',
            'ui_site_name' =>'#',
            'admin_logo' =>'#',
            'admin_site_name' =>'#',
            'footer_ui_name' =>'#',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
