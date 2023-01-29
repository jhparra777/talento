<?php

namespace App\Helpers;

use App\Models\PlantillaCorreo;
use App\Models\PlantillaCorreoConfiguracion;
use App\Models\Sitio;

class triMailGenerator
{
    public static function generateMail(int $mailTemplate, int $mailConfiguration, string $mailTitle, string $mailBody, array $mailButton = [], int $mailUser = null, array $mailAditionalTemplate = [])
    {
    	switch ($mailTemplate) {
    		case 1:
    			$view = 'mail_template.template_1.main';
    			break;

    		case 2:
    			$view = 'mail_template.template_2.main';
    			break;

    		case 3:
    			$view = 'mail_template.template_3.main';
    			break;
    		
    		default:
    			$view = 'mail_template.template_1.main';
    			break;
    	}

    	//Search configuration
    	$configurationTemplate = PlantillaCorreoConfiguracion::where('id', $mailConfiguration)->first();
    	$clientSite = Sitio::first();

    	//Valida si se envío información del botón
    	if (!empty($mailButton)) {
    		$mailButton = (object) $mailButton;
    	}

    	return (object) [
    		'view' => $view,
    		'data' => (object) [
    			'configurationTemplate' => $configurationTemplate,
    			'clientSite' => $clientSite,
    			'mailTitle' => $mailTitle,
    			'mailBody' => $mailBody,
    			'mailButton' => $mailButton,
                'userId' => $mailUser,
                'mailAditionalTemplate' => $mailAditionalTemplate
    		]
    	];
    }
}
