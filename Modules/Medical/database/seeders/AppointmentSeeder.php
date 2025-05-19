<?php

namespace Modules\Medical\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Medical\Models\Appointment;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all hospitals
        $hospitals = Hospital::all();

        // Get all specializations
        $specializations = Specialization::all();

        // Get some users to use as patients
        $patients = User::role('patient')->get();

        // Sample appointment data
        $appointmentsData = [
            [
                'appointment_date' => now()->addDays(1)->toDateString(),
                'appointment_number' => 1,
                'status' => 'scheduled',
                'reason' => 'Regular check-up',
                'notes' => 'Patient has requested a general health assessment',
            ],
            [
                'appointment_date' => now()->addDays(2)->toDateString(),
                'appointment_number' => 1,
                'status' => 'scheduled',
                'reason' => 'Follow-up visit',
                'notes' => 'Follow-up on medication effectiveness',
            ],
        ];

        // Create appointments linking specializations and patients
        foreach ($appointmentsData as $appointmentData) {
            // Randomly select a hospital, specialization and patient
            $hospital = $hospitals->random();
            $specialization = $specializations->random();
            $patient = $patients->random();

            // Create the appointment
            Appointment::create([
                'hospital_id' => $hospital->id,
                'specialization_id' => $specialization->id,
                'user_id' => $patient->id,
                'appointment_date' => $appointmentData['appointment_date'],
                'appointment_number' => $appointmentData['appointment_number'],
                'status' => $appointmentData['status'],
                'reason' => $appointmentData['reason'],
                'notes' => $appointmentData['notes'],
            ]);
        }
    }
}
