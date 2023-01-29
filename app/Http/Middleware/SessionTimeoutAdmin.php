<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Illuminate\Session\Store;

class SessionTimeoutAdmin {
    protected $session;
    protected $timeout = 5400;

    public function __construct(Store $session){
        $this->session=$session;
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
        /*if($request->json()){

                 if(!$this->session->has('lastActivityTime'))
                $this->session->put('lastActivityTime',time());
            elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
                
                $this->session->forget('lastActivityTime');
                Auth::logout();
                //return redirect()->route("admin.login")->with(['mensaje_error' => 'El usuario no ha tenido actividad en '.$this->timeout/60 .' minutos.']);
                return response()->json(["session"=>false]);
            }
            //$this->session->put('lastActivityTime',time());
          
            return $next($request);

        }*/
        
        if(!$this->session->has('lastActivityTime'))
            $this->session->put('lastActivityTime',time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){

            $this->session->forget('lastActivityTime');
            //Auth::logout();// este no cierra la sesión
            Sentinel::logout();
            return redirect()->route("admin.login")->with(['mensaje_error' => 'El usuario no ha tenido actividad en '.$this->timeout/60 .' minutos.']);
        }
        $this->session->put('lastActivityTime',time());

        return $next($request);
    }
}