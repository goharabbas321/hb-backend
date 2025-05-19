<?php

namespace Modules\Medical\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;
use Modules\Medical\Models\Appointment;

class AppointmentAvailabilityController extends Controller
{
    /**
     * Check appointment availability and return booking number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'booking_number' => null,
                'date' => $request->date
            ], 422);
        }

        // Use our helper function to check availability and get booking number
        $result = getAppointmentBookingNumber($request->hospital_id, $request->date, $request->specialization_id);

        return response()->json($result);
    }

    /**
     * Get count of appointments for a specific hospital and date.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCount(Request $request): JsonResponse
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'count' => 0,
            ], 422);
        }

        // Count appointments for this hospital and date
        $count = Appointment::where('hospital_id', $request->hospital_id)
            ->whereDate('appointment_date', $request->date)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get available dates for a specific hospital and specialization.
     *
     * @param int $hospital Hospital ID
     * @param int $specialization Specialization ID
     * @return JsonResponse
     */
    public function getAvailableDates($hospital, $specialization): JsonResponse
    {
        // Validate hospital and specialization exist
        $hospitalModel = Hospital::find($hospital);
        $specializationModel = Specialization::find($specialization);

        if (!$hospitalModel || !$specializationModel) {
            return response()->json(['error' => 'Hospital or specialization not found'], 404);
        }

        // Check if this specialization is offered at this hospital
        $hasSpecialization = $hospitalModel->specializations()
            ->where('specialization_id', $specialization)
            ->exists();

        if (!$hasSpecialization) {
            return response()->json(['error' => 'This specialization is not available at this hospital'], 400);
        }

        // Get the next 14 days
        $today = Carbon::today();
        $availableDates = [];

        for ($i = 0; $i < 14; $i++) {
            $date = $today->copy()->addDays($i);

            // Skip weekends (Friday and Saturday in most Middle Eastern countries)
            if ($date->dayOfWeek === Carbon::FRIDAY || $date->dayOfWeek === Carbon::SATURDAY) {
                continue;
            }

            // Calculate max appointments per day for this hospital/specialization
            // This could be based on hospital configuration, number of doctors, etc.
            $maxAppointments = 20; // Example value

            // Count existing appointments
            $existingAppointments = Appointment::where('hospital_id', $hospital)
                ->where('specialization_id', $specialization)
                ->whereDate('appointment_date', $date)
                ->count();

            $availableSlots = $maxAppointments - $existingAppointments;

            if ($availableSlots > 0) {
                $availableDates[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('l'),
                    'available_slots' => $availableSlots
                ];
            }
        }

        return response()->json($availableDates);
    }
}
