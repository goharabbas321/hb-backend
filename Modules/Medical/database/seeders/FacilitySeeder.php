<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Medical\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name_en' => 'Emergency', 'name_ar' => 'الطوارئ'],
            ['name_en' => 'ICU', 'name_ar' => 'العناية المركزة'],
            ['name_en' => 'Radiology', 'name_ar' => 'الأشعة'],
            ['name_en' => 'Laboratory', 'name_ar' => 'المختبر'],
            ['name_en' => 'Pharmacy', 'name_ar' => 'الصيدلية'],
            ['name_en' => 'Cafeteria', 'name_ar' => 'الكافتيريا'],
            ['name_en' => 'Surgery', 'name_ar' => 'الجراحة'],
            ['name_en' => 'Rehabilitation', 'name_ar' => 'إعادة التأهيل'],
            ['name_en' => 'Dialysis Center', 'name_ar' => 'مركز غسيل الكلى'],
            ['name_en' => 'Chemotherapy', 'name_ar' => 'العلاج الكيميائي'],
            ['name_en' => 'Advanced Imaging', 'name_ar' => 'التصوير المتقدم'],
            ['name_en' => 'Telemedicine', 'name_ar' => 'الطب عن بعد'],
            ['name_en' => 'Maternity', 'name_ar' => 'الولادة'],
            ['name_en' => 'Teaching', 'name_ar' => 'التعليم'],
            ['name_en' => 'Research Center', 'name_ar' => 'مركز البحوث'],
            ['name_en' => 'Blood Bank', 'name_ar' => 'بنك الدم'],
            ['name_en' => 'Advanced Diagnostics', 'name_ar' => 'التشخيص المتقدم'],
            ['name_en' => 'Rehabilitation Center', 'name_ar' => 'مركز إعادة التأهيل'],
            ['name_en' => 'Digital Records', 'name_ar' => 'السجلات الرقمية'],
            ['name_en' => 'Patient Portal', 'name_ar' => 'بوابة المرضى'],
            ['name_en' => 'VIP Rooms', 'name_ar' => 'غرف كبار الشخصيات'],
            ['name_en' => 'International Wing', 'name_ar' => 'الجناح الدولي'],
            ['name_en' => 'Cosmetic Center', 'name_ar' => 'مركز التجميل'],
            ['name_en' => 'Dental Clinic', 'name_ar' => 'عيادة الأسنان'],
            ['name_en' => 'IVF Center', 'name_ar' => 'مركز أطفال الأنابيب'],
            ['name_en' => 'Medical Spa', 'name_ar' => 'السبا الطبي'],
            ['name_en' => 'NICU', 'name_ar' => 'وحدة العناية المركزة لحديثي الولادة'],
            ['name_en' => 'Play Therapy', 'name_ar' => 'العلاج باللعب'],
            ['name_en' => 'Child-Friendly Rooms', 'name_ar' => 'غرف صديقة للأطفال'],
            ['name_en' => 'Family Accommodation', 'name_ar' => 'إقامة العائلة'],
            ['name_en' => 'Pediatric Emergency', 'name_ar' => 'طوارئ الأطفال'],
            ['name_en' => 'Outpatient Clinics', 'name_ar' => 'العيادات الخارجية'],
            ['name_en' => 'Diagnostic Center', 'name_ar' => 'مركز التشخيص'],
            ['name_en' => 'Endoscopy Suite', 'name_ar' => 'وحدة التنظير الداخلي'],
            ['name_en' => 'Respiratory Unit', 'name_ar' => 'وحدة الجهاز التنفسي'],
            ['name_en' => 'Cath Lab', 'name_ar' => 'مختبر القسطرة'],
            ['name_en' => 'Cardiac ICU', 'name_ar' => 'وحدة العناية المركزة للقلب'],
            ['name_en' => 'Cardiac Surgery Theaters', 'name_ar' => 'غرف عمليات جراحة القلب'],
            ['name_en' => 'Echo Lab', 'name_ar' => 'مختبر تخطيط صدى القلب'],
            ['name_en' => 'Stress Test Unit', 'name_ar' => 'وحدة اختبار الإجهاد'],
            ['name_en' => 'Cardiac Rehab Center', 'name_ar' => 'مركز إعادة تأهيل القلب'],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['name_en' => $facility['name_en']],
                ['name_ar' => $facility['name_ar']]
            );
        }
    }
}
