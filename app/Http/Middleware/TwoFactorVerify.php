<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactorVerify
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
        $user = auth()->user();
        if((!is_null($user->two_factor_verified_at) OR !$user->two_factor_activated) && !is_null($user->mobile_verified_at)) {
            return $next($request);
        }
        return redirect('/2fa');
    }
}
