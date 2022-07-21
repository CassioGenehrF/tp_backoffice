<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null(Auth::user()->verified)) {
            return redirect(route('owner.documents'));
        }

        if (!Auth::user()->verified->verified) {
            return redirect(route('owner.not_verified'));
        }

        return $next($request);
    }
}
