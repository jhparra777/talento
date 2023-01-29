<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Jobs\FuncionesGlobales as Funciones;
use Illuminate\Support\Facades\View;
use Validator;
use Input;
use App\CaptchaTrait;
use App\Models\PoliticasPrivacidad;
use App\Models\TipoPolitica;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider {


    use CaptchaTrait;
    
    public function boot() {

        \Validator::extend('captcha', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && $this->captchaCheck($value) == true)
            {
                return true;
            }
            return false;
        });

        // Activar la paginacion para las Collection directamente.
        // Modo de empleo: $collect->paginate(X); donde X es el numero de registros por pagina
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', 
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                    ->setPath('');
            });
        }

        Validator::extend('greater_than', function($attribute, $value, $params, $validator){

            $other = Input::get($params[0]);
            return intval($value) > intval($other);
        });

        /*Validator::replacer('greater_than', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , 'The '. $attribute .' must be greater than the ' .$params[0]);
        });*/
        $funciones= new Funciones;
        $sitio=$funciones->sitio();
        $sitioModulo=$funciones->sitioModulo();

        $politica = PoliticasPrivacidad::orderBy('id', 'DESC')->first();

        $tipos_politicas = TipoPolitica::where('active', 1)->get();

        
        View::share(["sitio" => $sitio, "sitioModulo" => $sitioModulo, "politica" => $politica, "tipos_politicas" => $tipos_politicas]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
