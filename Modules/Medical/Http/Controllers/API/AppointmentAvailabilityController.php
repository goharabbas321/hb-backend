<?php

namespace Modules\Medical\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Debug log to confirm what parameters are being received
        Log::info('AppointmentAvailabilityController check method called', [
            'all_params' => $request->all(),
            'method' => $request->method(),
            'hospital_id' => $request->input('hospital_id'),
            'date' => $request->input('date'),
            'specialization_id' => $request->input('specialization_id'),
            'has_specialization_id' => $request->has('specialization_id'),
            'query_string' => $request->getQueryString()
        ]);

        // Validate input
        $validator = Validator::make($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'date' => 'required|date',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'booking_number' => null,
                'date' => $request->date
            ], 422);
        }

        // Explicitly get the specialization ID with proper type handling
        $specializationId = null;

        // First, check if it exists in the request
        if ($request->has('specialization_id')) {
            $value = $request->input('specialization_id');

            // Don't convert empty strings, '0', or 0 to null
            if ($value !== '' && $value !== null) {
                $specializationId = (int)$value;
                Log::info('Specialization ID found in request', [
                    'raw_value' => $value,
                    'converted_value' => $specializationId
                ]);
            }
        }

        // Log what we're sending to the helper function
        Log::info('Calling getAppointmentBookingNumber with params', [
            'hospital_id' => $request->input('hospital_id'),
            'date' => $request->input('date'),
            'specialization_id' => $specializationId
        ]);

        // Use our helper function to check availability and get booking number
        $result = getAppointmentBookingNumber(
            $request->input('hospital_id'),
            $request->input('date'),
            $specializationId
        );

        // Log the result
        Log::info('getAppointmentBookingNumber result', $result);

        return response()->json($result);
    }

    /**
     * Get the count of appointments for a specific hospital and date.
     * Used for auto-booking hospitals to suggest a booking number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCount(Request $request): JsonResponse
    {
        // Debug log for count method
        Log::info('AppointmentAvailabilityController getCount method called', [
            'all_params' => $request->all(),
            'hospital_id' => $request->input('hospital_id'),
            'date' => $request->input('date'),
            'specialization_id' => $request->input('specialization_id'),
            'has_specialization_id' => $request->has('specialization_id')
        ]);

        // Validate input
        $validator = Validator::make($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'date' => 'required|date',
            'specialization_id' => 'nullable|exists:specializations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'count' => 0
            ], 422);
        }

        // Explicitly get the specialization ID
        $specializationId = null;
        if ($request->has('specialization_id')) {
            $value = $request->input('specialization_id');
            if ($value !== '' && $value !== null) {
                $specializationId = (int)$value;
            }
        }

        try {
            // Base query
            $query = DB::table('appointments')
                ->where('hospital_id', $request->input('hospital_id'))
                ->whereDate('appointment_date', $request->input('date'));

            // Add specialization filter if provided
            if ($specializationId !== null) {
                $query->where('specialization_id', $specializationId);
            }

            // Get the count
            $count = $query->count();

            // Log the query results
            Log::info('Appointment count query result', [
                'count' => $count,
                'specialization_id_included' => $specializationId !== null,
                'specialization_id' => $specializationId
            ]);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getCount', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error counting appointments: ' . $e->getMessage(),
                'count' => 0
            ], 500);
        }
    }
}
