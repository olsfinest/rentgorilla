<?php namespace RentGorilla\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{


    private $openRoutes = [
        'stripe/webhook'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(in_array($request->path(), $this->openRoutes)) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }

}