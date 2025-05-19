<?php

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Jetstream\Agent;
use Nwidart\Modules\Facades\Module;

function appClasses()
{

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
        'myLayout' => 'vertical',
        'myTheme' => 'theme-default',
        'myStyle' => 'light',
        'myRTLSupport' => true,
        'myRTLMode' => true,
        'hasCustomizer' => true,
        'showDropdownOnHover' => true,
        'displayCustomizer' => true,
        'contentLayout' => 'compact',
        'headerType' => 'fixed',
        'navbarType' => 'fixed',
        'menuFixed' => true,
        'menuCollapsed' => false,
        'footerFixed' => false,
        'customizerControls' => [
            'rtl',
            'style',
            'headerType',
            'contentLayout',
            'layoutCollapsed',
            'showDropdownOnHover',
            'layoutNavbarOptions',
            'themes',
        ],
        //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
        'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
        'menuCollapsed' => [true, false],
        'hasCustomizer' => [true, false],
        'showDropdownOnHover' => [true, false],
        'displayCustomizer' => [true, false],
        'contentLayout' => ['compact', 'wide'],
        'headerType' => ['fixed', 'static'],
        'navbarType' => ['fixed', 'static', 'hidden'],
        'myStyle' => ['light', 'dark', 'system'],
        'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
        'myRTLSupport' => [true, false],
        'myRTLMode' => [true, false],
        'menuFixed' => [true, false],
        'footerFixed' => [true, false],
        'customizerControls' => [],
        // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','ar'=>'ar'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
        if (array_key_exists($key, $DefaultData)) {
            if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                // data key should be string
                if (is_string($data[$key])) {
                    // data key should not be empty
                    if (isset($data[$key]) && $data[$key] !== null) {
                        // data key should not be exist inside allOptions array's sub array
                        if (!array_key_exists($data[$key], $value)) {
                            // ensure that passed value should be match with any of allOptions array value
                            $result = array_search($data[$key], $value, 'strict');
                            if (empty($result) && $result !== 0) {
                                $data[$key] = $DefaultData[$key];
                            }
                        }
                    } else {
                        // if data key not set or
                        $data[$key] = $DefaultData[$key];
                    }
                }
            } else {
                $data[$key] = $DefaultData[$key];
            }
        }
    }
    $styleVal = $data['myStyle'] == "dark" ? "dark" : "light";
    $styleUpdatedVal = $data['myStyle'] == "dark" ? "dark" : $data['myStyle'];
    // Determine if the layout is admin or front based on cookies
    $layoutName = $data['myLayout'];
    $isAdmin = Str::contains($layoutName, 'front') ? false : true;

    $modeCookieName = $isAdmin ? 'admin-mode' : 'front-mode';
    $colorPrefCookieName = $isAdmin ? 'admin-colorPref' : 'front-colorPref';

    // Determine style based on cookies, only if not 'blank-layout'
    if ($layoutName !== 'blank') {
        if (isset($_COOKIE[$modeCookieName])) {
            $styleVal = $_COOKIE[$modeCookieName];
            if ($styleVal === 'system') {
                $styleVal = isset($_COOKIE[$colorPrefCookieName]) ? $_COOKIE[$colorPrefCookieName] : 'light';
            }
            $styleUpdatedVal = $_COOKIE[$modeCookieName];
        }
    }

    isset($_COOKIE['theme']) ? $themeVal = $_COOKIE['theme'] : $themeVal = $data['myTheme'];

    $directionVal = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : $data['myRTLMode'];

    //layout classes
    $layoutClasses = [
        'layout' => $data['myLayout'],
        'theme' => $themeVal,
        'themeOpt' => $data['myTheme'],
        'style' => $styleVal,
        'styleOpt' => $data['myStyle'],
        'styleOptVal' => $styleUpdatedVal,
        'rtlSupport' => $data['myRTLSupport'],
        'rtlMode' => $data['myRTLMode'],
        'textDirection' => $directionVal, //$data['myRTLMode'],
        'menuCollapsed' => $data['menuCollapsed'],
        'hasCustomizer' => $data['hasCustomizer'],
        'showDropdownOnHover' => $data['showDropdownOnHover'],
        'displayCustomizer' => $data['displayCustomizer'],
        'contentLayout' => $data['contentLayout'],
        'headerType' => $data['headerType'],
        'navbarType' => $data['navbarType'],
        'menuFixed' => $data['menuFixed'],
        'footerFixed' => $data['footerFixed'],
        'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
        $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
        $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'fixed') {
        $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
        $layoutClasses['navbarType'] = '';
    } else {
        $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
        $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
        $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
        $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
        $layoutClasses['rtlMode'] = 'rtl';
        $layoutClasses['textDirection'] = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : 'rtl';
    } else {
        $layoutClasses['rtlMode'] = 'ltr';
        $layoutClasses['textDirection'] = isset($_COOKIE['direction']) && $_COOKIE['direction'] === "true" ? 'rtl' : 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
        $layoutClasses['showDropdownOnHover'] = true;
    } else {
        $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
        $layoutClasses['displayCustomizer'] = true;
    } else {
        $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
}

function updatePageConfig($pageConfigs)
{
    $demo = 'custom';
    if (isset($pageConfigs)) {
        if (count($pageConfigs) > 0) {
            foreach ($pageConfigs as $config => $val) {
                Config::set('custom.' . $demo . '.' . $config, $val);
            }
        }
    }
}

function getMergedMenu()
{
    $baseMenu = [
        "menu" => []
    ];

    // Fetch all enabled modules and sort them by priority
    $modules = Module::allEnabled();

    usort($modules, function ($a, $b) {
        return $a->getPriority() <=> $b->getPriority(); // Ascending order (0 = highest priority)
    });

    // Loop through enabled modules and merge their menu files
    foreach ($modules as $module) {
        $modulePath = module_path($module->getName()) . '/config/menu.php';
        if (file_exists($modulePath)) {
            $moduleMenu = include $modulePath;
            $baseMenu["menu"] = array_merge($baseMenu["menu"], $moduleMenu);
        }
    }

    return $baseMenu;
}


function isActiveMenu($routes, $output = 'active')
{
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (Route::currentRouteName() === $route || Request::is($route)) {
                return $output;
            }
        }
    } else {
        if (Route::currentRouteName() === $routes || Request::is($routes)) {
            return $output;
        }
    }
    return '';
}

function isMenuOpen($routes, $output = 'active open')
{
    return isActiveMenu($routes, $output);
}

function checkUserPermission($permission)
{
    if ($permission == "") {
        return 1;
    } elseif (Auth::user()->can($permission)) {
        return 1;
    } else {
        return 0;
    }
}

function getUserInformation(User $user, $key)
{
    $userInformation = json_decode($user->user_information, true);
    return @$userInformation[$key];
}

function getSetting($key)
{
    $setting = DB::table('settings')->where('key', $key)->first();

    if ($setting) {
        // If the value is JSON, decode it
        return json_decode($setting->value, true) ?? $setting->value;
    }

    return null;
}

function getJsonSetting($type, $service)
{
    $jsonSettings = getSetting($type);

    if (is_array($jsonSettings) && isset($jsonSettings[$service])) {
        return $jsonSettings[$service];
    }

    return null;
}

function getPermissionWithType($type)
{
    $permissions = DB::table('permissions')->where('type', $type)->get();
    return $permissions;
}

function getCurrentVersion()
{
    $composerFile = file_get_contents(base_path('composer.json'));
    $composerData = json_decode($composerFile, true);
    $currentVersion = $composerData['version'];

    return $currentVersion;
}

function displayAmount($amount)
{
    $amount = number_format($amount, 0);
    return $amount;
}

function displayArabicNumber($amount)
{
    return Numbers::TafqeetMoney($amount, 'IQD');
}

function getDataTableButtons($user, $permission, $route, $id, $btn_text, $icon, $attribute = "", $condition = [], $record = [])
{
    if ($user->can($permission)) {
        if (count($condition) > 0) {
            $operand1 = $record[$condition[0]];
            $operator = $condition[1];
            if (gettype($condition[2]) == "string") {
                $operand2 = $record[$condition[2]];
            } else {
                $operand2 = $condition[2];
            }

            $isConditionTrue = false;

            switch ($operator) {
                case '<':
                    $isConditionTrue = $operand1 < $operand2;
                    break;
                case '>':
                    $isConditionTrue = $operand1 > $operand2;
                    break;
                case '<=':
                    $isConditionTrue = $operand1 <= $operand2;
                    break;
                case '>=':
                    $isConditionTrue = $operand1 >= $operand2;
                    break;
                case '==':
                    $isConditionTrue = $operand1 == $operand2;
                    break;
                case '!=':
                    $isConditionTrue = $operand1 != $operand2;
                    break;
            }

            if ($isConditionTrue) {
                return '<a href="' . route($route, $id) . '"' . $attribute . 'class="dropdown-item"><i class="ti ' . $icon . ' me-2"></i><span>' . __($btn_text) . '</span></a>';
            }
        } else {
            return '<a href="' . route($route, $id) . '"' . $attribute . 'class="dropdown-item"><i class="ti ' . $icon . ' me-2"></i><span>' . __($btn_text) . '</span></a>';
        }
    }
}

function getJsonDataTable($fix_column, $column_value, $columns, $search_columns, $table_data, $limit, $start, $order, $dir, $search, $draw, $action, $user = new User, $view_route = "", $view_permission = "", $edit_route = "", $edit_permission = "", $delete_route = "", $delete_permission = "", $custom_buttons = [], $custom_columns = [], $filter_columns = [], $filter_date = [], $formate_columns = [])
{
    $deleted_column = "";

    if ($fix_column) {
        $totalData = $table_data
            ->where($fix_column, $column_value)
            ->count();
    } else {
        $totalData = $table_data
            ->count();
    }

    if (!empty($search)) {
        if ($fix_column) {
            $rec = $table_data
                ->where(function ($query) use ($search, $search_columns) {
                    foreach ($search_columns as $key => $search_column) {
                        if ($key == 0) {
                            $query->where($search_column, 'like', '%' . $search . '%');
                        } else {
                            $query->orWhere($search_column, 'like', '%' . $search . '%');
                        }
                    }
                })
                ->where($fix_column, $column_value);
        } else {
            $rec = $table_data
                ->where(function ($query) use ($search, $search_columns) {
                    foreach ($search_columns as $key => $search_column) {
                        if ($key == 0) {
                            $query->where($search_column, 'like', '%' . $search . '%');
                        } else {
                            $query->orWhere($search_column, 'like', '%' . $search . '%');
                        }
                    }
                });
        }

        if ($filter_columns) {
            foreach ($filter_columns as $key => $filter) {
                if ($filter != "") {
                    if (getDeletedAtString($key) != "deleted_at") {
                        $rec = $table_data
                            ->where(function ($query) use ($filter, $key) {
                                $query->where($key, 'like', $filter . '%');
                            });
                    } else {
                        $deleted_column = $key;
                    }
                }
            }
        }
    } else {
        if ($filter_columns) {
            foreach ($filter_columns as $key => $filter) {
                if ($filter != "") {
                    if (getDeletedAtString($key) != "deleted_at") {
                        $rec = $table_data
                            ->where(function ($query) use ($filter, $key) {
                                $query->where($key, 'like', $filter . '%');
                            });
                    } else {
                        $deleted_column = $key;
                    }
                }
            }
        }
        if (empty($rec)) {
            if ($fix_column) {
                $rec = $table_data
                    ->where($fix_column, $column_value);
            } else {
                $rec = $table_data;
            }
        }
    }

    if ($deleted_column != "") {
        if ($filter_date['startDate']) {
            // If start and end dates are the same, filter for that exact day
            if ($filter_date['startDate'] === $filter_date['endDate']) {
                if (isset($filter_date['deleted_at'])) {
                    $totalFiltered = count($rec->whereNotNull($filter_date['deleted_at'])->whereDate($filter_date['created_at'], $filter_date['startDate'])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereNotNull($filter_date['deleted_at'])
                        ->whereDate($filter_date['created_at'], $filter_date['startDate'])
                        ->get();
                } else {
                    $totalFiltered = count($rec->whereDate($filter_date['created_at'], $filter_date['startDate'])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereDate($filter_date['created_at'], $filter_date['startDate'])
                        ->get();
                }
            } else {
                if (isset($filter_date['deleted_at'])) {
                    $totalFiltered = count($rec->whereNotNull($filter_date['deleted_at'])->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereNotNull($filter_date['deleted_at'])
                        ->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])
                        ->get();
                } else {
                    $totalFiltered = count($rec->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])
                        ->get();
                }
            }
        } else {
            if (isset($filter_date['deleted_at'])) {
                $totalFiltered = count($rec->whereNotNull($filter_date['deleted_at'])->get());
                $records = $rec->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->whereNotNull($filter_date['deleted_at'])
                    ->get();
            } else {
                $totalFiltered = count($rec->get());
                $records = $rec->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            }
        }
    } else {
        if ($filter_date['startDate']) {
            // If start and end dates are the same, filter for that exact day
            if ($filter_date['startDate'] === $filter_date['endDate']) {
                if (isset($filter_date['deleted_at'])) {
                    $totalFiltered = count($rec->whereNull($filter_date['deleted_at'])->whereDate($filter_date['created_at'], $filter_date['startDate'])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereNull($filter_date['deleted_at'])
                        ->whereDate($filter_date['created_at'], $filter_date['startDate'])
                        ->get();
                } else {
                    $totalFiltered = count($rec->whereDate($filter_date['created_at'], $filter_date['startDate'])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereDate($filter_date['created_at'], $filter_date['startDate'])
                        ->get();
                }
            } else {
                if (isset($filter_date['deleted_at'])) {
                    $totalFiltered = count($rec->whereNull($filter_date['deleted_at'])->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereNull($filter_date['deleted_at'])
                        ->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])
                        ->get();
                } else {
                    $totalFiltered = count($rec->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])->get());
                    $records = $rec->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->whereBetween($filter_date['created_at'], [$filter_date['startDate'], Carbon::parse($filter_date['endDate'])->endOfDay()])
                        ->get();
                }
            }
        } else {
            if (isset($filter_date['deleted_at'])) {
                $totalFiltered = count($rec->whereNull($filter_date['deleted_at'])->get());
                $records = $rec->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->whereNull($filter_date['deleted_at'])
                    ->get();
            } else {
                $totalFiltered = count($rec->get());
                $records = $rec->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            }
        }
    }

    $data = array();

    if (!empty($records)) {
        foreach ($records as $record) {
            $record = get_object_vars($record);
            $i = 0;
            while ($i <= count($columns) - 2) {
                $nestedData[$columns[$i]] = $record[$columns[$i]];
                $i++;
            }

            foreach ($custom_columns as $custom_column) {
                if ($custom_column == 'record_time') {
                    $nestedData[$custom_column] = timeFormat($record['created_at']);
                } elseif ($custom_column == 'edited_at') {
                    if (Carbon::parse($record['updated_at'])->gt($record['created_at'])) {
                        $nestedData[$custom_column] = '<span class="text-white bg-danger">' . $record['updated_at'] . '</span>';
                    } else {
                        $nestedData[$custom_column] = '';
                    }
                } elseif ($custom_column == 'register') {
                    if ($record['status'] == 'pending') {
                        $nestedData[$custom_column] = '';
                    } else {
                        $nestedData[$custom_column] = '<a class="dt-button add-new btn btn-primary btn-sm btn-circle" href="' . route("students.show", ['student' => $record['id']]) . '"><i class="ti ti-chart-bar"></i></a>';
                    }
                } elseif ($custom_column == 'register_new') {
                    if ($record['status'] == 'registered') {
                        $nestedData[$custom_column] = '';
                    } else {
                        $nestedData[$custom_column] = '<a class="dt-button add-new btn btn-primary btn-sm btn-circle" href="' . route("new_students.show", ['new_student' => $record['id']]) . '"><i class="ti ti-chart-bar"></i></a>';
                    }
                }
            }

            foreach ($formate_columns as $formate_column => $type) {
                if ($type == 'translate') {
                    $nestedData[$formate_column] = __($nestedData[$formate_column]);
                } elseif ($type == 'number') {
                    $nestedData[$formate_column] = displayAmount($nestedData[$formate_column]);
                } elseif ($type == 'date') {
                    $nestedData[$formate_column] = dateFormat($nestedData[$formate_column]);
                } elseif ($type == 'percent') {
                    $nestedData[$formate_column] = round($nestedData[$formate_column], 0) . '%';
                } elseif ($type == 'badge') {
                    if ($nestedData[$formate_column] == 0) {
                        $nestedData[$formate_column] = '<span class="badge bg-danger rounded-pill">' . __("messages.datatable.badge.no") . '</span>';
                    } elseif ($nestedData[$formate_column] == 1) {
                        $nestedData[$formate_column] = '<span class="badge bg-success rounded-pill">' . __("messages.datatable.badge.yes") . '</span>';
                    } elseif ($nestedData[$formate_column] == 'pending') {
                        $nestedData[$formate_column] = '<span class="badge bg-warning rounded-pill">' . __($nestedData[$formate_column]) . '</span>';
                    } elseif ($nestedData[$formate_column] == 'ready') {
                        $nestedData[$formate_column] = '<span class="badge bg-success rounded-pill">' . __($nestedData[$formate_column]) . '</span>';
                    } else {
                        $nestedData[$formate_column] = '<span class="badge bg-primary rounded-pill">' . __($nestedData[$formate_column]) . '</span>';
                    }
                } elseif ($type == 'user_status') {
                    if ($nestedData[$formate_column] == 0) {
                        $nestedData[$formate_column] = '<span class="badge bg-danger rounded-pill">' . __("messages.status.blocked") . '</span>';
                    } elseif ($nestedData[$formate_column] == 1) {
                        $nestedData[$formate_column] = '<span class="badge bg-success rounded-pill">' . __("messages.status.active") . '</span>';
                    }
                } elseif ($type == 'student_type') {
                    if ($nestedData[$formate_column] == 1) {
                        $nestedData[$formate_column] = '<span class="badge bg-success rounded-pill">' . __("messages.navbar.nav2.student") . '</span>';
                    } elseif ($nestedData[$formate_column] == 0) {
                        $nestedData[$formate_column] = '<span class="badge bg-danger rounded-pill">' . __("messages.navbar.nav2.new_student") . '</span>';
                    }
                } elseif ($type == 'profile_image') {
                    $short_name = getInitials(__($nestedData[$formate_column]));
                    $nestedData[$formate_column] = '<div class="d-flex justify-content-start align-items-center user-name"> <div class="avatar-wrapper"> <div class="avatar avatar-sm me-4"> <div class="avatar avatar-online"> <img src=" ' . getProfilePicture2($nestedData['id']) . '" alt class="rounded-circle"> </div> </div> </div> <div class="d-flex flex-column"> <a href="#" class="text-heading text-truncate"> <span class="fw-medium"> ' . __($nestedData[$formate_column]) . ' </span> </a> </div> </div>';
                } elseif ($type == 'avatar') {
                    $short_name = getInitials(__($nestedData[$formate_column]));
                    $nestedData[$formate_column] = '<div class="d-flex justify-content-start align-items-center user-name"> <div class="avatar-wrapper"> <div class="avatar avatar-sm me-4"> <div class="avatar avatar-online"> <img src="https://ui-avatars.com/api/?name=' . $nestedData[$formate_column] . '&color=7F9CF5&background=EBF4FF" alt class="rounded-circle"> </div> </div> </div> <div class="d-flex flex-column"> <a href="#" class="text-heading text-truncate"> <span class="fw-medium"> ' . __($nestedData[$formate_column]) . ' </span> </a> </div> </div>';
                }
            }

            $dropDownButtons = '';
            $buttons = '';
            $dropDown = '';
            foreach ($custom_buttons as $button) {
                $btn = getDataTableButtons($button['user'], $button['permission'], $button['route'], [$button['id'] => $record['id']], $button['btn_text'], $button['icon'], $button['attribute'], $button['condition'], $record);
                $dropDownButtons = $dropDownButtons . $btn;
            }
            if (count($custom_buttons) > 0) {
                $dropDown = '<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-20px"></i></button><div class="m-0 dropdown-menu dropdown-menu-end">' . $dropDownButtons . '</div>';
            }

            if ($action) {
                if ($user->can($view_permission)) {
                    $view_btn = '<a href="' . route($view_route, $record['id']) . '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect"><i class="ti ti-eye"></i></a>';
                    $buttons = $buttons . $view_btn;
                }
                if ($user->can($edit_permission)) {
                    if (Route::has($edit_route)) {
                        // The route exists
                        $edit_btn = '<a href="' . route($edit_route, $record['id']) . '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect"><i class="ti ti-edit"></i></a>';
                    } else {
                        // The route does not exist
                        $edit_btn = '<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="1" data-bs-toggle="offcanvas" data-bs-target="#' . $edit_route . '"><i class="ti ti-edit"></i></button>';
                    }
                    $buttons = $buttons . $edit_btn;
                }
                if ($user->can($delete_permission)) {
                    if (isset($record['deleted_at'])) {
                        if ($record['deleted_at'] == NULL) {
                            $delete_btn = '<form class="delete-record" method="POST" action="' . route($delete_route, $record['id']) . '">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"> <button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect"><i class="ti ti-trash"></i></button> </form>';
                            $buttons = $buttons . $delete_btn;
                        } else {
                            $buttons = '';
                            $dropDown = '';
                        }
                    } else {
                        $delete_btn = '<form class="delete-record" method="POST" action="' . route($delete_route, $record['id']) . '">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"> <button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect"><i class="ti ti-trash"></i></button> </form>';
                        $buttons = $buttons . $delete_btn;
                    }
                }

                $nestedData['action'] = '<div class="d-flex align-items-center gap-50"> ' . $buttons . ' ' . $dropDown . ' </div>';
            }

            $data[] = $nestedData;
        }
    }

    return array(
        "draw"            => intval($draw),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    );
}

function updateDotEnv($key, $newValue, $delim = '')
{
    $path = base_path('.env');
    // get old value from current env
    $oldValue = env($key);

    // was there any change?
    if ($oldValue === $newValue) {
        return;
    }

    // rewrite file content with changed data
    if (file_exists($path)) {
        // replace current value with new value
        file_put_contents(
            $path,
            str_replace(
                $key . '=' . $delim . $oldValue . $delim,
                $key . '=' . $delim . $newValue . $delim,
                file_get_contents($path)
            )
        );
    }
}

function getInitials($name)
{
    // Split the name by spaces
    $words = explode(' ', trim($name));

    // Check the number of words
    if (count($words) > 1) {
        // If there are multiple words, take the first letter of the first and last words
        $initials = Str::upper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    } else {
        // If there is only one word, take the first letter and make it uppercase
        $initials = Str::upper(substr($words[0], 0, 1));
    }

    return $initials;
}

function dateFormat($date)
{
    return Carbon::parse($date)->format(getJsonSetting('system_settings', 'date_format'));
}

function timeFormat($date)
{
    return Carbon::parse($date)->format(getJsonSetting('system_settings', 'time_format'));
}

function getDateFormats()
{
    return [
        'd/m/Y' => Carbon::now()->format('d/m/Y'),
        'm/d/Y' => Carbon::now()->format('m/d/Y'),
        'Y/m/d' => Carbon::now()->format('Y/m/d'),
        'Y/d/m' => Carbon::now()->format('Y/d/m'),
        'm-d-Y' => Carbon::now()->format('m-d-Y'),
        'd-m-Y' => Carbon::now()->format('d-m-Y'),
        'Y-m-d' => Carbon::now()->format('Y-m-d'),
        'Y-d-m' => Carbon::now()->format('Y-d-m'),
        'd/M/Y' => Carbon::now()->format('d/M/Y'),
        'D/M/Y' => Carbon::now()->format('D/M/Y'),
        'M/d/Y' => Carbon::now()->format('M/d/Y'),
        'Y/M/d' => Carbon::now()->format('Y/M/d'),
        'Y/d/M' => Carbon::now()->format('Y/d/M'),
        'M-d-Y' => Carbon::now()->format('M-d-Y'),
        'd-M-Y' => Carbon::now()->format('d-M-Y'),
        'D-M-Y' => Carbon::now()->format('D-M-Y'),
        'Y-M-d' => Carbon::now()->format('Y-M-d'),
        'Y-d-M' => Carbon::now()->format('Y-d-M'),
    ];
}

function getTimeFormats()
{
    return [
        'h:i a' => Carbon::now()->format('h:i a'),
        'h:i A' => Carbon::now()->format('h:i A'),
        'H:i'   => Carbon::now()->format('H:i'),
    ];
}

function getProfilePicture(User $user)
{
    $path = 'images/users/';
    return Storage::url($path . $user->profile_image);
}

function getProfilePicture2($id)
{
    $user = User::find($id);
    return $user ? $user->profile_photo_url : asset('assets/img/avatars/1.png');
}

function getCountries()
{
    return [
        'Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahamas',
        'Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bhutan',
        'Bolivia',
        'Bosnia and Herzegovina',
        'Botswana',
        'Brazil',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burundi',
        'Cabo Verde',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'Comoros',
        'Congo (Congo-Brazzaville)',
        'Costa Rica',
        'Croatia',
        'Cuba',
        'Cyprus',
        'Czechia (Czech Republic)',
        'Democratic Republic of the Congo',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Eswatini (fmr. Swaziland)',
        'Ethiopia',
        'Fiji',
        'Finland',
        'France',
        'Gabon',
        'Gambia',
        'Georgia',
        'Germany',
        'Ghana',
        'Greece',
        'Grenada',
        'Guatemala',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Honduras',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Marshall Islands',
        'Mauritania',
        'Mauritius',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Morocco',
        'Mozambique',
        'Myanmar (formerly Burma)',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'North Korea',
        'North Macedonia',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestine State',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Poland',
        'Portugal',
        'Qatar',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Vincent and the Grenadines',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Sweden',
        'Switzerland',
        'Syria',
        'Taiwan',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'Timor-Leste',
        'Togo',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom',
        'United States of America',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Vatican City',
        'Venezuela',
        'Vietnam',
        'Yemen',
        'Zambia',
        'Zimbabwe'
    ];
}

function getSessions($userId)
{
    if (config('session.driver') !== 'database') {
        return collect([]);
    }

    return DB::table('sessions')
        ->where('user_id', $userId)
        ->get()
        ->map(function ($session) {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);

            $location = getLocation($session->ip_address);

            return (object) [
                'id' => $session->id,
                'device' => getDeviceType($agent),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'is_robot' => $agent->isRobot(),
                'is_desktop' => $agent->isDesktop(),
                'is_mobile' => $agent->isMobile(),
                'ip_address' => $session->ip_address,
                'location' => $location,
                'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
            ];
        });
}

function getDeviceType($agent)
{
    if ($agent->isDesktop()) {
        return 'Desktop';
    } elseif ($agent->isMobile()) {
        return 'Mobile';
    } elseif ($agent->isTablet()) {
        return 'Tablet';
    } elseif ($agent->isRobot()) {
        return 'Robot';
    } else {
        return 'Unknown';
    }
}

function getLocation($ip)
{
    try {
        $client = new Client();
        $response = $client->get("http://ipinfo.io/{$ip}/json");
        $locationData = json_decode($response->getBody(), true);

        return "{$locationData['city']}, {$locationData['region']}, {$locationData['country']}";
    } catch (\Exception $e) {
        return 'Unknown Location';
    }
}

function getDeletedAtString($delete)
{
    // Match 'deleted_at' from the string
    preg_match('/deleted_at/', $delete, $matches);

    // If the match is found, you can access it
    if (isset($matches[0])) {
        return $matches[0];
    } else {
        return '';
    }
}

function getModuleJson($moduleName)
{
    $modulePath = module_path($moduleName);
    $moduleJsonPath = $modulePath . '/module.json';

    if (File::exists($moduleJsonPath)) {
        $moduleJson = json_decode(File::get($moduleJsonPath), true);
        return $moduleJson ?? null;  // Return priority if it exists, else null
    }

    return null;
}

function setModulePriority($moduleName, $newPriority)
{
    $modulePath = module_path($moduleName);
    $moduleJsonPath = $modulePath . '/module.json';

    if (File::exists($moduleJsonPath)) {
        $moduleJson = json_decode(File::get($moduleJsonPath), true);
        $moduleJson['priority'] = $newPriority;  // Modify the priority

        // Save the updated json back to module.json
        File::put($moduleJsonPath, json_encode($moduleJson, JSON_PRETTY_PRINT));

        return true; // Successfully updated the priority
    }

    return false; // Failed to update the priority
}

function clearCache()
{
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
}

/**
 * Check appointment availability and generate booking number
 *
 * @param int $hospitalId The hospital ID
 * @param string $date The appointment date in Y-m-d format
 * @param int|null $specializationId The specialization ID
 * @return array Returns booking number and date
 */
function getAppointmentBookingNumber($hospitalId, $date, $specializationId = null)
{
    // Get hospital settings
    $hospital = DB::table('hospitals')->where('id', $hospitalId)->first();

    if (!$hospital) {
        return [
            'success' => false,
            'message' => 'Hospital not found',
            'booking_number' => null,
            'date' => $date
        ];
    }

    // Debug log to track what's being received
    \Illuminate\Support\Facades\Log::info('getAppointmentBookingNumber called with', [
        'hospital_id' => $hospitalId,
        'date' => $date,
        'specialization_id' => $specializationId,
        'specialization_id_type' => gettype($specializationId),
        'auto_booking' => $hospital->auto_booking
    ]);

    try {
        // Ensure the specialization ID is an integer or null, not an empty string
        if ($specializationId === '' || $specializationId === '0' || $specializationId === 0) {
            $specializationId = null;
        } else {
            $specializationId = is_numeric($specializationId) ? intval($specializationId) : null;
        }

        \Illuminate\Support\Facades\Log::info('Processed specialization ID', [
            'specialized_id_after_processing' => $specializationId,
            'type' => gettype($specializationId)
        ]);

        // If auto_booking is enabled and we have valid hospital, specialization, and date, implement the new flow
        if ($hospital->auto_booking && !is_null($specializationId) && !is_null($date)) {
            // Get the hospital-specialization relationship data including working_days and booking_limit
            $hospitalSpecialization = DB::table('hospital_specialization')
                ->where('hospital_id', $hospitalId)
                ->where('specialization_id', $specializationId)
                ->first();

            if (!$hospitalSpecialization) {
                return [
                    'success' => false,
                    'message' => 'Specialization not available at this hospital',
                    'booking_number' => null,
                    'date' => $date
                ];
            }

            // Get the booking limit for this hospital-specialization pair
            $bookingLimit = $hospitalSpecialization->booking_limit ?? 40;

            // Get working days for this specialization
            $workingDays = json_decode($hospitalSpecialization->working_days ?? '[]');

            if (empty($workingDays)) {
                \Illuminate\Support\Facades\Log::info('No working days defined', [
                    'specialization_id' => $specializationId,
                    'hospital_id' => $hospitalId
                ]);
                $workingDays = \Modules\Medical\Enums\Day::all(); // Default to all days if not specified
            }

            \Illuminate\Support\Facades\Log::info('Working days and booking limit', [
                'working_days' => $workingDays,
                'booking_limit' => $bookingLimit
            ]);

            // Get the day of week for the requested date
            $dateCarbon = \Carbon\Carbon::parse($date);
            $dayOfWeek = strtolower($dateCarbon->format('l')); // Returns day name in lowercase (monday, tuesday, etc.)

            // Find an available date starting from the requested date
            $finalDate = null;
            $bookingNumber = null;
            $daysToCheck = 30; // Maximum days to check forward
            $dateFound = false;
            $checkDate = $date; // Start with requested date
            $checkDateCarbon = $dateCarbon->copy();

            for ($i = 0; $i < $daysToCheck && !$dateFound; $i++) {
                // Only proceed if the current check date is a working day
                $dayOfWeek = strtolower($checkDateCarbon->format('l'));

                \Illuminate\Support\Facades\Log::info('Checking working day', [
                    'check_date' => $checkDate,
                    'day_of_week' => $dayOfWeek,
                    'is_working_day' => in_array($dayOfWeek, $workingDays)
                ]);

                if (in_array($dayOfWeek, $workingDays)) {
                    // Count existing appointments for this hospital, specialization, and date
                    $existingCount = DB::table('appointments')
                        ->where('hospital_id', $hospitalId)
                        ->where('specialization_id', $specializationId)
                        ->whereDate('appointment_date', $checkDate)
                        ->count();

                    \Illuminate\Support\Facades\Log::info('Checking appointment limit', [
                        'check_date' => $checkDate,
                        'existing_count' => $existingCount,
                        'booking_limit' => $bookingLimit
                    ]);

                    // Check if we have room for one more appointment
                    if ($existingCount < $bookingLimit) {
                        $finalDate = $checkDate;
                        $dateFound = true;

                        // Booking number will be the next sequential number for this date
                        $bookingNumber = $existingCount + 1;

                        \Illuminate\Support\Facades\Log::info('Available slot found', [
                            'final_date' => $finalDate,
                            'booking_number' => $bookingNumber
                        ]);

                        // If the date is different from requested, notify the user
                        if ($finalDate != $date) {
                            return [
                                'success' => true,
                                'message' => "The requested date is fully booked or not a working day. Next available date is {$finalDate}",
                                'booking_number' => $bookingNumber,
                                'auto_booking' => true,
                                'date' => $finalDate
                            ];
                        } else {
                            return [
                                'success' => true,
                                'message' => "Appointment slot available",
                                'booking_number' => $bookingNumber,
                                'auto_booking' => true,
                                'date' => $finalDate
                            ];
                        }
                    }
                }

                // Move to the next day for checking
                $checkDateCarbon->addDay();
                $checkDate = $checkDateCarbon->format('Y-m-d');
            }

            // If we reached here, no available slots were found within the checked days
            return [
                'success' => false,
                'message' => "No available slots found within the next {$daysToCheck} working days",
                'booking_number' => null,
                'date' => $date
            ];
        } else {
            // For manual booking or no specialization provided, just return the next sequential number
            // Count existing appointments for this hospital on the selected date
            $existingCount = DB::table('appointments')
                ->where('hospital_id', $hospitalId)
                ->whereDate('appointment_date', $date)
                ->count();

            // Generate booking number (increment count by 1)
            $bookingNumber = $existingCount + 1;

            $message = 'Booking number generated successfully';
            if ($hospital->auto_booking) {
                $message = 'Auto booking is enabled for this hospital, but no specialization was provided (ID: ' .
                    ($specializationId === null ? 'null' : $specializationId) .
                    ', Type: ' . gettype($specializationId) . ')';
            }

            return [
                'success' => true,
                'message' => $message,
                'booking_number' => $bookingNumber,
                'auto_booking' => $hospital->auto_booking,
                'date' => $date
            ];
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error in getAppointmentBookingNumber', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return [
            'success' => false,
            'message' => 'Error generating booking number: ' . $e->getMessage(),
            'booking_number' => null,
            'date' => $date
        ];
    }
}

function isBookingNumberAvailable($hospitalId, $date, $bookingNumber)
{
    // Check if booking number already exists for the given hospital and date
    $exists = DB::table('appointments')
        ->where('hospital_id', $hospitalId)
        ->whereDate('appointment_date', $date)
        ->where('appointment_number', $bookingNumber)
        ->exists();

    return !$exists; // Return true if booking number is available (doesn't exist)
}
