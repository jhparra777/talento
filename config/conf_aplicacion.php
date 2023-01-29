<?php

return [
    'URL_PRUEBAS_CURL'                            => "https://www.tucompetenciahumana.com/service/verificacion",
    'COD_TIPO_FUENTE_CANDIDATOS_ENVIADOS_CLIENTE' => 14,
    'C_ACTIVO'                                    => '5',
    'C_RECLUTAMIENTO'                             => '6',
    'C_EN_PROCESO_SELECCION'                      => '7',
    'C_EVALUACION_DEL_CLIENTE'                    => '8',
    'C_EVALUACIÓN_DE_SEGURIDAD'                   => '9',
    'C_SEGURIDAD'                                 => '10',
    'C_EN_PROCESO_CONTRATACION'                   => '11',
    'C_CONTRATADO'                                => '12',
    'C_INACTIVO'                                  => '13',
    'C_QUITAR'                                    => '14',
    'C_APROBADO_CLIENTE'                          => '15',
    'C_TERMINADO'                                 => '16',
    'C_ELIMINADO'                                 => '17',
    'C_VENTA_PERDIDA'                             => '18',
    'C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'          => '19',
    'C_PENDIENTE_DE_APROBACIÓN'                   => '20',
    'C_NO_APROBADO'                               => '21',
    'C_NO_EFECTIVO'                               => '22',
    'C_TRANSFERIDO'                               => '23',
    'C_CONTRATACION_CANCELADA'                    => '24',
    'C_EN_EXAMENES_MEDICOS'                       => '25',
    'C_BAJA_VOLUNTARIA'                           => '26',
    'C_CLIENTE'                                   => '1',
    'C_SOLUCIONES'                                => '2',
    'ENTREVISTA_APTO'                             => '1',
    'ENVIADO_ENTREVISTA'                          => 'ENVIO_ENTREVISTA',
    'C_SOPORTE_APROBACION_CLIENTE'                => '31', //Desarrollo es 31
//cambiar para guardar en bd
    "SELECT_REFERENCIACION"                       => [
        "DIFICULTADES"    => ["1" => "- Seleccione ",
     /*2*/      "REACCIONA DE MANERA TRANQUILA"                       => "REACCIONA DE MANERA TRANQUILA",
     
     /*3*/          "REACCIONA CON NERVIOS"                       => "REACCIONA CON NERVIOS",
       
        /*4*/  "REACCIONA DE MANERA IMPACIENTE"                       => "REACCIONA DE MANERA IMPACIENTE",
           
         /*5*/ "REACCIONA DE MANERA RACIONAL"                       => "REACCIONA DE MANERA RACIONAL",
           
         /*6*/ "REACCIONA DE FORMA IMPULSIVA"                       => "REACCIONA DE FORMA IMPULSIVA",
           
          /*7*/"REACCIONA DE MANERA NORMAL"                       => "REACCIONA DE MANERA NORMAL",
            
           /*8*/"REACCIONA DIALOGANDO"                       => "REACCIONA DIALOGANDO",
          
           /*9*/    "REACCIONA RESPONSABLEMENTE"                       => "REACCIONA RESPONSABLEMENTE",
           
            /*10*/  "REACCIONA DE MANERA VIOLENTA"                      => "REACCIONA DE MANERA VIOLENTA",
            
             /*55*/ "NO APLICA"                      => "NO APLICA"],

        
        "MEJORAS"         => ["1" => "- Seleccione -",
         /*11*/   "ES UNA PERSONA RESPONSABLE"                      => "ES UNA PERSONA RESPONSABLE",
          
        /*12*/  "ES UNA PERSONA HONESTA"                      => "ES UNA PERSONA HONESTA",
        
        /*13*/   "ES UNA PERSONA TRABAJADORA"                      => "ES UNA PERSONA TRABAJADORA",
        
        /*14*/    "ES UNA PERSONA PUNTUAL"                      => "ES UNA PERSONA PUNTUAL",
            
        /*15*/    "TIENE BUENAS RELACIONES"                      => "TIENE BUENAS RELACIONES PERSONALES",
        
        /*16*/    "ES UNA PERSONA INTELIGENTE"                      => "ES UNA PERSONA INTELIGENTE",
            
        /*17*/    "ES UNA PERSONA MADURA Y SEGURA DE SI MISMA"                      => "ES UNA PERSONA MADURA Y SEGURA DE SI MISMA",
            
        /*18*/    "ES UNA PERSONA NOBLE"                      => "ES UNA PERSONA NOBLE",
            
        /*19*/    "ES UNA PERSONA PACIENTE"                      => "ES UNA PERSONA PACIENTE",
        /*55*/    "NO APLICA"                      => "NO APLICA"],
        

        "DESACUERDO"      => ["1" => "- Seleccione -",
         /*20*/ "LO MANIFIESTA DE MALGENIO"                      => "LO MANIFIESTA DE MALGENIO",
       
       /*21*/"LO MANIFIESTA IRACUNDO"                      => "LO MANIFIESTA IRACUNDO",
           
        /*22*/"LO MANIFIESTA PASIVAMENTE"                      => "LO MANIFIESTA PASIVAMENTE",
            
        /*23*/"LO MANIFIESTA DE MANERA POLEMICA"                      => "LO MANIFIESTA DE MANERA POLEMICA",
           
        /*24*/"LO MANIFIESTA TRANQUILAMENTE"                      => "LO MANIFIESTA TRANQUILAMENTE",
            
        /*25*/     "LO MANIFIESTA DIALOGANDO"                      => "LO MANIFIESTA DIALOGANDO",
            
        /*26*/     "LO MANIFIESTA DE MANERA RACIONAL"                      => "LO MANIFIESTA DE MANERA RACIONAL",
            
        /*55*/     "NO APLICA"                      => "NO APLICA"],

        
        "MEJORAR"         => [
            "1"  => "- Seleccione -",
        /*27*/"CONSIDERA QUE NO DEBE MEJORAR EN NADA ESPECIAL" => "CONSIDERA QUE NO DEBE MEJORAR EN NADA ESPECIAL",
        
        /*28*/"DEBE MEJORAR EL MAL GENIO" => "DEBE MEJORAR EL MAL GENIO",
        
        /*29*/"DEBE MEJORAR LA PUNTUALIDAD" => "DEBE MEJORAR LA PUNTUALIDAD",
        
        /*30*/"DEBE MEJORAR LA PRESENTACION PERSONAL" => "DEBE MEJORAR LA PRESENTACION PERSONAL",
        
        /*31*/"DEBE MEJORAR LA COMUNICACION" => "DEBE MEJORAR LA COMUNICACION",
        
        /*32*/"DEBE MEJORAR LA RESPONSABILIDAD" => "DEBE MEJORAR LA RESPONSABILIDAD",
        
        /*33*/"LE HACE FALTA COMPROMISO" => "LE HACE FALTA COMPROMISO",
        
        /*34*/"DEBE MEJORAR LA EFICIENCIA" => "DEBE MEJORAR LA EFICIENCIA",
        
        /*35*/"DEBE MEJORAR SU FORMACION ACADEMICA" => "DEBE MEJORAR SU FORMACION ACADEMICA",
        
        /*55*/"NO APLICA" => "NO APLICA",
        ],

        "INTERPERSONALES" => [
            "1"  => "- Seleccione -",
        /*36*/"UNA PERSONA ABIERTA" => "UNA PERSONA ABIERTA",
        /*37*/"UNA PERSONA AMIGABLE" => "UNA PERSONA AMIGABLE",
        /*38*/"UNA PERSONA SINCERA" => "UNA PERSONA SINCERA",
        /*39*/"UNA PERSONA EXPRESIVA" => "UNA PERSONA EXPRESIVA",
        /*40*/"UNA PERSONA ESPONTANEA" => "UNA PERSONA ESPONTANEA",
        /*41*/"UNA PERSONA CERRADA" => "UNA PERSONA CERRADA",
        /*42*/"UNA PERSONA CARI¥OSA" => "UNA PERSONA CARI¥OSA",
        /*55*/"NO APLICA" => "NO APLICA",
        ],

    ],
    "DIVISION_GEREN_CODIGO"                       => 2,
    "EMP_DIVISION_GERENCIA"                       => 1,
    "ID_PRUEBA_TENDENCIA"                         => 40, //Valida prueba de TENDENCIA
    "PROBLEMA_SEGURIDAD"                          => 4, //Valida la seguridad del candidato

    "CATEGORIA_CONFIDENCIALES"                    => 3, //Categoria de tipo de documento confidencial
    "CATEGORIA_POST_CONTRATACION"                 => 4, //Categoria de tipo de documento contratacion

    //CIUDAD TRABAJO
    "SEDES_MUNICIPIO"                             => [
        "170~5~59"   => "ARMENIA",
        "170~8~1"    => "BARRANQUILLA",
        "170~11~1"   => "BOGOTA",
        "170~68~1"   => "BUCARAMANGA",
        "170~76~109" => "BUENAVENTURA",
        "170~76~111" => "BUGA",
        "170~13~1"   => "CARTAGENA",
        "170~76~1"   => "CALI",
        "170~73~1"   => "IBAGUE",
        "170~17~1"   => "MANIZALES",
        "170~5~1"    => "MEDELLIN",
        "170~23~1"   => "MONTERIA",
        "170~41~1"   => "NEIVA",
        "170~52~1"   => "PASTO",
        "170~66~1"   => "PEREIRA",
        "170~15~1"   => "TUNJA",
        "170~47~1"   => "SANTA MARTA",
        "170~19~698" => "SANTANDER DE QUILICHAO",
        "170~20~1"   => "VALLEDUPAR",
        "170~50~1"   => "VILLAVICENCIO",
    ],

    //Usuarios de selección en el modulo de recepción
    "SELECCION_REGIONAL"                          => 15,
    "LIDER_SELECCION"                             => 42,
    "COORDINADOR_SELECCION"                       => 81,
    "SELECCION"                                   => 83,
    "REFERENCIACION"                              => 63,
    "SUPER_ADMINISTRADOR"                         => 13,
    "VALIDACION"                                  => 43,
    "VINCULACION"                                 => 21,

    //Estado Cliente (ACT) (rute "editar-user")
    "ESTADO_CLIENTE"                              => "ACT",

    // Formato exportación excel
    "FORMATO_REPORTE"                             => "xls",
    "DIAS_DEFECTO_REQUERIMIENTO"=>12,
    "VACANTES_DEFECTO"=>1,
    "DIAS_PRESENTACION_CAND_DEFECTO"=>3,
    "CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE"=>1,

    //Variable spresentes en el archivo ENV para configuracion del sitio
    "VARIABLES_ENTORNO"=>[
        'CHAT-API'=>[
            "instancia"=>env("CHAT_API_INSTANCIA"),
            "token"=>env("CHAT_API_TOKEN")
        ],
        'GO4CLIENTS'=>[
            "apiKey"=>env("GO4CLIENTS_API_KEY"),
            "apiSecret"=>env("GO4CLIENTS_API_SECRET"),
            "llamadas"=>env("GO4CLIENTS_LLAMADA","5fd2989e33d5ce00090a0158"),
            "sms"=>env("GO4CLIENTS_TEXTO","5e6becdf01201800075a76d0")
        ],
        "SITIO"=>env("SITIO","produccion"),
        "COMPANY_NAME"=>env("COMPANY_NAME","Desarrollo"),
        "INDICATIVO"=>env("INDICATIVO","57"),
        "VERIFY_EMAIL_KEY"=>env("VERIFY_EMAIL_KEY"),
        "INSTANCIA_API_ID"=>env("INSTANCIA_API_ID")

    ]

];
