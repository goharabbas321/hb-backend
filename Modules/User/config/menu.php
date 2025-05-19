<?php

return [
    [
        "menuHeader" => "user::messages.sidebar.user_management_section",
        "menuHeaderPermission" => "read_users"
    ],
    [
        "name" => "user::messages.sidebar.user_management",
        "icon" => "menu-icon tf-icons ti ti-users",
        "submenu" => [
            [
                "url" => "/users",
                "name" => "user::messages.sidebar.users",
                "slug" => [
                    "users.index",
                    "users.edit"
                ],
                "permission" => "read_users"
            ],
            [
                "url" => "/roles",
                "name" => "user::messages.sidebar.roles",
                "slug" => [
                    "roles.index",
                    "roles.edit"
                ],
                "permission" => "read_roles"
            ],
            [
                "url" => "/permissions",
                "name" => "user::messages.sidebar.permissions",
                "slug" => [
                    "permissions.index",
                    "permissions.edit"
                ],
                "permission" => "read_permissions"
            ]
        ],
        "slug" => [
            "users.index",
            "users.edit",
            "roles.index",
            "roles.edit",
            "permissions.index",
            "permissions.edit"
        ],
        "permission" => "read_users"
    ],
];
