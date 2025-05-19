<?php

namespace Modules\Medical\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Medical\Models\City;
use Modules\Medical\Models\Doctor;
use Modules\Medical\Models\Facility;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HospitalApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $hospitals;
    protected $cities;
    protected $specializations;
    protected $facilities;

    /**
     * Setup test environment
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();

        // Set up test data
        $this->setupTestData();
    }

    /**
     * Create test data for hospitals, cities, specializations, facilities, and doctors
     */
    private function setupTestData()
    {
        // Create cities
        $this->cities = [
            City::create(['name_en' => 'Baghdad', 'name_ar' => 'بغداد']),
            City::create(['name_en' => 'Karbala', 'name_ar' => 'كربلاء']),
            City::create(['name_en' => 'Najaf', 'name_ar' => 'النجف']),
        ];

        // Create specializations
        $this->specializations = [
            Specialization::create(['name_en' => 'Cardiology', 'name_ar' => 'أمراض القلب']),
            Specialization::create(['name_en' => 'Neurology', 'name_ar' => 'طب الأعصاب']),
            Specialization::create(['name_en' => 'Pediatrics', 'name_ar' => 'طب الأطفال']),
            Specialization::create(['name_en' => 'Orthopedics', 'name_ar' => 'جراحة العظام']),
        ];

        // Create facilities
        $this->facilities = [
            Facility::create(['name_en' => 'Emergency', 'name_ar' => 'الطوارئ']),
            Facility::create(['name_en' => 'ICU', 'name_ar' => 'العناية المركزة']),
            Facility::create(['name_en' => 'Surgery', 'name_ar' => 'الجراحة']),
            Facility::create(['name_en' => 'Laboratory', 'name_ar' => 'المختبر']),
            Facility::create(['name_en' => 'Pharmacy', 'name_ar' => 'الصيدلية']),
        ];

        // Create hospitals
        $this->hospitals = [];

        // Hospital 1
        $hospital1 = Hospital::create([
            'city_id' => $this->cities[0]->id,  // Baghdad
            'name_en' => 'Baghdad Medical Center',
            'name_ar' => 'مركز بغداد الطبي',
            'address_en' => 'Jadriyah District, Baghdad',
            'address_ar' => 'حي الجادرية، بغداد',
            'contact_en' => '+964 790 123 4567',
            'contact_ar' => '٤٥٦٧ ١٢٣ ٧٩٠ ٩٦٤+',
            'email' => 'info@baghdad-medical.iq',
            'website' => 'www.baghdad-medical.iq',
            'working_hours_en' => '24/7',
            'working_hours_ar' => '٢٤/٧',
            'image' => '/hospital1.png',
            'description_en' => 'Leading hospital in Baghdad with modern facilities',
            'description_ar' => 'مستشفى رائد في بغداد مع مرافق حديثة'
        ]);

        // Hospital 2
        $hospital2 = Hospital::create([
            'city_id' => $this->cities[1]->id,  // Karbala
            'name_en' => 'Al-Kafeel Specialized Hospital',
            'name_ar' => 'مستشفى الكفيل التخصصي',
            'address_en' => '60th Street, Karbala',
            'address_ar' => 'شارع الستين، كربلاء',
            'contact_en' => '+964 771 234 5678',
            'contact_ar' => '٥٦٧٨ ٢٣٤ ٧٧١ ٩٦٤+',
            'email' => 'info@alkafeel-hospital.iq',
            'website' => 'www.alkafeel-hospital.iq',
            'working_hours_en' => '24/7',
            'working_hours_ar' => '٢٤/٧',
            'image' => '/hospital2.png',
            'description_en' => 'Specialized hospital with advanced medical equipment',
            'description_ar' => 'مستشفى متخصص بمعدات طبية متطورة'
        ]);

        // Hospital 3
        $hospital3 = Hospital::create([
            'city_id' => $this->cities[2]->id,  // Najaf
            'name_en' => 'Al-Sadr Medical City',
            'name_ar' => 'مدينة الصدر الطبية',
            'address_en' => 'Al-Sadr Quarter, Najaf',
            'address_ar' => 'حي الصدر، النجف',
            'contact_en' => '+964 780 123 4567',
            'contact_ar' => '٤٥٦٧ ١٢٣ ٧٨٠ ٩٦٤+',
            'email' => 'contact@sadr-medical.iq',
            'website' => 'www.sadr-medical.iq',
            'working_hours_en' => '24/7',
            'working_hours_ar' => '٢٤/٧',
            'image' => '/hospital3.png',
            'description_en' => 'Comprehensive medical city providing specialized care',
            'description_ar' => 'مدينة طبية شاملة توفر رعاية متخصصة'
        ]);

        // Save hospitals to the array
        $this->hospitals = [$hospital1, $hospital2, $hospital3];

        // Associate specializations with hospitals
        $hospital1->specializations()->attach([$this->specializations[0]->id, $this->specializations[1]->id]);
        $hospital2->specializations()->attach([$this->specializations[0]->id, $this->specializations[3]->id]);
        $hospital3->specializations()->attach([$this->specializations[1]->id, $this->specializations[2]->id]);

        // Associate facilities with hospitals
        $hospital1->facilities()->attach([$this->facilities[0]->id, $this->facilities[1]->id, $this->facilities[3]->id]);
        $hospital2->facilities()->attach([$this->facilities[0]->id, $this->facilities[2]->id, $this->facilities[4]->id]);
        $hospital3->facilities()->attach([$this->facilities[1]->id, $this->facilities[2]->id, $this->facilities[3]->id]);

        // Create doctors for each hospital
        Doctor::create([
            'hospital_id' => $hospital1->id,
            'specialization_id' => $this->specializations[0]->id,
            'name_en' => 'Dr. Ali Mahmoud',
            'name_ar' => 'د. علي محمود',
            'bio_en' => 'Cardiology specialist with 10 years experience',
            'bio_ar' => 'أخصائي أمراض القلب مع 10 سنوات من الخبرة',
            'profile_picture' => '/doctor1.png'
        ]);

        Doctor::create([
            'hospital_id' => $hospital1->id,
            'specialization_id' => $this->specializations[1]->id,
            'name_en' => 'Dr. Sarah Hussein',
            'name_ar' => 'د. سارة حسين',
            'bio_en' => 'Neurology specialist',
            'bio_ar' => 'أخصائية أمراض الأعصاب',
            'profile_picture' => '/doctor2.png'
        ]);

        Doctor::create([
            'hospital_id' => $hospital2->id,
            'specialization_id' => $this->specializations[0]->id,
            'name_en' => 'Dr. Ahmed Ali',
            'name_ar' => 'د. أحمد علي',
            'bio_en' => 'Experienced cardiologist',
            'bio_ar' => 'أخصائي قلب ذو خبرة',
            'profile_picture' => '/doctor3.png'
        ]);
    }

    /**
     * Test authenticated access to the hospitals list endpoint
     */
    public function test_authenticated_hospital_index_endpoint()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/hospitals');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'message',
                'data' => [
                    'hospitals',
                    'pagination' => [
                        'total',
                        'per_page',
                        'current_page',
                        'last_page',
                        'from',
                        'to'
                    ]
                ],
                'code'
            ])
            ->assertJsonCount(3, 'data.hospitals');
    }

    /**
     * Test public access to the hospitals list endpoint
     */
    public function test_public_hospital_index_endpoint()
    {
        $response = $this->getJson('/api/v1/public/hospitals');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'message',
                'data' => [
                    'hospitals',
                    'pagination' => [
                        'total',
                        'per_page',
                        'current_page',
                        'last_page',
                        'from',
                        'to'
                    ]
                ],
                'code'
            ])
            ->assertJsonCount(3, 'data.hospitals');
    }

    /**
     * Test authenticated access to a specific hospital endpoint
     */
    public function test_authenticated_hospital_show_endpoint()
    {
        $hospital = $this->hospitals[0];

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/hospitals/' . $hospital->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'message',
                'data' => [
                    'id',
                    'name_en',
                    'name_ar',
                    'city_en',
                    'city_ar',
                    'address_en',
                    'address_ar',
                    'contact_en',
                    'contact_ar',
                    'email',
                    'website',
                    'specialization_en',
                    'specialization_ar',
                    'facilities_en',
                    'facilities_ar',
                    'working_hours_en',
                    'working_hours_ar',
                    'image',
                    'description_en',
                    'description_ar',
                    'doctors'
                ],
                'code'
            ])
            ->assertJson([
                'error' => false,
                'data' => [
                    'id' => (string) $hospital->id,
                    'name_en' => $hospital->name_en,
                    'name_ar' => $hospital->name_ar
                ]
            ]);
    }

    /**
     * Test public access to a specific hospital endpoint
     */
    public function test_public_hospital_show_endpoint()
    {
        $hospital = $this->hospitals[0];

        $response = $this->getJson('/api/v1/public/hospitals/' . $hospital->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'error',
                'message',
                'data' => [
                    'id',
                    'name_en',
                    'name_ar',
                    'city_en',
                    'city_ar',
                    'address_en',
                    'address_ar',
                    'contact_en',
                    'contact_ar',
                    'email',
                    'website',
                    'specialization_en',
                    'specialization_ar',
                    'facilities_en',
                    'facilities_ar',
                    'working_hours_en',
                    'working_hours_ar',
                    'image',
                    'description_en',
                    'description_ar',
                    'doctors'
                ],
                'code'
            ]);
    }

    /**
     * Test filtering hospitals by city
     */
    public function test_filter_hospitals_by_city()
    {
        $response = $this->getJson('/api/v1/public/hospitals?city=Baghdad');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.hospitals');
    }

    /**
     * Test filtering hospitals by specialization
     */
    public function test_filter_hospitals_by_specialization()
    {
        $response = $this->getJson('/api/v1/public/hospitals?specialization=Cardiology');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data.hospitals');
    }

    /**
     * Test filtering hospitals by facility
     */
    public function test_filter_hospitals_by_facility()
    {
        $response = $this->getJson('/api/v1/public/hospitals?facility=ICU');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data.hospitals');
    }

    /**
     * Test global search functionality
     */
    public function test_hospital_search()
    {
        $response = $this->getJson('/api/v1/public/hospitals?search=Karbala');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.hospitals');
    }

    /**
     * Test sorting functionality
     */
    public function test_hospital_sorting()
    {
        $response = $this->getJson('/api/v1/public/hospitals?sort_by=name_en&sort_dir=desc');

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        $hospitalNames = array_map(function ($hospital) {
            return $hospital['name_en'];
        }, $data['data']['hospitals']);

        // Check that hospitals are sorted in descending order by name_en
        $sortedNames = $hospitalNames;
        rsort($sortedNames);

        $this->assertEquals($sortedNames, $hospitalNames);
    }

    /**
     * Test pagination functionality
     */
    public function test_hospital_pagination()
    {
        $response = $this->getJson('/api/v1/public/hospitals?per_page=1&page=2');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.hospitals')
            ->assertJson([
                'data' => [
                    'pagination' => [
                        'current_page' => 2,
                        'per_page' => 1,
                        'total' => 3
                    ]
                ]
            ]);
    }

    /**
     * Test non-existent hospital returns 404
     */
    public function test_non_existent_hospital()
    {
        $response = $this->getJson('/api/v1/public/hospitals/999');

        $response->assertStatus(404);
    }
}
