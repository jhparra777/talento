<?php

namespace App\Helpers;

class triRoute
{
    public static function validateOR(string $instance)
    {
    	$base_route = route('home');
        $instance_route = config("host_validation.$instance");

        if ($base_route == $instance_route || $base_route === $instance_route) {
            return true;
        }

        return false;
    }
}
