<?php

namespace Modules\Medical\Http\Controllers\API;

use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Http\Resources\HospitalResource;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Hospitals', description: 'API endpoints for managing hospitals')]
class HospitalController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /*#[OA\Get(
        path: '/api/v1/hospitals',
        summary: 'Get all hospitals with filtering and pagination',
        description: 'Returns a list of hospitals with their details',
        security: [['bearerAuth' => []]],
        tags: ['Hospitals'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', required: false, schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Number of items per page', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
            new OA\Parameter(name: 'search', in: 'query', description: 'Search term to search across all text fields', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'city', in: 'query', description: 'Filter by city name', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'specialization', in: 'query', description: 'Filter by specialization', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'facility', in: 'query', description: 'Filter by facility', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'name', in: 'query', description: 'Filter by hospital name', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'sort_by', in: 'query', description: 'Field to sort by (name_en, name_ar, city_en, city_ar)', required: false, schema: new OA\Schema(type: 'string', default: 'name_en')),
            new OA\Parameter(name: 'sort_dir', in: 'query', description: 'Sort direction (asc, desc)', required: false, schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'asc'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Hospitals retrieved successfully'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]*/

    #[OA\Get(
        path: '/api/v1/hospitals',
        summary: 'Get all hospitals (public endpoint)',
        description: 'Returns a list of hospitals with their details (no authentication required)',
        tags: ['Hospitals'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', required: false, schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Number of items per page', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
            new OA\Parameter(name: 'search', in: 'query', description: 'Search term to search across all text fields', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'city', in: 'query', description: 'Filter by city name', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'specialization', in: 'query', description: 'Filter by specialization', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'facility', in: 'query', description: 'Filter by facility', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'name', in: 'query', description: 'Filter by hospital name', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'sort_by', in: 'query', description: 'Field to sort by (name_en, name_ar, city_en, city_ar)', required: false, schema: new OA\Schema(type: 'string', default: 'name_en')),
            new OA\Parameter(name: 'sort_dir', in: 'query', description: 'Sort direction (asc, desc)', required: false, schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'asc'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Hospitals retrieved successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function index(Request $request)
    {
        // Start query with relationships
        $query = Hospital::with(['city', 'doctors.specialization', 'specializations', 'facilities']);

        // Global search across multiple fields
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_en', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('address_en', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('address_ar', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description_en', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description_ar', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('city', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name_en', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('name_ar', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        // Apply filters if provided
        if ($request->has('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name_en', 'LIKE', '%' . $request->city . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $request->city . '%');
            });
        }

        if ($request->has('specialization')) {
            $query->whereHas('specializations', function ($q) use ($request) {
                $q->where('name_en', 'LIKE', '%' . $request->specialization . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $request->specialization . '%');
            });
        }

        // New filter for facilities
        if ($request->has('facility')) {
            $query->whereHas('facilities', function ($q) use ($request) {
                $q->where('name_en', 'LIKE', '%' . $request->facility . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $request->facility . '%');
            });
        }

        if ($request->has('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_en', 'LIKE', '%' . $request->name . '%')
                    ->orWhere('name_ar', 'LIKE', '%' . $request->name . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name_en');
        $sortDirection = $request->get('sort_dir', 'asc');

        // Validate sort_by parameter
        $allowedSortFields = ['name_en', 'name_ar', 'id'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'name_en';
        }

        // Validate sort_dir parameter
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        // Special case for sorting by city
        if (in_array($sortBy, ['city_en', 'city_ar'])) {
            $cityField = $sortBy === 'city_en' ? 'name_en' : 'name_ar';
            $query->join('cities', 'hospitals.city_id', '=', 'cities.id')
                ->orderBy('cities.' . $cityField, $sortDirection)
                ->select('hospitals.*'); // Ensure we only get hospital columns
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Handle pagination
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $total = $query->count();
        $hospitals = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Use resource collection for formatting
        $hospitals = HospitalResource::collection($hospitals);

        return $this->responseService->successResponse('Hospitals retrieved successfully', [
            'hospitals' => $hospitals,
            'pagination' => [
                'total' => $total,
                'per_page' => (int) $perPage,
                'current_page' => (int) $page,
                'last_page' => ceil($total / $perPage),
                'from' => (($page - 1) * $perPage) + 1,
                'to' => min($page * $perPage, $total)
            ]
        ]);
    }

    /*#[OA\Get(
        path: '/api/v1/hospitals/{id}',
        summary: 'Get a specific hospital by ID',
        description: 'Returns a single hospital with its details',
        security: [['bearerAuth' => []]],
        tags: ['Hospitals'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'ID of hospital to return', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Hospital retrieved successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Hospital not found'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]*/

    #[OA\Get(
        path: '/api/v1/hospitals/{id}',
        summary: 'Get a specific hospital by ID (public endpoint)',
        description: 'Returns a single hospital with its details (no authentication required)',
        tags: ['Hospitals'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'ID of hospital to return', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Hospital retrieved successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Hospital not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function show($id)
    {
        $hospital = Hospital::with(['city', 'doctors.specialization', 'specializations', 'facilities'])->find($id);

        if (!$hospital) {
            return $this->responseService->errorResponse('Hospital not found', null, 404);
        }

        // Use resource for formatting
        $formattedHospital = new HospitalResource($hospital);

        return $this->responseService->successResponse('Hospital retrieved successfully', $formattedHospital);
    }

    /**
     * Get specializations for a specific hospital
     *
     * @param int $hospital Hospital ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecializations($hospital)
    {
        $hospital = Hospital::find($hospital);

        if (!$hospital) {
            return response()->json(['error' => 'Hospital not found'], 404);
        }

        $specializations = $hospital->specializations()->get(['specializations.id', 'name_en', 'name_ar']);

        return response()->json($specializations);
    }
}
