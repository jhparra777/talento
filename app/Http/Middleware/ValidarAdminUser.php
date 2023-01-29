<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class ValidarAdminUser
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

            if (!Sentinel::inRole("admin")) {
               $request->session()->flush();
                Sentinel::logout();
                return redirect()->route('admin.login');
            }
            
            //            if ($user->estado != 1) {
            //                Auth::logout();
            //                return redirect()->route('login_req_view');
            //            }

            if (!in_array($name_ruta, config('rutasNoValidacion.ROUTES_NO_VALIDATE'))) {

                if (!$user->hasAccess($name_ruta) && !$request->ajax()) {
                    return redirect()->route('admin.permiso_negado');
                }
            }
        } else {
            session(["url_deseada_redireccion" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('admin.login');
        }

        return $next($request);
    }

}
