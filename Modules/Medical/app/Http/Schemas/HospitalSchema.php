<?php

namespace Modules\Medical\Http\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Hospital',
    title: 'Hospital',
    description: 'Hospital model',
    properties: [
        new OA\Property(property: 'id', type: 'string', example: '1'),
        new OA\Property(property: 'name_en', type: 'string', example: 'Al-Kafeel Specialized Hospital'),
        new OA\Property(property: 'name_ar', type: 'string', example: 'مستشفى الكفيل التخصصي'),
        new OA\Property(property: 'city_en', type: 'string', example: 'Karbala'),
        new OA\Property(property: 'city_ar', type: 'string', example: 'كربلاء'),
        new OA\Property(property: 'address_en', type: 'string', example: '60th Street, Holy Karbala, Iraq'),
        new OA\Property(property: 'address_ar', type: 'string', example: 'شارع الستين، كربلاء المقدسة، العراق'),
        new OA\Property(property: 'contact_en', type: 'string', example: '+964 771 234 5678'),
        new OA\Property(property: 'contact_ar', type: 'string', example: '٥٦٧٨ ٢٣٤ ٧٧١ ٩٦٤+'),
        new OA\Property(property: 'email', type: 'string', example: 'info@alkafeel-hospital.iq'),
        new OA\Property(property: 'website', type: 'string', example: 'www.alkafeel-hospital.iq'),
        new OA\Property(
            property: 'specialization_en',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['General', 'Cardiology', 'Neurology', 'Orthopedics']
        ),
        new OA\Property(
            property: 'specialization_ar',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['عام', 'أمراض القلب', 'طب الأعصاب', 'جراحة العظام']
        ),
        new OA\Property(
            property: 'facilities_en',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['Emergency', 'ICU', 'Radiology', 'Laboratory', 'Pharmacy', 'Cafeteria']
        ),
        new OA\Property(
            property: 'facilities_ar',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['الطوارئ', 'العناية المركزة', 'الأشعة', 'المختبر', 'الصيدلية', 'الكافتيريا']
        ),
        new OA\Property(property: 'working_hours_en', type: 'string', example: '24/7'),
        new OA\Property(property: 'working_hours_ar', type: 'string', example: '٢٤/٧'),
        new OA\Property(property: 'image', type: 'string', example: '/modern-hospital.png'),
        new OA\Property(property: 'description_en', type: 'string', example: 'Leading hospital in Karbala with state-of-the-art facilities and experienced medical staff.'),
        new OA\Property(property: 'description_ar', type: 'string', example: 'مستشفى رائدة في كربلاء مع مرافق حديثة وطاقم طبي ذو خبرة.'),
        new OA\Property(
            property: 'doctors',
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'string', example: '1'),
                    new OA\Property(property: 'name_en', type: 'string', example: 'Dr. Ahmed Ali'),
                    new OA\Property(property: 'name_ar', type: 'string', example: 'د. أحمد علي'),
                    new OA\Property(property: 'specialization_en', type: 'string', example: 'Cardiology'),
                    new OA\Property(property: 'specialization_ar', type: 'string', example: 'أمراض القلب'),
                    new OA\Property(property: 'profile_picture', type: 'string', example: '/male-doctor.png'),
                    new OA\Property(property: 'bio_en', type: 'string', example: 'Experienced cardiologist with 10+ years of practice.'),
                    new OA\Property(property: 'bio_ar', type: 'string', example: 'أخصائي قلب ذو خبرة تزيد عن 10 سنوات.')
                ],
                type: 'object'
            )
        )
    ]
)]
class HospitalSchema
{
    // This class is used only for OpenAPI annotations
}
