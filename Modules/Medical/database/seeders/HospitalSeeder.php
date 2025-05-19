<?php

namespace Modules\Medical\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Medical\Models\City;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;
use Modules\Medical\Models\Facility;
use Modules\Medical\Enums\Day;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospitalsData = [
            [
                'user_id' => '2',
                'name_en' => 'Al-Safeer Hospital',
                'name_ar' => 'مستشفى السفير',
                'city_en' => 'Karbala',
                'city_ar' => 'كربلاء',
                'address_en' => '60th Street, Holy Karbala, Iraq',
                'address_ar' => 'شارع الستين، كربلاء المقدسة، العراق',
                'contact_en' => '+964 771 234 5678',
                'contact_ar' => '٥٦٧٨ ٢٣٤ ٧٧١ ٩٦٤+',
                'email' => 'info@safeer-hospital.iq',
                'website' => 'https://www.safeer-hospital.iq',
                'specialization_en' => ['General', 'Cardiology', 'Neurology', 'Orthopedics'],
                'specialization_ar' => ['عام', 'أمراض القلب', 'طب الأعصاب', 'جراحة العظام'],
                'facilities_en' => ['Emergency', 'ICU', 'Radiology', 'Laboratory', 'Pharmacy', 'Cafeteria'],
                'facilities_ar' => ['الطوارئ', 'العناية المركزة', 'الأشعة', 'المختبر', 'الصيدلية', 'الكافتيريا'],
                'working_hours_en' => '24/7',
                'working_hours_ar' => '٢٤/٧',
                'image' => 'hospitals/hospital_1747130183.png',
                'description_en' => 'Leading hospital in Karbala with state-of-the-art facilities and experienced medical staff specializing in cardiac care, neurology, and orthopedics. Offering comprehensive healthcare services with international standards.',
                'description_ar' => 'مستشفى رائدة في كربلاء مع مرافق حديثة وطاقم طبي ذو خبرة متخصص في رعاية القلب وطب الأعصاب وجراحة العظام. تقدم خدمات رعاية صحية شاملة بمعايير دولية.',
            ],
            [
                'user_id' => '3',
                'name_en' => 'Imam Zain Al-Abidin Hospital',
                'name_ar' => 'مستشفى الإمام زين العابدين',
                'city_en' => 'Karbala',
                'city_ar' => 'النجف',
                'address_en' => 'Ahmed Al-Wa’ily Street, Karbala, Iraq',
                'address_ar' => 'شارع أحمد الوائلي، كربلاء، العراق',
                'contact_en' => '+964 780 123 4567',
                'contact_ar' => '٤٥٦٧ ١٢٣ ٧٨٠ ٩٦٤+',
                'email' => 'contact@zain-medical.iq',
                'website' => 'https://www.zain-medical.iq',
                'specialization_en' => ['Neurology', 'Orthopedics', 'Pediatrics', 'Oncology', 'Cardiology'],
                'specialization_ar' => ['طب الأعصاب', 'جراحة العظام', 'طب الأطفال', 'علاج الأورام', 'أمراض القلب'],
                'facilities_en' => ['Emergency', 'Surgery', 'Pharmacy', 'Laboratory', 'Rehabilitation', 'Dialysis Center'],
                'facilities_ar' => ['الطوارئ', 'الجراحة', 'الصيدلية', 'المختبر', 'إعادة التأهيل', 'مركز غسيل الكلى'],
                'working_hours_en' => '24/7',
                'working_hours_ar' => '٢٤/٧',
                'image' => 'hospitals/hospital_1747130156.png',
                'description_en' => 'Comprehensive medical city offering a wide range of specialized medical services. State-of-the-art facilities for cancer treatment, pediatric care, and neurological disorders with advanced diagnostic capabilities.',
                'description_ar' => 'مدينة طبية شاملة تقدم مجموعة واسعة من الخدمات الطبية المتخصصة. مرافق حديثة لعلاج السرطان ورعاية الأطفال واضطرابات الجهاز العصبي مع قدرات تشخيصية متقدمة.',
            ],
        ];

        foreach ($hospitalsData as $hospitalData) {
            // Find the city
            $city = City::where('name_en', $hospitalData['city_en'])->first();

            // Create the hospital
            $hospital = Hospital::updateOrCreate(
                ['name_en' => $hospitalData['name_en']],
                [
                    'name_ar' => $hospitalData['name_ar'],
                    'city_id' => $city->id,
                    'user_id' => $hospitalData['user_id'],
                    'address_en' => $hospitalData['address_en'],
                    'address_ar' => $hospitalData['address_ar'],
                    'contact_en' => $hospitalData['contact_en'],
                    'contact_ar' => $hospitalData['contact_ar'],
                    'email' => $hospitalData['email'],
                    'website' => $hospitalData['website'],
                    'working_hours_en' => $hospitalData['working_hours_en'],
                    'working_hours_ar' => $hospitalData['working_hours_ar'],
                    'description_en' => $hospitalData['description_en'],
                    'description_ar' => $hospitalData['description_ar'],
                    'image' => $hospitalData['image'],
                ]
            );

            // Attach specializations with working days to the hospital
            $specializationData = [];
            foreach ($hospitalData['specialization_en'] as $specializationName) {
                $specialization = Specialization::where('name_en', $specializationName)->first();
                if ($specialization) {
                    $specializationData[$specialization->id] = [
                        'booking_limit' => 40,
                        'working_days' => json_encode(Day::all()) // Include all days
                    ];
                }
            }
            $hospital->specializations()->sync($specializationData);

            // Attach facilities to the hospital
            $facilityIds = [];
            foreach ($hospitalData['facilities_en'] as $facilityName) {
                $facility = Facility::where('name_en', $facilityName)->first();
                if ($facility) {
                    $facilityIds[] = $facility->id;
                }
            }
            $hospital->facilities()->sync($facilityIds);
        }
    }
}
