<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Setting\Models\Language;

class LanguageController extends Controller
{
    public function swap(Request $request, $locale)
    {
        // Languages
        $language_code = Language::where('status', 1)->pluck('code')->toArray();
        if (!in_array($locale, $language_code)) {
            abort(400);
        } else {
            $request->session()->put('locale', $locale);
        }
        App::setLocale($locale);
        $user = User::find(Auth::id());
        $user->language = $locale;
        $user->save();
        return redirect()->back();
    }
}
