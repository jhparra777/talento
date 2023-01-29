<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\User;

class CheckBearerToken
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
        $string_header_token = $request->header('Authorization');
        //dd($string_header_token);
        if(!$string_header_token){
                return response()->json([
                          'error' => true,
                          'mensaje' => 'Token inválido'
                       ], 401);
        }else{
            $token_array = explode(" ", $string_header_token);
            $token = trim($token_array[1]);
            if(!$token){
               return response()->json([
                  'error' => true,
                  'mensaje' => 'No existe un token.'
               ], 401);
            }else{
                //dd($token);
                $user = User::where('api_token', $token)->first();
                if($user==null){
                    return response()->json([
                        'error' => true,
                        'mensaje' => 'Token inválido.'
                     ], 401);
                }
                $request->merge(['user'=>$user]);
            }
        }
            
        return $next($request);
    }
}
