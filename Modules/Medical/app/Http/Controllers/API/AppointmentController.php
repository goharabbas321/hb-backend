<?php

namespace Modules\Medical\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Medical\Models\Appointment;
use Modules\Medical\Http\Resources\AppointmentResource;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Appointments', description: 'API endpoints for managing appointments')]
class AppointmentController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    #[OA\Get(
        path: '/api/v1/appointments',
        summary: 'Get all appointments with filtering and pagination',
        description: 'Returns a list of appointments with their details',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', required: false, schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Items per page', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
            new OA\Parameter(name: 'hospital_id', in: 'query', description: 'Filter by hospital ID', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'specialization_id', in: 'query', description: 'Filter by specialization ID', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'user_id', in: 'query', description: 'Filter by patient ID', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by appointment status', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'date_from', in: 'query', description: 'Filter by date range (start)', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'date_to', in: 'query', description: 'Filter by date range (end)', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'sort_by', in: 'query', description: 'Field to sort by', required: false, schema: new OA\Schema(type: 'string', default: 'appointment_date')),
            new OA\Parameter(name: 'sort_dir', in: 'query', description: 'Sort direction', required: false, schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'asc'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Appointments retrieved successfully'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function index(Request $request)
    {
        // Start query with relationships
        $query = Appointment::with(['hospital', 'specialization', 'patient']);

        // Filter by hospital
        if ($request->has('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        // Filter by specialization
        if ($request->has('specialization_id')) {
            $query->where('specialization_id', $request->specialization_id);
        }

        // Filter by patient
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'appointment_date');
        $sortDirection = $request->get('sort_dir', 'asc');

        // Validate sort_by parameter
        $allowedSortFields = ['id', 'appointment_date', 'appointment_number', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'appointment_date';
        }

        // Validate sort_dir parameter
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $query->orderBy($sortBy, $sortDirection);

        // Handle pagination
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $appointments = $query->paginate($perPage, ['*'], 'page', $page);

        return $this->responseService->successResponse(
            'Appointments retrieved successfully',
            [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
                'appointments' => AppointmentResource::collection($appointments->items())
            ]
        );
    }

    #[OA\Post(
        path: '/api/v1/appointments',
        summary: 'Create a new appointment',
        description: 'Creates a new appointment record',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['hospital_id', 'specialization_id', 'user_id', 'appointment_date', 'appointment_number'],
                properties: [
                    new OA\Property(property: 'hospital_id', type: 'integer', example: 1),
                    new OA\Property(property: 'specialization_id', type: 'integer', example: 1),
                    new OA\Property(property: 'user_id', type: 'integer', example: 2),
                    new OA\Property(property: 'appointment_date', type: 'string', format: 'date', example: '2025-06-01'),
                    new OA\Property(property: 'appointment_number', type: 'integer', example: 1),
                    new OA\Property(property: 'status', type: 'string', enum: ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'], example: 'scheduled'),
                    new OA\Property(property: 'notes', type: 'string', nullable: true),
                    new OA\Property(property: 'reason', type: 'string', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'Appointment created successfully'),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Validation error'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function store(Request $request)
    {
        // Validate request
        $validator = validator($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_number' => 'required|integer',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:1000',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->errorResponse('Validation error', $validator->errors(), 400);
        }

        // Check for overlapping appointments for the same hospital, specialization, and appointment number
        $overlapping = Appointment::where('hospital_id', $request->hospital_id)
            ->where('specialization_id', $request->specialization_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_number', $request->appointment_number)
            ->exists();

        if ($overlapping) {
            return $this->responseService->errorResponse('An appointment with this number already exists for this date, hospital, and specialization', null, 400);
        }

        // Create appointment
        $appointment = Appointment::create($request->all());

        return $this->responseService->successResponse('Appointment created successfully', new AppointmentResource($appointment), 201);
    }

    #[OA\Get(
        path: '/api/v1/appointments/{id}',
        summary: 'Get appointment details',
        description: 'Returns details for a specific appointment',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'Appointment ID', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Appointment retrieved successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Appointment not found'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function show($id)
    {
        $appointment = Appointment::with(['hospital', 'specialization', 'patient'])->find($id);

        if (!$appointment) {
            return $this->responseService->errorResponse('Appointment not found', null, 404);
        }

        return $this->responseService->successResponse('Appointment retrieved successfully', new AppointmentResource($appointment));
    }

    #[OA\Put(
        path: '/api/v1/appointments/{id}',
        summary: 'Update appointment',
        description: 'Updates an existing appointment',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'Appointment ID', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'hospital_id', type: 'integer', example: 1),
                    new OA\Property(property: 'specialization_id', type: 'integer', example: 1),
                    new OA\Property(property: 'user_id', type: 'integer', example: 2),
                    new OA\Property(property: 'appointment_date', type: 'string', format: 'date', example: '2025-06-01'),
                    new OA\Property(property: 'appointment_number', type: 'integer', example: 1),
                    new OA\Property(property: 'status', type: 'string', enum: ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'], example: 'scheduled'),
                    new OA\Property(property: 'notes', type: 'string', nullable: true),
                    new OA\Property(property: 'reason', type: 'string', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Appointment updated successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Appointment not found'),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Validation error'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->responseService->errorResponse('Appointment not found', null, 404);
        }

        // Validate request
        $validator = validator($request->all(), [
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_number' => 'required|integer',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:1000',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->errorResponse('Validation error', $validator->errors(), 400);
        }

        // Check for overlapping appointments (excluding current appointment)
        $overlapping = Appointment::where('hospital_id', $request->hospital_id)
            ->where('specialization_id', $request->specialization_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_number', $request->appointment_number)
            ->where('id', '!=', $id)
            ->exists();

        if ($overlapping) {
            return $this->responseService->errorResponse('An appointment with this number already exists for this date, hospital, and specialization', null, 400);
        }

        // Update appointment
        $appointment->update($request->all());

        return $this->responseService->successResponse('Appointment updated successfully', new AppointmentResource($appointment));
    }

    #[OA\Delete(
        path: '/api/v1/appointments/{id}',
        summary: 'Delete appointment',
        description: 'Deletes an existing appointment',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'Appointment ID', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Appointment deleted successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Appointment not found'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->responseService->errorResponse('Appointment not found', null, 404);
        }

        $appointment->delete();

        return $this->responseService->successResponse('Appointment deleted successfully');
    }
}
