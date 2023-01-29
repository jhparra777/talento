<?php

namespace App\Facade;


use Illuminate\Support\Facades\Facade;  
/**
 * @see \Illuminate\Foundation\Application
 */
class FuncionesGlobalesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FuncionesGlobales';
    }
}
