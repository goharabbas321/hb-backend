<?php

namespace Modules\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ResponseService::noPermissionThenRedirect('system-setting-manage');
        //$settings = $this->cache->getSystemSettings();
        //$settings = $this->systemSettings->getSettings(['arabic_name']);
        //$settings = $this->systemSettings->getJsonSettings('system_settings', 'name');
        //dd($settings);
        //ResponseService::successResponse('User logged-in!', new UserDataResource(Auth::user()), ['token' => 'dfggfs'], config('constants.RESPONSE_CODE.LOGIN_SUCCESS'));
        //ResponseService::errorResponse('Invalid Login Credentials', null, config('constants.RESPONSE_CODE.INVALID_LOGIN'));
        //dd(app());

        //$this->cache->removeSystemCache(config('constants.CACHE.SYSTEM.SETTINGS'));
        //ResponseService::successResponse('Data Updated Successfully');
        $systemSettings = app(config('constants.CACHE.SYSTEM.SETTINGS'));

        if ($systemSettings['frontend_view'] == 1) {
            $pageConfigs = ['myLayout' => 'front'];
            return view('front::index', ['pageConfigs' => $pageConfigs]);
        } else {
            return redirect(route('login'));
        }
    }
}
