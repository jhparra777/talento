<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;

    class SessionTimeoutReq {
    protected $session;
    protected $timeout=5400;

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
      
        if(!$this->session->has('lastActivityTime'))
            $this->session->put('lastActivityTime',time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
            $this->session->forget('lastActivityTime');
            Auth::logout();
            return redirect()->route("login_req_view")->with(['mensaje_error' => 'El usuario no ha tenido actividad en '.$this->timeout/60 .' minutos.']);
        }
        $this->session->put('lastActivityTime',time());
      
        return $next($request);
    }

}