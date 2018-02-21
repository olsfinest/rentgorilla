<?php

namespace RentGorilla\Http\Middleware;

use Closure;

class Sensitive
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
        if($this->isLoggedInAsSuper($request)) {
            return $next($request);
        }

        if ($this->isLoggedInAsAdmin($request)) {
            return redirect()->route('rental.index')->with('flash:success', 'Sorry, you do not have permission to access that resource.');
        }

        return $next($request);
    }

    /**
     * Determine if an admin has taken over a users account
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    private function isLoggedInAsAdmin($request)
    {
        return $request->session()->has('admin');
    }

    /**
     * Determine if a super admin has taken over a users account or is a super admin
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    private function isLoggedInAsSuper($request)
    {
        return ($request->session()->has('super') || $request->user()->isSuper());
    }
}