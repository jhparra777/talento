<?php

namespace App\Facade;


use Illuminate\Support\Facades\Facade;  
/**
 * @see \Illuminate\Foundation\Application
 */
class QueryAuditoria extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'query_auditoria';
    }
}
