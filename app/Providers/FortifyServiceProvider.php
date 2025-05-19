<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Registration
        Fortify::registerView(function () {
            $systemSettings = app(config('constants.CACHE.SYSTEM.SETTINGS'));
            if ($systemSettings['registration'] == 1) {
                return view('auth.register');
            } else {
                return redirect(route('login'));
            }
        });

        // Authentication
        Fortify::authenticateUsing(function (Request $request) {
            $login = $request->username;
            $password = $request->password;
            $user = User::where('email', $login)->orWhere('username', $login)->orWhere('phone', $login)->first();
            if ($user && Hash::check($password, $user->password)) {
                return $user;
            }
            // Custom error response
            /*throw ValidationException::withMessages([
                Fortify::username() => __('Custom error: Invalid login credentials.'),
            ]);*/
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
