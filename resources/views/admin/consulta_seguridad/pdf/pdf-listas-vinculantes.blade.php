<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> 
    <title>Listas Vinculantes</title>
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

        .divider{ width: 90%; background-color: #722E87; color: #722E87; border: 0; height: .5px; }
        .divider-th{ width: 90%; background-color: #722E87; color: #722E87; border: 0; height: .5px; }

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
                <p class="mt-0" style="font-weight: bold; font-size: 18pt; color: #722E87;">Listas Vinculantes</p>

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
                    - {{ ucfirst($todas_listas['BOLETIN_POLICIA']["ListName"] ? $todas_listas['BOLETIN_POLICIA']["ListName"] : 'BOLETÍN POLICÍA') }}
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
                    - BOLETÍN POLICÍA
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
                    - {{ ucfirst($todas_listas['BOLETIN_PROCURADURIA']["ListName"] ? $todas_listas['BOLETIN_PROCURADURIA']["ListName"] : 'BOLETÍN PROCURADURÍA') }}
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
                    - BOLETÍN PROCURADURÍA
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
                    - DESMOVILIZADOS
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

        {{-- OFAC --}}
        @if($todas_listas['OFAC']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['OFAC']["ListName"] ? $todas_listas['OFAC']["ListName"] : 'OFAC') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['OFAC']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['OFAC']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['OFAC']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['OFAC']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['OFAC']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['OFAC']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['OFAC']["QueryDetail"]["MoreInfo"] ? $todas_listas['OFAC']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['OFAC']["QueryDetail"]["Link"] ? $todas_listas['OFAC']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['OFAC']["QueryDetail"]["Link"] ? $todas_listas['OFAC']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - OFAC
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
                    - {{ ucfirst($todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["ListName"] ? $todas_listas['FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO']["ListName"] : 'FOREIGN TERRORIST ORGANIZATIONS EEUU FTO') }}
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
                    - FOREIGN TERRORIST ORGANIZATIONS EEUU FTO
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

        {{-- ONU --}}
        @if($todas_listas['ONU_RESOLUCION_2023']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['ONU_RESOLUCION_2023']["ListName"] ? $todas_listas['ONU_RESOLUCION_2023']["ListName"] : 'ONU 2023') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["MoreInfo"] ? $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_2023']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - ONU 2023
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

        @if($todas_listas['ONU_RESOLUCION_1988']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['ONU_RESOLUCION_1988']["ListName"] ? $todas_listas['ONU_RESOLUCION_1988']["ListName"] : 'ONU 1988') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["MoreInfo"] ? $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1988']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - ONU 1988
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

        @if($todas_listas['ONU_RESOLUCION_1975']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['ONU_RESOLUCION_1975']["ListName"] ? $todas_listas['ONU_RESOLUCION_1975']["ListName"] : 'ONU 1975') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["MoreInfo"] ? $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1975']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - ONU 1975
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

        @if($todas_listas['ONU_RESOLUCION_1973']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['ONU_RESOLUCION_1973']["ListName"] ? $todas_listas['ONU_RESOLUCION_1973']["ListName"] : 'ONU 1973') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["MoreInfo"] ? $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1973']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - ONU 1973
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

        @if($todas_listas['ONU_RESOLUCION_1970']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['ONU_RESOLUCION_1970']["ListName"] ? $todas_listas['ONU_RESOLUCION_1970']["ListName"] : 'ONU 1970') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["MoreInfo"] ? $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Link"] ? $todas_listas['ONU_RESOLUCION_1970']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - ONU 1970
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

        {{-- NACIONES_UNIDAS --}}
        @if($todas_listas['NACIONES_UNIDAS']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['NACIONES_UNIDAS']["ListName"] ? $todas_listas['NACIONES_UNIDAS']["ListName"] : 'NACIONES UNIDAS') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['NACIONES_UNIDAS']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["MoreInfo"] ? $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Link"] ? $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Link"] ? $todas_listas['NACIONES_UNIDAS']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - NACIONES UNIDAS
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

        {{-- MOST_WANTED_FBI --}}
        @if($todas_listas['MOST_WANTED_FBI']['InRisk'])
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($todas_listas['MOST_WANTED_FBI']["ListName"] ? $todas_listas['MOST_WANTED_FBI']["ListName"] : 'MOST WANTED FBI') }}
                </p>

                <p style="font-size: 11pt; color: #9c9c9c">
                    Información general
                </p>

                <hr align="right" class="divider">

                <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                    <tr>
                        <td>País</td>
                        <td>
                            {{ $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Zone"] ? mb_strtoupper($todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Zone"]) : 'Colombia' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre Completo
                        </td>
                        <td>
                            {{ 
                                $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["FoundName"] ? mb_strtoupper($todas_listas['MOST_WANTED_FBI']["QueryDetail"]["FoundName"]) : 'No se encontró nombre' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número de Identificación
                        </td>
                        <td>
                            {{ $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["FoundIdNumber"] ? $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["FoundIdNumber"] : 'No se encontró número de identificación' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Resultado
                        </td>
                        <td>
                            {{ $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["MoreInfo"] ? $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["MoreInfo"] : 'No se encontró información' }}
                        </td>
                    </tr>
                </table>

                <table width="100%" style="font-size: 10pt; color: #9c9c9c;">
                    <tr>
                        <td>Enlace</td>
                    </tr>
                    <tr>
                        <td>
                            <a target="_blank" href="{{ $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Link"] ? $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Link"] : '#' }}">

                                {{ substr($todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Link"] ? $todas_listas['MOST_WANTED_FBI']["QueryDetail"]["Link"] : 'No se encontró enlace', 0, 90) }}
                                ...
                            </a>
                        </td>
                    </tr>
                </table>
            </section>
        @else
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - MOST WANTED FBI
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

        {{-- PEPS --}}
        <section>
            <div class="text-center mt-1">
                <h5>{{ $convert[2]["GroupNameList"] ? $convert[2]["GroupNameList"] : 'PEPS - PERSONAS POLITICAMENTE Y PUBLICAMENTE EXPUESTAS' }}</h5>
            </div>
        </section>

        @for ($i = 0; $i < count($convert[2]["SearchList"]); $i++)
            <section class="mt-1">
                <p style="font-size: 12pt;">
                    - {{ ucfirst($convert[2]["SearchList"][$i]["ListName"]) }}
                </p>

                @if (!empty($convert[2]["SearchList"][$i]["QueryDetail"]["FoundName"]) || !empty($convert[2]["SearchList"][$i]["QueryDetail"]["FoundIdNumber"]))
                    <p style="font-size: 11pt; color: #9c9c9c">
                        Información general
                    </p>

                    <hr align="right" class="divider">

                    <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                        <tr>
                            <td>País</td>
                            <td>
                                {{ mb_strtoupper($convert[2]["SearchList"][$i]["QueryDetail"]["Zone"]) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nombre Completo
                            </td>
                            <td>
                                {{ 
                                    mb_strtoupper($convert[2]["SearchList"][$i]["QueryDetail"]["FoundName"])
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Número de Identificación
                            </td>
                            <td>
                                {{ $convert[2]["SearchList"][$i]["QueryDetail"]["FoundIdNumber"] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Resultado
                            </td>
                            <td>
                                <?php
                                    $StringGet = $convert[2]["SearchList"][$i]["QueryDetail"]["MoreInfo"];
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
                                <a target="_blank" href="{{ $convert[2]["SearchList"][$i]["QueryDetail"]["Link"] }}">

                                    {{ substr($convert[2]["SearchList"][$i]["QueryDetail"]["Link"], 0, 90) }}
                                    ...
                                </a>
                            </td>
                        </tr>
                    </table>
                @else
                    <hr align="right" class="divider">
    
                    <table width="100%" style="font-size: 10pt; color: #9c9c9c">
                        <tr>
                            <td>
                                Resultado
                            </td>
                            <td>
                                Registro no encontrado
                            </td>
                        </tr>
                    </table>
                @endif
            </section>
        @endfor
    </main>

    <footer>
        <h5>T3RS</h5>
    </footer>
</body>
</html>