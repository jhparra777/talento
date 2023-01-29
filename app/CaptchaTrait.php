<?php

namespace App;

use ReCaptcha\ReCaptcha;

trait CaptchaTrait {
 
    public function captchaCheck($value = null)
    {
        if($value){
 
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $secret   = env('RECAPTCHA_SECRET');
 
            $recaptcha = new ReCaptcha($secret);
 
            $resp = $recaptcha->verify($value, $remoteip);
            
            if ($resp->isSuccess()) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}