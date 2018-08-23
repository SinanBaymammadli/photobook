<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminLoginUrl = '/admin/login';

        if (!Auth::guest()) {
            $user = auth()->user();

            if ($user->is_admin) {
                return $next($request);
            } else {
                Auth::logout();
                // error message
                return redirect($adminLoginUrl)
                    ->withErrors([
                        "email" => trans('auth.failed'),
                    ]);
            }
        }

        return redirect()->guest($adminLoginUrl);
    }
}
