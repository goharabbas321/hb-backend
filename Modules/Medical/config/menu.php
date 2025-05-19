<?php

return [
    [
        "menuHeader" => "medical::messages.sidebar.medical_section",
        "menuHeaderPermission" => "read_hospitals",
    ],
    [
        "name" => "medical::messages.sidebar.medical_system",
        "icon" => "menu-icon tf-icons ti ti-stethoscope",
        "submenu" => [
            [
                "url" => "/hospitals",
                "name" => "medical::messages.medical_system.nav.hospitals",
                "slug" => [
                    "hospitals.index",
                    "hospitals.edit",
                    "hospitals.show"
                ],
                "permission" => "read_hospitals"
            ],
            [
                "url" => "/appointments",
                "name" => "medical::messages.medical_system.nav.appointments",
                "slug" => [
                    "appointments.index",
                    "appointments.edit",
                    "appointments.show"
                ],
                "permission" => "read_appointments"
            ],
            [
                "url" => "/doctors",
                "name" => "medical::messages.medical_system.nav.doctors",
                "slug" => [
                    "doctors.index",
                    "doctors.show",
                    "doctors.edit"
                ],
                "permission" => "read_doctors"
            ],
            [
                "url" => "/specializations",
                "name" => "medical::messages.medical_system.nav.specializations",
                "slug" => [
                    "specializations.index",
                    "specializations.edit"
                ],
                "permission" => "read_specializations"
            ],
            [
                "url" => "/facilities",
                "name" => "medical::messages.medical_system.nav.facilities",
                "slug" => [
                    "facilities.index",
                    "facilities.edit"
                ],
                "permission" => "read_facilities"
            ],
            [
                "url" => "/cities",
                "name" => "medical::messages.medical_system.nav.cities",
                "slug" => [
                    "cities.index",
                    "cities.edit"
                ],
                "permission" => "read_cities"
            ]
        ],
        "slug" => [
            "hospitals.index",
            "hospitals.edit",
            "hospitals.show",
            "appointments.index",
            "appointments.edit",
            "appointments.show",
            "doctors.index",
            "doctors.edit",
            "doctors.show",
            "specializations.index",
            "specializations.edit",
            "facilities.index",
            "facilities.edit",
            "cities.index",
            "cities.edit"
        ],
        "permission" => "read_hospitals",
    ],
];
