<?php

namespace App\Http\Middleware;

use Closure;

class ExceptionsAdmin
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
        dd("asd");
        try {

        } catch (MethodNotAllowedHttpException $exc) {
            return redirect()->route("admin.index");
        }

        return $next($request);
    }
}
