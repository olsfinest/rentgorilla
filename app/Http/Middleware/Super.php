<?php namespace RentGorilla\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Super {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->auth->check() )
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }

            return redirect('/login');
        }

        if( ! $this->auth->user()->isSuper()) {
            return redirect()->route('rental.index')->with('flash:success', 'Sorry, you do not have permission to access that resource.');
        }

        return $next($request);
    }
}