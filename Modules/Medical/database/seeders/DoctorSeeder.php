<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Medical\Models\Doctor;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorsData = [
            // Al-Safeer Hospital doctors
            [
                'hospital_name' => 'Al-Safeer Hospital',
                'name_en' => 'Dr. Ahmed Ali',
                'name_ar' => 'د. أحمد علي',
                'specialization_en' => 'Cardiology',
                'specialization_ar' => 'أمراض القلب',
                'profile_picture' => 'doctors/doctor_1747131591.png',
                'bio_en' => 'Experienced cardiologist with 10+ years of practice.',
                'bio_ar' => 'أخصائي قلب ذو خبرة تزيد عن 10 سنوات.',
            ],
            [
                'hospital_name' => 'Al-Safeer Hospital',
                'name_en' => 'Dr. Sarah Johnson',
                'name_ar' => 'د. سارة جونسون',
                'specialization_en' => 'General Medicine',
                'specialization_ar' => 'الطب العام',
                'profile_picture' => 'doctors/doctor_1747131612.png',
                'bio_en' => 'Specialized in general medicine with focus on preventive care.',
                'bio_ar' => 'متخصصة في الطب العام مع التركيز على الرعاية الوقائية.',
            ],

            // Imam Zain Al-Abidin Hospital doctors
            [
                'hospital_name' => 'Imam Zain Al-Abidin Hospital',
                'name_en' => 'Dr. Mohammed Hassan',
                'name_ar' => 'د. محمد حسن',
                'specialization_en' => 'Neurology',
                'specialization_ar' => 'طب الأعصاب',
                'profile_picture' => 'doctors/doctor_1747131626.png',
                'bio_en' => 'Specialized in neurological disorders with 15 years of experience.',
                'bio_ar' => 'متخصص في اضطرابات الجهاز العصبي مع 15 عامًا من الخبرة.',
            ],
            [
                'hospital_name' => 'Imam Zain Al-Abidin Hospital',
                'name_en' => 'Dr. Fatima Ali',
                'name_ar' => 'د. فاطمة علي',
                'specialization_en' => 'Pediatrics',
                'specialization_ar' => 'طب الأطفال',
                'profile_picture' => 'doctors/doctor_1747131645.png',
                'bio_en' => 'Dedicated pediatrician with special interest in childhood development.',
                'bio_ar' => 'طبيبة أطفال متخصصة مع اهتمام خاص بتطور الطفولة.',
            ],
        ];

        foreach ($doctorsData as $doctorData) {
            // Find the hospital
            $hospital = Hospital::where('name_en', operator: $doctorData['hospital_name'])->first();

            if ($hospital) {
                // Find the specialization
                $specialization = Specialization::where('name_en', $doctorData['specialization_en'])->first();

                if ($specialization) {
                    // Create the doctor
                    Doctor::updateOrCreate(
                        ['name_en' => $doctorData['name_en'], 'hospital_id' => $hospital->id],
                        [
                            'name_ar' => $doctorData['name_ar'],
                            'specialization_id' => $specialization->id,
                            'bio_en' => $doctorData['bio_en'],
                            'bio_ar' => $doctorData['bio_ar'],
                            'profile_picture' => $doctorData['profile_picture'],
                        ]
                    );
                }
            }
        }
    }
}
