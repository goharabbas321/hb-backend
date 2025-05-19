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
        'confirm_refresh' => [
            'title' => 'جاري جلب البيانات...',
            'text' => 'يرجى الانتظار، نحن نعالج طلبك.',
            'btn_confirm' => 'حسنًا',
            'btn_cancel' => 'إلغاء',
            'success' => 'تم جلب البيانات بنجاح!',
            'error' => 'حدث خطأ!',
        ],
    ],
    'sidebar' => [
        'settings_section' => 'إدارة النظام',
        'settings' => 'الإعدادات',
    ],
    'settings' => [
        'nav' => [
            'heading' => 'الإعدادات',
            'general_settings' => 'الإعدادات العامة',
            'finance_settings' => 'الإعدادات المالية',
            'language_management' => 'إدارة اللغة',
            'email_configuration' => 'إعدادات البريد الإلكتروني',
            'payment_gateway' => 'بوابة الدفع',
            'apis' => 'واجهات برمجة التطبيقات الخارجية',
            'notifications' => 'الإشعارات',
            'activity_logs' => 'سجلات النشاط',
            'modules_management' => 'إدارة الوحدات',
            'backups' => 'النسخ الاحتياطي',
            'analytics' => 'التحليلات',
        ],
        'general_settings' => [
            'heading' => 'الإعدادات العامة',
            'name' => 'الاسم',
            'name_ar' => 'الاسم بالعربية',
            'title' => 'العنوان',
            'title_ar' => 'العنوان بالعربية',
            'description' => 'الوصف',
            'description_ar' => 'الوصف بالعربية',
            'keywords' => 'الكلمات المفتاحية',
            'keywords_ar' => 'الكلمات المفتاحية بالعربية',
            'address' => 'العنوان',
            'address_ar' => 'العنوان بالعربية',
            'country' => 'الدولة',
            'country_select' => 'اختر الدولة',
            'timezone' => 'المنطقة الزمنية',
            'timezone_select' => 'اختر المنطقة الزمنية',
            'date_format' => 'صيغة التاريخ',
            'date_format_select' => 'اختر صيغة التاريخ',
            'time_format' => 'صيغة الوقت',
            'time_format_select' => 'اختر صيغة الوقت',
            'email' => 'البريد الإلكتروني',
            'phone_number' => 'رقم الهاتف',
            'language' => 'اللغة',
            'currency' => 'العملة',
            'favicon' => 'أيقونة الموقع',
            'logo_light' => 'شعار فاتح',
            'logo_dark' => 'شعار داكن',
            'front_page' => 'الصفحة الرئيسية',
            'registration_page' => 'صفحة التسجيل',
            'disable' => 'معطل',
            'enable' => 'مفعل',
            'btn_submit' => 'حفظ التغييرات',
            'btn_cancel' => 'إلغاء',
        ],
        'logs' => [
            'heading' => 'سجلات النشاط',
            'table' => [
                'log_name' => 'اسم السجل',
                'description' => 'الوصف',
                'subject_type' => 'نوع الموضوع',
                'event' => 'الحدث',
                'subject_id' => 'معرف الموضوع',
                'causer_name' => 'اسم المتسبب',
                'causer_id' => 'معرف المتسبب',
                'properties' => 'الخصائص',
            ],
        ],
        'modules' => [
            'heading' => 'إدارة الوحدات',
            'table' => [
                'name' => 'الاسم',
                'status' => 'الحالة',
                'priority' => 'الأولوية',
                'description' => 'الوصف',
            ],
            'enable' => 'تفعيل',
            'disable' => 'تعطيل',
            'not_found' => 'الوحدة غير موجودة.',
            'toggle_error' => 'خطأ في تبديل حالة الوحدة: :error',
        ],
    ],

];
