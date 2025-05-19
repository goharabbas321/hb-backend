<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the translation of the whole system. Feel free to tweak each of these messages here.
    |
    */

    'alert' => [
        'confirm_alert' => [
            'title' => 'Are you sure?',
            'text' => 'Do you want to proceed with this action?',
            'btn_confirm' => 'Confirm',
            'btn_cancel' => 'Cancel',
        ],
        'confirm_refresh' => [
            'title' => 'Fetching Data...',
            'text' => 'Please wait, we are processing your request.',
            'btn_confirm' => 'OK',
            'btn_cancel' => 'Cancel',
            'success' => 'Data Fetch Successfully!',
            'error' => 'Something went wrong!',
        ],
    ],
    'sidebar' => [
        'settings_section' => 'Manage System',
        'settings' => 'Settings',
    ],
    'settings' => [
        'nav' => [
            'heading' => 'Settings',
            'general_settings' => 'General Settings',
            'finance_settings' => 'Finance Settings',
            'language_management' => 'Language Management',
            'email_configuration' => 'Email Configuration',
            'payment_gateway' => 'Payment Gateway',
            'apis' => 'Third Party APIs',
            'notifications' => 'Notifications',
            'activity_logs' => 'Activity Logs',
            'modules_management' => 'Module Management',
            'backups' => 'Backups',
            'analytics' => 'Analytics',
        ],
        'general_settings' => [
            'heading' => 'General Settings',
            'name' => 'Name',
            'name_ar' => 'Name Arabic',
            'title' => 'Title',
            'title_ar' => 'Title Arabic',
            'description' => 'Description',
            'description_ar' => 'Description Arabic',
            'keywords' => 'Keywords',
            'keywords_ar' => 'Keywords Arabic',
            'address' => 'Address',
            'address_ar' => 'Address Arabic',
            'country' => 'Country',
            'country_select' => 'Select Country',
            'timezone' => 'Timezone',
            'timezone_select' => 'Select Timezone',
            'date_format' => 'Date Format',
            'date_format_select' => 'Select Date Format',
            'time_format' => 'Time Format',
            'time_format_select' => 'Select Time Format',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'language' => 'Language',
            'currency' => 'Currency',
            'favicon' => 'Favicon',
            'logo_light' => 'Logo Light',
            'logo_dark' => 'Logo Dark',
            'front_page' => 'Front Page',
            'registration_page' => 'Registration Page',
            'disable' => 'Disabled',
            'enable' => 'Enabled',
            'btn_submit' => 'Save Changes',
            'btn_cancel' => 'Discard',
        ],
        'logs' => [
            'heading' => 'Activity Logs',
            'table' => [
                'log_name' => 'Log Name',
                'description' => 'Description',
                'subject_type' => 'Subject Type',
                'event' => 'Event',
                'subject_id' => 'Subject ID',
                'causer_name' => 'Causer Name',
                'causer_id' => 'Causer ID',
                'properties' => 'Properties',
            ],
        ],
        'modules' => [
            'heading' => 'Module Management',
            'table' => [
                'name' => 'Name',
                'status' => 'Status',
                'priority' => 'Priority',
                'description' => 'Description',
            ],
            'enable' => 'Enable',
            'disable' => 'Disable',
            'not_found' => 'Module not found.',
            'toggle_error' => 'Error toggling module status: :error',
        ],
    ],

];
