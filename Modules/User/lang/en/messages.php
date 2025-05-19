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
    ],
    'sidebar' => [
        'user_management_section' => 'Users Roles & Permissions',
        'user_management' => 'User Management',
        'users' => 'Users',
        'roles' => 'Roles',
        'permissions' => 'Permissions',
    ],
    'users' => [
        'heading' => [
            'index' => 'Users',
            'create' => 'Create User',
            'edit' => 'Edit User',
        ],
        'statics' => [
            'users' => 'Users',
            'verified_users' => 'Verified Users',
            'blocked_users' => 'Blocked Users',
            'pending_verification' => 'Verification Pending',
        ],
        'nav' => [
            'all_users' => 'All Users',
            'active_users' => 'Active Users',
            'blocked_users' => 'Blocked Users',
            'deleted_users' => 'Deleted Users',
        ],
        'nav2' => [
            'all' => 'All',
        ],
        'button' => [
            'create_user' => 'Create User',
        ],
        'info' => [
            'upload_image' => 'Allowed JPG or PNG. Max size of 2048K',
        ],
        'section' => [
            'account_details' => '1. Account Details',
            'personal_info' => '2. Personal Information',
        ],
        'table' => [
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
        ],
        'field' => [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'full_name' => 'Full Name',
            'phone_number' => 'Phone Number',
            'country' => 'Country',
            'address' => 'Address',
            'language' => 'Language',
            'currency' => 'Currency',
            'time_zone' => 'Time Zone',
            'role' => 'Role',
        ],
        'validation' => [
            'username_empty' => 'Please enter username',
            'username_length' => 'The username must be more than 4 and less than 12 characters long',
            'username_regex' => 'The username can only consist of alphabetical and number',
            'email_empty' => 'Please enter your email',
            'email_valid' => 'Please enter valid email address',
            'password_empty' => 'Please enter your password',
            'password_length' => 'Password must be more than 8 characters',
            'password_confirmation_empty' => 'Please confirm password',
            'password_confirmation_same' => 'The password and its confirm are not the same',
            'name_empty' => 'Please enter full name',
            'name_length' => 'The name must be more than 6 and less than 30 characters long',
            'name_regex' => 'The name can only consist of alphabetical, number and space',
            'phone_empty' => 'Please enter phone number',
            'phone_length' => 'The phone must be 11 characters long',
            'country_empty' => 'Please select your country',
            'country_select' => 'Select Country',
            'address_empty' => 'Address cannot be empty',
            'language_empty' => 'Please select your language',
            'language_select' => 'Select Language',
            'currency_empty' => 'Please select your currency',
            'currency_select' => 'Select Currency',
            'time_zone_empty' => 'Please select your time zone',
            'time_zone_select' => 'Select Time Zone',
            'role_empty' => 'Please select role',
            'role_select' => 'Select Role',
        ],
    ],
    'roles' => [
        'heading' => [
            'index' => 'Roles',
            'create' => 'Create Role',
            'edit' => 'Edit Role',
        ],
        'button' => [
            'create_role' => 'Create Role',
        ],
        'info' => [
            'role_permissions' => 'Role Permissions',
            'admin_access' => 'Administrator Access',
            'admin_access_info' => 'Allows a full access to the system',
            'select_all' => 'Select All',
        ],
        'table' => [
            'name' => 'Name',
            'guard_name' => 'Guard Name',
        ],
        'field' => [
            'label_role_name' => 'Role Name',
            'placeholder_role_name' => 'Enter a role name',
        ],
        'validation' => [
            'role_name_empty' => 'Please enter role name',
        ],
    ],
    'permissions' => [
        'heading' => [
            'index' => 'Permissions',
            'create' => 'Create Permission',
            'edit' => 'Edit Permission',
        ],
        'button' => [
            'create_permission' => 'Create Permission',
        ],
        'info' => [
            'role_permissions' => 'Permissions Role',
        ],
        'table' => [
            'name' => 'Name',
            'guard_name' => 'Guard Name',
        ],
        'field' => [
            'label_permission_name' => 'Permission Name',
            'placeholder_permission_name' => 'Enter a permission name',
            'assign_role' => 'Assign Roles',
            'type' => 'Type',
        ],
        'validation' => [
            'permission_name_empty' => 'Please enter permission name',
            'roles_select' => 'Select Role',
            'type_select' => 'Select Type',
        ],
    ],
];
