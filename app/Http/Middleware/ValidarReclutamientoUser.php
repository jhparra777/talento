<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class ValidarReclutamientoUser
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
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


        if (Sentinel::check()) {
            if (!Sentinel::inRole("reclutamiento_externo")) {
                Sentinel::logout();
                return redirect()->route('reclutamiento_externo.login')->with("mensaje_error", "No tiene permisos para este modulo");
            }

        } else {
            return redirect()->route('reclutamiento_externo.login');
        }
        return $next($request);
    
    }

}
