<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "Hospital Booking API", title: "Hospital Booking Documentation"),
    OA\Server(url: 'https://hospital-booking.local', description: "local server"),
    OA\Server(url: 'https://hospital.goharabbas.com/', description: "production server"),
    OA\SecurityScheme(securityScheme: 'bearerAuth', type: "http", name: "Authorization", in: "header", scheme: "bearer"),
]
abstract class Controller
{
    //
}
