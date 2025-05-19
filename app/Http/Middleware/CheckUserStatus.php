<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user's status is 0 (blocked)
        if ($user && $user->status === 0) {
            // Log out the user
            Auth::guard('web')->logout();

            // Redirect to login page with an error message
            return redirect()->route('login')->withErrors(['error' => __('messages.fortify.blocked')]);
        }

        return $next($request);
    }
}
