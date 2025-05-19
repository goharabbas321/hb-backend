<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    /*#[OA\Get(
        path: "/api/v1/admin/user-listing",
        summary: "List all non-admin users",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ["Users"],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "users retrieved success"),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized"),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: "not found"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]*/
    public function index()
    {
        return response()->json(['users' => []]);
    }

    /*#[OA\Post(
        path: "/api/v1/admin/create",
        summary: "Create an Admin Account",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["first_name", "last_name", "email", "password", "password_confirmation"],
                    properties: [
                        new OA\Property(property: 'first_name', description: "User first name", type: "string"),
                        new OA\Property(property: 'last_name', description: "User last name", type: "string"),
                        new OA\Property(property: 'email', description: "User email", type: "string"),
                        new OA\Property(property: 'password', description: "User password", type: "string"),
                        new OA\Property(property: 'password_confirmation', description: "User password confirmation", type: "string"),
                    ]
                )
            )
        ),
        tags: ["Users"],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: "Register Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]*/

    public function create()
    {
        return response()->json(['users' => []]);
    }
}
