<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $page_title = 'setting::messages.settings.general_settings.heading';
        $general_settings = json_decode(Setting::where('key', 'system_settings')->first()->value);
        return view('setting::index', compact('page_title', 'general_settings'));
    }

    public function updateGeneralSettings(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'keywords' => 'nullable|string',
            'keywords_ar' => 'nullable|string',
            'address' => 'required|string|max:255',
            'address_ar' => 'required|string|max:255',
            'country' => 'required',
            'time_zone' => 'required',
            'date_format' => 'required',
            'time_format' => 'required',
            'language' => 'required',
            'currency' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'logo_light' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'logo_dark' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'frontend_view' => 'nullable|string|in:on,off',
            'registration' => 'nullable|string|in:on,off',
        ]);

        $generalSettings = Setting::where('key', 'system_settings')->first();
        $settingsData = json_decode($generalSettings->value, true);

        // Update settings with new data
        $settingsData['name'] = $request->name;
        $settingsData['name_ar'] = $request->name_ar;
        $settingsData['title'] = $request->title;
        $settingsData['title_ar'] = $request->title_ar;
        $settingsData['description'] = $request->description;
        $settingsData['description_ar'] = $request->description_ar;
        $settingsData['keywords'] = $request->keywords;
        $settingsData['keywords_ar'] = $request->keywords_ar;
        $settingsData['address'] = $request->address;
        $settingsData['address_ar'] = $request->address_ar;
        $settingsData['country'] = $request->country;
        $settingsData['time_zone'] = $request->time_zone;
        updateDotEnv('APP_TIMEZONE', $request->time_zone);
        $settingsData['language'] = $request->language;
        updateDotEnv('APP_LOCALE', $request->language);
        $settingsData['currency'] = $request->currency;
        $settingsData['date_format'] = $request->date_format;
        $settingsData['time_format'] = $request->time_format;
        $settingsData['email'] = $request->email;
        $settingsData['phone'] = $request->phone;
        $settingsData['frontend_view'] = $request->has('frontend_view') ? 1 : 0;
        $settingsData['registration'] = $request->has('registration') ? 1 : 0;

        // Handle file uploads with renaming
        if ($request->hasFile('favicon')) {
            $faviconFile = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
            $faviconPath = $faviconFile->storeAs('settings', $faviconName, 'public');
            $settingsData['favicon'] = $faviconPath;
        }

        if ($request->hasFile('logo_light')) {
            $logo_lightFile = $request->file('logo_light');
            $logo_lightName = 'logo_light_' . time() . '.' . $logo_lightFile->getClientOriginalExtension();
            $logo_lightPath = $logo_lightFile->storeAs('settings', $logo_lightName, 'public');
            $settingsData['logo_light'] = $logo_lightPath;
        }

        if ($request->hasFile('logo_dark')) {
            $logo_darkFile = $request->file('logo_dark');
            $logo_darkName = 'logo_dark_' . time() . '.' . $logo_darkFile->getClientOriginalExtension();
            $logo_darkPath = $logo_darkFile->storeAs('settings', $logo_darkName, 'public');
            $settingsData['logo_dark'] = $logo_darkPath;
        }

        // Save updated settings back to the database
        $generalSettings->value = json_encode($settingsData);
        $generalSettings->save();

        clearCache();

        return redirect()->route('settings.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    public function activityLogs()
    {
        $page_title = 'setting::messages.settings.logs.heading';
        return view('setting::logs', compact('page_title'));
    }

    public function getLogsData($id, Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'log_name',
            3 => 'description',
            4 => 'subject_type',
            5 => 'event',
            6 => 'subject_id',
            7 => 'causer_name',
            8 => 'causer_id',
            9 => 'properties',
            10 => 'created_at',
            11 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'created_at' => 'date'
        );

        $search_columns = array(
            0 => 'id',
            1 => 'log_name',
            2 => 'description',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'created_at',
        );

        $filter_columns = array(
            'status' => $request->input('status'),
        );

        $table_data = DB::table('activity_log')
            ->leftJoin('users', 'activity_log.causer_id', '=', 'users.id') // Join the users table to get user details
            ->select('activity_log.*', 'users.name as causer_name'); // Select activity log data and user name

        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'permissions.id';
        }
        $column_value = $id;

        $action = false;
        $view_route = 'settings.show';
        $view_permission = 'read_userss';
        $edit_route = 'settings.edit';
        $edit_permission = 'update_settings';
        $delete_route = 'settings.destroy';
        $delete_permission = 'delete_settings';

        $buttons = [];

        /*$buttons[] = [
        'user' => Auth::user(),
        'permission' => 'read_users',
        'route' => 'users.index',
        'id' => 'id',
        'btn_text' => 'Print',
        'icon' => 'ti-printer',
        'attribute' => 'target="_blank"'
        ];*/

        $user = Auth::user();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $draw = $request->input('draw');

        $json_data = getJsonDataTable($fix_column, $column_value, $columns, $search_columns, $table_data, $limit, $start, $order, $dir, $search, $draw, $action, $user, $view_route, $view_permission, $edit_route, $edit_permission, $delete_route, $delete_permission, $buttons, $custom_columns, $filter_columns, $filter_date, $formate_columns);

        echo json_encode($json_data);
    }

    public function createBackup()
    {
        Artisan::call('backup:run');

        return response()->json([
            'success' => true,
            'message' => __('messages.backup'),
        ]);
        //return redirect()->back()->withNotify([['success', __('messages.backup')]]);
    }

    public function getArabicAmount(Request $request)
    {
        $amount = (int) str_replace(',', '', $request->amount);
        if ($amount) {
            return displayArabicNumber($amount);
        }
        return "";
    }

    public function clearCache()
    {
        clearCache();
        return redirect()->back()->withNotify([['success', __('messages.cache_clear')]]);
    }
}
