<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            'keysentence' => 'We are providing best tour services',
            'description' => 'Welcome to Eastern Tours',
            'mainimage' => 'image.png',
            'otherimage1' => 'otherimage1.png',
            'otherimage2' => 'otherimage2.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
