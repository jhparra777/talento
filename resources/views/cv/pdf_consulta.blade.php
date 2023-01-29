<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> 
    <title>Consulta de seguridad</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
            font-family: 'Montserrat', sans-serif;
        }

        .text-center{ text-align: center; }
        .text-left{ text-align: left; }
        .text-right{ text-align: right; }
        .text-justify{ text-align: justify; }

        .table{ border-collapse:separate; }

        .font-size-10{ font-size: 10pt; }
        .font-size-11{ font-size: 11pt; }
        .font-size-12{ font-size: 12pt; }
        .font-size-14{ font-size: 14pt; }

        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .ml-0{ margin-left: 0; }
        .ml-1{ margin-left: 1rem; }
        .ml-2{ margin-left: 2rem; }
        .ml-3{ margin-left: 3rem; }
        .ml-4{ margin-left: 4rem; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }

        .no-list{ list-style: none; }

        .br-05{ border-radius: 5px; }

        .fw-600{ font-weight: 600; }
        .fw-700{ font-weight: 700; }

        .page-break{ page-break-after: always; }

        .profile-picture{
            padding: .25rem;
            width: 100px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
        }

        .divider{ width: 90%; background-color: #919191; color: #919191; border: 0; height: .5px; }
        .divider-th{ width: 90%; background-color: #919191; color: #919191; border: 0; height: .5px; }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /*background-color: #2a0927;*/
            color: #d6d6d6;
            text-align: center;
            line-height: 20px;
        }
    </style>
</head>
<body>
    <main>
        {{-- Header logo y fecha --}}
        <section>
            <table width="100%">
                <tr>
                    <td>
                        {{-- <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-src/tri-new-logo-horizontal-letter.png" alt="T3RS" width="100"> --}}
                        
                        <img src="{{ $img_base64 }}" alt="T3RS" width="100">
                    </td>
                    <td>
                        <p style="font-size: 8pt; text-align: right; color: #ababab; font-family: 'Montserrat', sans-serif;">
                            Fecha Última Consulta: {{ $fecha_consulta }}
                        </p>
                    </td>
                </tr>
            </table>
        </section>

        {{-- Factor y datos usuario --}}
        <section style="text-align: center;">
            <div class="mt-2" style="border: solid 1px #e3e3e3; border-radius: .5rem; padding: .5rem;">
                <p class="mt-0" style="font-weight: bold; font-size: 18pt; color: #8a8a8a;">Consulta Seguridad</p>

                <div class="m-auto" style="
                    width: 70px;
                    height: 70px;

                    padding: 8px;

                    border-radius: 45px;

                    background-color: white;

                    /* #2ecc71 #e74c3c #f1c40f */

                    @if($factor_seguridad <= 50)
                        border: solid 3px #e74c3c;
                    @elseif($factor_seguridad > 50 && $factor_seguridad <= 99)
                        border: solid 3px #f1c40f;
                    @elseif($factor_seguridad == 100)
                        border: solid 3px #2ecc71;
                    @endif

                    @if($factor_seguridad <= 50)
                        color: #e74c3c;
                    @elseif($factor_seguridad > 50 && $factor_seguridad <= 99)
                        color: #f1c40f;
                    @elseif($factor_seguridad == 100)
                        color: #2ecc71;
                    @endif

                    text-align: center;

                    font-family: 'Montserrat', sans-serif;
                    font-size: 16pt;
                    font-weight: 700"
                >
                    <p>
                        {{-- 
                            @if($factor_seguridad <= 50)
                                {{ $factor_seguridad }}
                            @elseif($factor_seguridad > 50 && $factor_seguridad <= 99)
                                {{ $factor_seguridad }}
                            @elseif($factor_seguridad === 100)
                                {{ $factor_seguridad }}
                            @endif 
                        --}}

                        {{ $factor_seguridad }}
                    </p>
                </div>

                <table width="100%" class="mt-2 text-center">
                    <tr>
                        <td width="25%">
                            <p class="mt-0" style="font-size: 10pt; font-weight: bold;">NOMBRE COMPLETO</p>
                            <p style="margin-top: -.5rem; font-size: 10pt;">
                                @if(isset($datos_basicos))
                                    {{ ucwords(mb_strtolower($datos_basicos->nombres)) }} 
                                    {{ ucwords(mb_strtolower($datos_basicos->primer_apellido)) }} 
                                    {{ ucwords(mb_strtolower($datos_basicos->segundo_apellido)) }}
                                @endif
                            </p>
                        </td>
                        <td></td>
                        <td width="25%">
                            <p class="mt-0" style="font-size: 10pt; font-weight: bold;">CIUDAD RESIDENCIA</p>
                            <p style="margin-top: -.5rem; font-size: 10pt;">
                                @if(isset($datos_basicos))
                                    @if ($datos_basicos->ciudad_residencia != '')
                                        {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}
                                    @endif
                                @endif
                            </p>
                        </td>
                        <td></td>
                        <td width="20%">
                            <p class="mt-0" style="font-size: 10pt; font-weight: bold;">REQUERIMIENTO</p>
                            <p style="margin-top: -.5rem; font-size: 10pt;">
                                @if(isset($req_id))
                                    REQ. {{ $req_id }}
                                @endif
                            </p>
                        </td>
                        <td></td>
                        <td width="30%">
                            <p class="mt-0" style="font-size: 10pt; font-weight: bold;">CONSULTADO POR</p>
                            <p style="margin-top: -.5rem; font-size: 10pt;">
                                {{ $solicito_consulta }}
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <section>
            <div class="text-center mt-1">
                <h5>{{ $convert[1]["GroupNameList"] ? $convert[1]["GroupNameList"] : 'LISTAS RESTRICTIVAS, SANCIONES NACIONALES E INTERNACIONALES' }}</h5>
            </div>
        </section>

        {{-- Procuradoría Nacional --}}
        @if ($convert[1]["SearchList"][0]["QueryDetail"]["FoundName"] != null && $convert[1]["SearchList"][0]["QueryDetail"]["FoundIdNumber"] != null)
            <section>
                <p style="font-size: 12pt;">
                    - {{ ucfirst($convert[1]["SearchList"][0]["ListName"] ? $convert[1]["SearchList"][0]["ListName"] : 'Procuraduría General de la Nación') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $convert[1]["SearchList"][0]["QueryDetail"]["Zone"] ? mb_strtoupper($convert[1]["SearchList"][0]["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ $convert[1]["SearchList"][0]["QueryDetail"]["FoundName"] ? mb_strtoupper($convert[1]["SearchList"][0]["QueryDetail"]["FoundName"]) : 'No se encontró nombre' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $convert[1]["SearchList"][0]["QueryDetail"]["FoundIdNumber"] ? $convert[1]["SearchList"][0]["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            <?php
                                $StringGet = $convert[1]["SearchList"][0]["QueryDetail"]["MoreInfo"];
                                $StringSearch = "/ANTECEDENTES PENALES/";
                                $StrinSearch_2 = "/ANTECEDENTES DISCIPLINARIOS/";

                                if(preg_match($StringSearch, $StringGet)) {
                                    //tiene antecedentes
                                    $resultString = "ANTECEDENTES PENALES";
                                }elseif(preg_match($StrinSearch_2, $StringGet)) {
                                    //tiene antecedentes
                                    $resultString = "ANTECEDENTES DISCIPLINARIOS";
                                }else {
                                    //no tiene antecedentes
                                    $resultString = "El ciudadano no presenta antecedentes";
                                }
                            ?>

                            {{ mb_strtoupper($resultString) }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $convert[1]['SearchList'][0]['QueryDetail']['Link'] ? $convert[1]['SearchList'][0]['QueryDetail']['Link'] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes' }}">

                                {{ substr($convert[1]["SearchList"][0]["QueryDetail"]["Link"] ? $convert[1]["SearchList"][0]["QueryDetail"]["Link"] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section>
                <p style="font-size: 12pt;">
                    - Procuraduría General de la Nación
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- RAMA JUDICIAL DEL PODER PUBLICO --}}
        @if($todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["ListName"] ? $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["ListName"] : 'RAMA JUDICIAL DEL PODER PUBLICO') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["MoreInfo"] ? $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Link"] ? $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Link"] : '#' }}">
                                {{ substr($todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Link"] ? $todas_listas['RAMA_JUDICIAL_DEL_PODER_PUBLICO']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Rama Judicial del Poder Público
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- BOLETIN POLICIA --}}
        @if($todas_listas['BOLETIN_POLICIA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['BOLETIN_POLICIA']["ListName"] ? $todas_listas['BOLETIN_POLICIA']["ListName"] : 'BOLETIN POLICIA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['BOLETIN_POLICIA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["MoreInfo"] ? $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_POLICIA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Boletín Policía
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- BOLETIN FISCALIA --}}
        @if($todas_listas['BOLETIN_FISCALIA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['BOLETIN_FISCALIA']["ListName"] ? $todas_listas['BOLETIN_FISCALIA']["ListName"] : 'BOLETIN FISCALIA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["MoreInfo"] ? $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_FISCALIA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Boletín Fiscalía
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- BOLETIN PROCURADURIA --}}
        @if($todas_listas['BOLETIN_PROCURADURIA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['BOLETIN_PROCURADURIA']["ListName"] ? $todas_listas['BOLETIN_PROCURADURIA']["ListName"] : 'BOLETIN PROCURADURIA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["MoreInfo"] ? $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_PROCURADURIA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Boletín Procuraduría
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- DESMOVILIZADOS --}}
        @if($todas_listas['DESMOVILIZADOS']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['DESMOVILIZADOS']["ListName"] ? $todas_listas['DESMOVILIZADOS']["ListName"] : 'DESMOVILIZADOS') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['DESMOVILIZADOS']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['DESMOVILIZADOS']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['DESMOVILIZADOS']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['DESMOVILIZADOS']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['DESMOVILIZADOS']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['DESMOVILIZADOS']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['DESMOVILIZADOS']["QueryDetail"]["MoreInfo"] ? $todas_listas['DESMOVILIZADOS']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['DESMOVILIZADOS']["QueryDetail"]["Link"] ? $todas_listas['DESMOVILIZADOS']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['DESMOVILIZADOS']["QueryDetail"]["Link"] ? $todas_listas['DESMOVILIZADOS']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Desmovilizados
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- BOLETIN PRESIDENCIA --}}
        @if($todas_listas['BOLETIN_PRESIDENCIA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['BOLETIN_PRESIDENCIA']["ListName"] ? $todas_listas['BOLETIN_PRESIDENCIA']["ListName"] : 'BOLETIN PRESIDENCIA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["MoreInfo"] ? $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_PRESIDENCIA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Boletín Presidencia
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- CONSEJO SUPERIOR DE LA JUDICATURA --}}
        @if($todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["ListName"] ? $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["ListName"] : 'CONSEJO SUPERIOR DE LA JUDICATURA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["MoreInfo"] ? $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Link"] ? $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Link"] : '#' }}">
                                {{ substr($todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Link"] ? $todas_listas['CONSEJO_SUPERIOR_DE_LA_JUDICATURA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Consejo Superior de la Judicatura
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- BOLETIN DEA --}}
        @if($todas_listas['BOLETIN_DEA']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['BOLETIN_DEA']["ListName"] ? $todas_listas['BOLETIN_DEA']["ListName"] : 'BOLETIN DEA') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['BOLETIN_DEA']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['BOLETIN_DEA']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['BOLETIN_DEA']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['BOLETIN_DEA']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_DEA']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['BOLETIN_DEA']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['BOLETIN_DEA']["QueryDetail"]["MoreInfo"] ? $todas_listas['BOLETIN_DEA']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['BOLETIN_DEA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_DEA']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['BOLETIN_DEA']["QueryDetail"]["Link"] ? $todas_listas['BOLETIN_DEA']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Boletín DEA
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- INTERPOL --}}
        @if($todas_listas['INTERPOL']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['INTERPOL']["ListName"] ? $todas_listas['INTERPOL']["ListName"] : 'INTERPOL') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['INTERPOL']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['INTERPOL']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['INTERPOL']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['INTERPOL']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['INTERPOL']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['INTERPOL']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['INTERPOL']["QueryDetail"]["MoreInfo"] ? $todas_listas['INTERPOL']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['INTERPOL']["QueryDetail"]["Link"] ? $todas_listas['INTERPOL']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['INTERPOL']["QueryDetail"]["Link"] ? $todas_listas['INTERPOL']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - INTERPOL
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO - Organizaciones Terroristas Extranjeras --}}
        @if($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["ListName"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["ListName"] : 'Organizaciones Terroristas Extranjeras') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["MoreInfo"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Link"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Link"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Organizaciones Terroristas Extranjeras
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- MEDIOS DE COMUNICACIÓN --}}
        @if($todas_listas['MEDIOS_DE_COMUNICACIÓN']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['MEDIOS_DE_COMUNICACIÓN']["ListName"] ? $todas_listas['MEDIOS_DE_COMUNICACIÓN']["ListName"] : 'MEDIOS DE COMUNICACIÓN') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["MoreInfo"] ? $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Link"] ? $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Link"] : '#' }}">
                                {{ substr($todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Link"] ? $todas_listas['MEDIOS_DE_COMUNICACIÓN']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Medios de Comunicación
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- PEPS --}}
        <section>
            <div class="text-center mt-1">
                <h5>{{ $convert[2]["GroupNameList"] ? $convert[2]["GroupNameList"] : 'PEPS - PERSONAS POLITICAMENTE Y PUBLICAMENTE EXPUESTAS' }}</h5>
            </div>
        </section>

        {{-- FUERZAS MILITARES --}}
        @if($convert[2]["SearchList"][3]["QueryDetail"]["FoundName"] != null && $convert[2]["SearchList"][3]["QueryDetail"]["FoundIdNumber"] != null)
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($convert[2]["SearchList"][3]["ListName"] ? $convert[2]["SearchList"][3]["ListName"] : 'FUERZAS MILITARES') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $convert[2]["SearchList"][3]["QueryDetail"]["Zone"] ? mb_strtoupper($convert[2]["SearchList"][3]["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $convert[2]["SearchList"][3]["QueryDetail"]["FoundName"] ? mb_strtoupper($convert[2]["SearchList"][3]["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $convert[2]["SearchList"][3]["QueryDetail"]["FoundIdNumber"] ? $convert[2]["SearchList"][3]["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            <?php
                                $StringGet = $convert[2]["SearchList"][3]["QueryDetail"]["MoreInfo"];
                                $StringSearch = "/ANTECEDENTES PENALES/";

                                if(preg_match($StringSearch, $StringGet)) {
                                    //tiene antecedentes
                                    $resultString = "ANTECEDENTES PENALES";
                                }else {
                                    //no tiene antecedentes
                                    $resultString = "El ciudadano no presenta antecedentes";
                                }
                            ?>

                            {{ mb_strtoupper($resultString) }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $convert[2]["SearchList"][3]["QueryDetail"]["Link"] ? $convert[2]["SearchList"][3]["QueryDetail"]["Link"] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes' }}">

                                {{ substr($convert[2]["SearchList"][3]["QueryDetail"]["Link"] ? $convert[2]["SearchList"][3]["QueryDetail"]["Link"] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Fuerzas Militares
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif

        {{-- CORTE CONSTITUCIONAL --}}
        @if($convert[2]["SearchList"][14]["QueryDetail"]["FoundName"] != null && $convert[2]["SearchList"][14]["QueryDetail"]["FoundIdNumber"] != null)
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($convert[2]["SearchList"][14]["ListName"] ? $convert[2]["SearchList"][14]["ListName"] : 'CORTE CONSTITUCIONAL') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $convert[2]["SearchList"][14]["QueryDetail"]["Zone"] ? mb_strtoupper($convert[2]["SearchList"][14]["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $convert[2]["SearchList"][14]["QueryDetail"]["FoundName"] ? mb_strtoupper($convert[2]["SearchList"][14]["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $convert[2]["SearchList"][14]["QueryDetail"]["FoundIdNumber"] ? $convert[2]["SearchList"][14]["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            <?php
                                $StringGet = $convert[2]["SearchList"][14]["QueryDetail"]["MoreInfo"];
                                $StringSearch = "/ANTECEDENTES PENALES/";

                                if(preg_match($StringSearch, $StringGet)) {
                                    //tiene antecedentes
                                    $resultString = "ANTECEDENTES PENALES";
                                }else {
                                    //no tiene antecedentes
                                    $resultString = "El ciudadano no presenta antecedentes";
                                }
                            ?>

                            {{ mb_strtoupper($resultString) }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $convert[2]["SearchList"][14]["QueryDetail"]["Link"] ? $convert[2]["SearchList"][14]["QueryDetail"]["Link"] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes' }}">

                                {{ substr($convert[2]["SearchList"][14]["QueryDetail"]["Link"] ? $convert[2]["SearchList"][14]["QueryDetail"]["Link"] : 'https://www.procuraduria.gov.co/portal/index.jsp?option=co.gov.pgn.portal.frontend.component.pagefactory.AntecedentesComponentPageFactory&action=consultar_antecedentes', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - Corte Constitucional
                </p>
                
                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            No se encontraron registros en esta lista
                        </td>
                    </tr>
                </table>
            </section>
        @endif
    </main>

    <footer>
        <h5>T3RS</h5>
    </footer>
</body>
</html>