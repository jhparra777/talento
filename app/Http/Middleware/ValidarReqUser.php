<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class ValidarReqUser
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
            $user = Sentinel::getUser();
            // return redirect()->route('dashboard');
            $name_ruta = $request->route()->getName();
            //SI EL USUARIO ESTA ACTIVO
            if (!Sentinel::inRole("req")) {
                Sentinel::logout();
                return redirect()->route('login_req_view');
            }
//            if ($user->estado != 1) {
            //                Auth::logout();
            //                return redirect()->route('login_req_view');
            //            }
            if (!$user->hasAccess($name_ruta)) {
                return redirect()->route('permiso_negado');
            }
        } else {
            session(["url_deseada_redireccion" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login_req_view');
        }

        return $next($request);
    }

}
