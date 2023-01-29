<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;

class SessionTime {
    protected $session;
    protected $timeout = 5;

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
        if($request->json()){
            if(!$this->session->has('lastActivityTime')){
                $this->session->put('lastActivityTime',time());
            }elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
                $this->session->forget('lastActivityTime');
                
                Auth::logout();
                
                //return redirect()->route("admin.login")->with(['mensaje_error' => 'El usuario no ha tenido actividad en '.$this->timeout/60 .' minutos.']);
                
                return response()->json(["session"=>false]);
            }

            //$this->session->put('lastActivityTime',time());
            return $next($request);
        }

        //$this->session->put('lastActivityTime',time());      
        //return $next($request);
    }
}