<?php

return [
    [
        "menuHeader" => "setting::messages.sidebar.settings_section",
        "menuHeaderPermission" => "read_settings"
    ],
    [
        "url" => "/settings",
        "name" => "setting::messages.sidebar.settings",
        "icon" => "menu-icon tf-icons ti ti-settings",
        "slug" => [
            "settings.index",
            "settings.logs",
            "modules.index",
        ],
        "permission" => "read_settings"
    ],
];
