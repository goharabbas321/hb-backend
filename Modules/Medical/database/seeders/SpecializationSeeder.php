<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Medical\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name_en' => 'General', 'name_ar' => 'عام'],
            ['name_en' => 'Cardiology', 'name_ar' => 'أمراض القلب'],
            ['name_en' => 'Neurology', 'name_ar' => 'طب الأعصاب'],
            ['name_en' => 'Orthopedics', 'name_ar' => 'جراحة العظام'],
            ['name_en' => 'Pediatrics', 'name_ar' => 'طب الأطفال'],
            ['name_en' => 'Oncology', 'name_ar' => 'علاج الأورام'],
            ['name_en' => 'Dermatology', 'name_ar' => 'الأمراض الجلدية'],
            ['name_en' => 'Urology', 'name_ar' => 'المسالك البولية'],
            ['name_en' => 'General Surgery', 'name_ar' => 'الجراحة العامة'],
            ['name_en' => 'Internal Medicine', 'name_ar' => 'الطب الباطني'],
            ['name_en' => 'Obstetrics', 'name_ar' => 'التوليد'],
            ['name_en' => 'Gynecology', 'name_ar' => 'أمراض النساء'],
            ['name_en' => 'Trauma', 'name_ar' => 'الإصابات'],
            ['name_en' => 'Neurosurgery', 'name_ar' => 'جراحة الأعصاب'],
            ['name_en' => 'Ophthalmology', 'name_ar' => 'طب العيون'],
            ['name_en' => 'Rehabilitation', 'name_ar' => 'إعادة التأهيل'],
            ['name_en' => 'Endocrinology', 'name_ar' => 'الغدد الصماء'],
            ['name_en' => 'Nephrology', 'name_ar' => 'أمراض الكلى'],
            ['name_en' => 'Gastroenterology', 'name_ar' => 'أمراض الجهاز الهضمي'],
            ['name_en' => 'Pulmonology', 'name_ar' => 'أمراض الرئة'],
            ['name_en' => 'Plastic Surgery', 'name_ar' => 'الجراحة التجميلية'],
            ['name_en' => 'Dental', 'name_ar' => 'طب الأسنان'],
            ['name_en' => 'Fertility', 'name_ar' => 'الخصوبة'],
            ['name_en' => 'Neonatology', 'name_ar' => 'طب حديثي الولادة'],
            ['name_en' => 'Pediatric Surgery', 'name_ar' => 'جراحة الأطفال'],
            ['name_en' => 'Child Psychiatry', 'name_ar' => 'الطب النفسي للأطفال'],
            ['name_en' => 'Pediatric Oncology', 'name_ar' => 'أورام الأطفال'],
            ['name_en' => 'Rheumatology', 'name_ar' => 'أمراض الروماتيزم'],
            ['name_en' => 'Cardiac Surgery', 'name_ar' => 'جراحة القلب'],
            ['name_en' => 'Vascular Surgery', 'name_ar' => 'جراحة الأوعية الدموية'],
            ['name_en' => 'Interventional Cardiology', 'name_ar' => 'طب القلب التداخلي'],
            ['name_en' => 'Cardiac Rehabilitation', 'name_ar' => 'إعادة تأهيل القلب'],
            ['name_en' => 'General Medicine', 'name_ar' => 'الطب العام'],
            ['name_en' => 'Reproductive Medicine', 'name_ar' => 'طب الإنجاب'],
            ['name_en' => 'Obstetrics & Gynecology', 'name_ar' => 'التوليد وأمراض النساء'],
        ];

        foreach ($specializations as $specialization) {
            Specialization::updateOrCreate(
                ['name_en' => $specialization['name_en']],
                ['name_ar' => $specialization['name_ar']]
            );
        }
    }
}
