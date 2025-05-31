<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\Remote;
use Illuminate\Support\Facades\Cache;

class AuthApi
{
    use Remote;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! session()->has('email') || ! session()->has('password')) {
            return redirect()->route('auth.create');
        }

        $cache_key = 'auth_token_' . session('email');

        if (! Cache::has($cache_key)) {
            $credentials = [
                'email'     => session('email'),
                'password'  => session('password'),
            ];
            
            $authResult = $this->getAuthToken($credentials);

            if ($authResult->status == 'FAILED') {
                return redirect()->route('auth.create');
            }            
        }

        return $next($request);
    }
}
