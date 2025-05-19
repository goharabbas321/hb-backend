<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;

class MedicalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run seeders in order of dependencies
        $this->call([
            CitySeeder::class,            // 1. Create cities first
            SpecializationSeeder::class,  // 2. Create specializations
            FacilitySeeder::class,        // 3. Create facilities
            HospitalSeeder::class,        // 4. Create hospitals and link to cities, specializations, facilities
            DoctorSeeder::class,          // 5. Create doctors and link to hospitals and specializations
            AppointmentSeeder::class,     // 6. Create appointments linked to doctors and patients
        ]);
    }
}
