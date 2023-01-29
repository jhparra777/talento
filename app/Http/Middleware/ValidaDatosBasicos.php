<?php

namespace App\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\DatosBasicos;

class ValidaDatosBasicos {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $user = Sentinel::getUser();
        $datos_basicos = DatosBasicos::where("user_id", $user->id)->first();
        $name_ruta = $request->route()->getName();
        if ($datos_basicos == null && $name_ruta != "cv.termina_registro") {
            return redirect()->route("cv.termina_registro");
        }



        return $next($request);
    }

}
