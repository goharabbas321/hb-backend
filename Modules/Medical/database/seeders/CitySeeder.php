<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Medical\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_en' => 'Karbala', 'name_ar' => 'كربلاء'],
            ['name_en' => 'Najaf', 'name_ar' => 'النجف'],
            ['name_en' => 'Baghdad', 'name_ar' => 'بغداد'],
            ['name_en' => 'Mosul', 'name_ar' => 'الموصل'],
            ['name_en' => 'Basra', 'name_ar' => 'البصرة'],
            ['name_en' => 'Erbil', 'name_ar' => 'أربيل'],
            ['name_en' => 'Sulaymaniyah', 'name_ar' => 'السليمانية'],
            ['name_en' => 'Diwaniyah', 'name_ar' => 'الديوانية'],
            ['name_en' => 'Kirkuk', 'name_ar' => 'كركوك'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['name_en' => $city['name_en']],
                ['name_ar' => $city['name_ar']]
            );
        }
    }
}
