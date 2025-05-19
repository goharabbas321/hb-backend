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
            'title' => 'هل أنت متأكد؟',
            'text' => 'هل تريد المتابعة بهذا الإجراء؟',
            'btn_confirm' => 'تأكيد',
            'btn_cancel' => 'إلغاء',
        ],
    ],
    'sidebar' => [
        'user_management_section' => 'إدارة المستخدمين والأدوار والصلاحيات',
        'user_management' => 'إدارة المستخدمين',
        'users' => 'المستخدمون',
        'roles' => 'الأدوار',
        'permissions' => 'الصلاحيات',
    ],
    'users' => [
        'heading' => [
            'index' => 'المستخدمين',
            'create' => 'إنشاء مستخدم',
            'edit' => 'تعديل مستخدم',
        ],
        'statics' => [
            'users' => 'المستخدمين',
            'verified_users' => 'المستخدمين المتحققين',
            'blocked_users' => 'المستخدمين المحظورين',
            'pending_verification' => 'التحقق معلق',
        ],
        'nav' => [
            'all_users' => 'كل المستخدمين',
            'active_users' => 'المستخدمين النشطين',
            'blocked_users' => 'المستخدمين المحظورين',
            'deleted_users' => 'المستخدمين المحذوفين',
        ],
        'nav2' => [
            'all' => 'كل',
        ],
        'button' => [
            'create_user' => 'إنشاء مستخدم',
        ],
        'info' => [
            'upload_image' => 'مسموح بصيغ JPG أو PNG. الحد الأقصى للحجم 2048K',
        ],
        'section' => [
            'account_details' => '1. تفاصيل الحساب',
            'personal_info' => '2. المعلومات الشخصية',
        ],
        'table' => [
            'name' => 'الاسم',
            'username' => 'اسم المستخدم',
            'email' => 'البريد الإلكتروني',
            'role' => 'الدور',
            'status' => 'الحالة',
        ],
        'field' => [
            'username' => 'اسم المستخدم',
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'confirm_password' => 'تأكيد كلمة المرور',
            'full_name' => 'الاسم الكامل',
            'phone_number' => 'رقم الهاتف',
            'country' => 'الدولة',
            'address' => 'العنوان',
            'language' => 'اللغة',
            'currency' => 'العملة',
            'time_zone' => 'المنطقة الزمنية',
            'role' => 'الدور',
        ],
        'validation' => [
            'username_empty' => 'الرجاء إدخال اسم المستخدم',
            'username_length' => 'يجب أن يكون اسم المستخدم أكثر من 4 وأقل من 12 حرفًا',
            'username_regex' => 'يمكن أن يتكون اسم المستخدم فقط من الأحرف الأبجدية والأرقام',
            'email_empty' => 'الرجاء إدخال بريدك الإلكتروني',
            'email_valid' => 'الرجاء إدخال عنوان بريد إلكتروني صالح',
            'password_empty' => 'الرجاء إدخال كلمة المرور',
            'password_length' => 'يجب أن تكون كلمة المرور أكثر من 8 أحرف',
            'password_confirmation_empty' => 'الرجاء تأكيد كلمة المرور',
            'password_confirmation_same' => 'كلمة المرور وتأكيدها غير متطابقين',
            'name_empty' => 'الرجاء إدخال الاسم الكامل',
            'name_length' => 'يجب أن يكون الاسم أكثر من 6 وأقل من 30 حرفًا',
            'name_regex' => 'يمكن أن يتكون الاسم فقط من الأحرف الأبجدية والأرقام والمسافات',
            'phone_empty' => 'الرجاء إدخال رقم الهاتف',
            'phone_length' => 'يجب أن يكون رقم الهاتف 11 رقمًا',
            'country_empty' => 'الرجاء اختيار الدولة',
            'country_select' => 'اختر الدولة',
            'address_empty' => 'لا يمكن أن يكون العنوان فارغًا',
            'language_empty' => 'الرجاء اختيار اللغة',
            'language_select' => 'اختر اللغة',
            'currency_empty' => 'الرجاء اختيار العملة',
            'currency_select' => 'اختر العملة',
            'time_zone_empty' => 'الرجاء اختيار المنطقة الزمنية',
            'time_zone_select' => 'اختر المنطقة الزمنية',
            'role_empty' => 'الرجاء اختيار الدور',
            'role_select' => 'اختر الدور',
        ],
    ],
    'roles' => [
        'heading' => [
            'index' => 'الأدوار',
            'create' => 'إنشاء دور',
            'edit' => 'تعديل دور',
        ],
        'button' => [
            'create_role' => 'إنشاء دور',
        ],
        'info' => [
            'role_permissions' => 'صلاحيات الدور',
            'admin_access' => 'صلاحيات المدير',
            'admin_access_info' => 'يسمح بالوصول الكامل للنظام',
            'select_all' => 'اختيار الكل',
        ],
        'table' => [
            'name' => 'الاسم',
            'guard_name' => 'اسم الحارس',
        ],
        'field' => [
            'label_role_name' => 'اسم الدور',
            'placeholder_role_name' => 'أدخل اسم الدور',
        ],
        'validation' => [
            'role_name_empty' => 'الرجاء إدخال اسم الدور',
        ],
    ],
    'permissions' => [
        'heading' => [
            'index' => 'الصلاحيات',
            'create' => 'إنشاء صلاحية',
            'edit' => 'تعديل صلاحية',
        ],
        'button' => [
            'create_permission' => 'إنشاء صلاحية',
        ],
        'info' => [
            'role_permissions' => 'صلاحيات الدور',
        ],
        'table' => [
            'name' => 'الاسم',
            'guard_name' => 'اسم الحارس',
        ],
        'field' => [
            'label_permission_name' => 'اسم الصلاحية',
            'placeholder_permission_name' => 'أدخل اسم الصلاحية',
            'assign_role' => 'تعيين الأدوار',
            'type' => 'نوع',
        ],
        'validation' => [
            'permission_name_empty' => 'الرجاء إدخال اسم الصلاحية',
            'roles_select' => 'اختر الدور',
            'type_select' => 'اختر النوع',
        ],
    ],
];
