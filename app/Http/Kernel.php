<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            //\Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                 => \App\Http\Middleware\Authenticate::class,
        'auth.basic'           => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'                => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'valida_cv'            => \App\Http\Middleware\ValidaLoginCv::class,
        'valida_req'           => \App\Http\Middleware\ValidarReqUser::class,
        'valida_datos_basicos' => \App\Http\Middleware\ValidaDatosBasicos::class,
        'valida_admin'         => \App\Http\Middleware\ValidarAdminUser::class,
        'valida_reclutamiento_externo' => \App\Http\Middleware\ValidarReclutamientoUser::class,
        'valida_god'           => \App\Http\Middleware\ValidarGodUser::class,
        'exceptions_admin'     => \App\Http\Middleware\ExceptionsAdmin::class,
        'sesion_datos_basicos' => \App\Http\Middleware\SessionTimeoutDatosBasicos::class,
        'sesion_admin'         => \App\Http\Middleware\SessionTimeoutAdmin::class,
        'sesion_reclutamiento_externo' => \App\Http\Middleware\SessionTimeoutReclutamiento::class,
        'sesion_ajax'          => \App\Http\Middleware\SessionTime::class,
        'sesion_req'           => \App\Http\Middleware\SessionTimeoutReq::class,
        'sentinel.auth'        => \App\Http\Middleware\SentinelAuth::class,
        'sentinel.guest'       => \App\Http\Middleware\SentinelGuest::class,
        'sentinel.admin'       => \App\Http\Middleware\SentinelAdminAccess::class,
        'api.token'            => \App\Http\Middleware\CheckBearerToken::class,
        'throttle'             => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signed'               => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'verified'             => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'can'                  => \Illuminate\Auth\Middleware\Authorize::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
       // 'httpCache' => \App\Http\Middleware\HttpCache::class, //precargar paginas
    ];

}
