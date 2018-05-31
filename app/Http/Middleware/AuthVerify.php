<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\UserMeta;
use Redirect, Request;

class AuthVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if( Auth::check() ) {            
            $user_id = Auth::user()->id;

            if( ! UserMeta::get_meta($user_id, 'email_verified') ) {
                return Redirect::route('user.dashboard')
                               ->with('info','You must verify your email address to activate your account and start posting.');
            }

            if( ! UserMeta::get_meta($user_id, 'facebook_access_token') && Request::is('user/posts/*') ) {
                return Redirect::route('user.dashboard')
                               ->with('info','You must connect with facebook to allow application and start posting.');
            }
        }

        return $next($request);
    }
}
