<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Sentinel;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Metodo encargado de la redireccion a Facebook
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->user();
        //dd($social_user);
        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = User::create([
                'name'   => $social_user->name,
                'email'  => $social_user->email,
                'avatar' => $social_user->avatar_original,
            ]);

            // AGREGAR ROL USUARIO
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($user);

            // Activación de usuario
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);

            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    // Login y redirección
    public function authAndRedirect($user)
    {
        Sentinel::login($user);

        return redirect()->to('/cv/dashboard');
    }
}
