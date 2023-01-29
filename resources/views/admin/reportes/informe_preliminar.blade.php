<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Informe Preliminar - T3RS
        </title>
        <style type="text/css">
            @page { margin: 50px 70px; }
            .page-break {
                page-break-after: always;
            }

            table {
                width: 100%;
            }
            .border{
                border: solid 1px;
            }

            body {
                font-family: 'Bank Gothic', Bank, serif;
                font-size: 14px;
                background-color: #FFFFFF;
            }

            footer{
                position: fixed;
                bottom: 0;
            }
            
            td {
               /* border: solid 1px;*/
                text-align: center;
            }
            .td-azul {
                background-color: #377cfc;
            }
            .td-gris {
                background-color: #c2c2c2
            }
            .center-img {
                margin:0 auto;
                text-align:center;
            }   
        </style>
    </head>
    <body>

        <table>
            <tr>
                <td colspan="12" class="center" width="100%" height="100px">
                    @if(route("home")!="https://demo.t3rsc.co")

                    @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="150">
                        @else
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    @else
                        <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                    @endif

                @else

                  @if($logo != "")
                   <img style="max-width: 200px" src="{{ url('configuracion_sitio')}}/{!!$logo!!}">
                  @else
                   <img style="max-width: 200px" src="{{url('img/logo.png')}}" >
                  
                  @endif

                @endif
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    <h3>
                        CLIENTE {{ $cliente->nombre }}, NÚMERO DE @if(route("home")!="https://gpc.t3rsc.co") REQUERIMIENTO @else PROCESO @endif {{ $requerimiento->id }} PARA EL CARGO {{ $requerimiento->nombre_cargo_especifico }}
                    </h3>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="color: #ffff;" width="120px" class="td-azul" style="font-size: 16px;">
                    <strong>
                        CANDIDATO
                    </strong>
                </td>

                @if($transversales->count() >= 1)
                    @foreach($transversales as $key => $transversal)
                            <td style="color: #ffff;font-size: 10px !important; width: 10% !important;" class="td-azul" >
                                
                                    {{ $transversal->descripcion }}
                               
                            </td>
                    @endforeach
                @endif
            </tr>
            <tr>
                <td style="background-color: rgba(66, 175, 0, 0.6);">
                    <strong>
                        IDEAL
                    </strong>
                </td>
                @if($ideal_req->count() >= 1)
                    @foreach($ideal_req as $ideal)
                        <td style="background-color: rgba(66, 175, 0, 0.6);">
                            <strong>
                                {{ $ideal->ideal }}
                            </strong>
                        </td>
                    @endforeach
                @endif
            </tr>

            @if($candidatos->count() >= 1)
              @foreach($candidatos as $key => $candidato)
               <tr>
                <td width="130px" style="background-color: #09f2b01a;">
                 {{ \App\Models\DatosBasicos::nombreUsuario($candidato->candidato_id) }}
                </td>

                        @if($transversales->count() >= 1)
                         @foreach($transversales as $key => $transversal)
                          <td style="background-color: #09f2b01a;">
                           {{\App\Models\PreliminarTranversalesCandidato::nombreTransversales($candidato->candidato_id, $requerimiento->id, $transversal->id)}}
                          </td>
                         @endforeach
                        @endif
               </tr>
              @endforeach
            @endif
        </table>

        <br/>
        <hr>
        <br/>

        <table>
            <tr>
             <td colspan="4">
              TABLA DE AJUSTE
             </td>
            </tr>
            <tr class="td-azul">
              <td style="color: #ffff;">
               <strong>CANDIDATO</strong>
              </td>
              <td style="color: #ffff;">
               <strong>% AJUSTE AL PERFIL IDEAL </strong>
              </td>
              <td style="color: #ffff;">
               <strong> DESVIACIÓN POSITIVA AL PERFIL IDEAL </strong>
              </td>
              <td style="color: #ffff;">
               <strong> DESVIACIÓN NEGATIVA AL PERFIL IDEAL </strong>
              </td>
            </tr>

            @if($candidatos->count() >= 1)
                @foreach($candidatos as $candidato)
                <tr>
                    <td style="background-color: #09f2b01a;">
                        {{ \App\Models\DatosBasicos::nombreUsuario($candidato->candidato_id) }}
                    </td>
                    @foreach($datas as $data)
                        <td style="background-color: #09f2b01a;">
                            @if(isset($data[$candidato->candidato_id]))
                                {{ $data[$candidato->candidato_id] }}%
                            @else
                                0%
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            @endif
        </table>

        @if(isset($grafica))
            <br/>
            <hr>
            <br/>
            <img height="180px;" width="100%" src="data:image/{{ $tipoData }};base64,{!! base64_encode($grafica) !!}" />
        @endif

        <br/>
        <hr>
        <p style="text-align: center;">4=Alto, 3=Medio, 2=Bajo</p>
        <br/>

        <table>
            <tr>
                <th class="border">
                    Ranking
                </th>
                <th class="border">
                    Nombre
                </th>
                <th class="border">
                    Descripción
                </th>
            </tr>
            @foreach($candidatos as $key => $candidato)
                <tr>
                    <td class="border">
                     {{ ++$key }}
                    </td>
                    <td class="border">
                      <p>
                       {{\App\Models\DatosBasicos::nombreUsuario($candidato->candidato_id)}}
                      </p>
                    </td>
                    <td class="border">
                        <p>
                        @if($candidato->descripcionCandidato() == "")
                            Se identifica con la {{ mb_strtolower($candidato->dec_tipo_doc) }} número {{ number_format($candidato->numero_id) }} de la ciudad de  {{ \App\Models\Ciudad::GetCiudad($candidato->pais_id, $candidato->departamento_expedicion_id, $candidato->ciudad_expedicion_id) }}, cuyo género es {{ mb_strtolower($candidato->genero_desc) }}, su estado civil es {{ mb_strtolower($candidato->estado_civil_des) }} y tiene una aspiración salarial {{ strtolower($candidato->aspiracion_salarial_des) }}. Reside actualmente en la ciudad de {{ \App\Models\Ciudad::GetCiudad($candidato->pais_residencia, $candidato->departamento_residencia, $candidato->ciudad_residencia) }}, en la dirección {{ mb_strtolower($candidato->direccion) }}.

                            @if($candidato->maximoEstudio())
                                @if($candidato->maximoEstudio()->estudio_actual)
                                    El nivel máximo de estudios registrado es {{ mb_strtolower($candidato->maximoEstudio()->descripcion) }} en {{ ucwords(mb_strtolower($candidato->maximoEstudio()->institucion)) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($candidato->maximoEstudio()->pais_estudio, $candidato->maximoEstudio()->departamento_estudio, $candidato->maximoEstudio()->ciudad_estudio) }}.
                                @else
                                    El nivel máximo de estudios registrado es {{ mb_strtolower($candidato->maximoEstudio()->descripcion) }} y el titulo obtenido es {{ mb_strtolower($candidato->maximoEstudio()->titulo_obtenido) }} en {{ ucwords(mb_strtolower($candidato->maximoEstudio()->institucion)) }}, el cual finalizó el {{ \App\Models\DatosBasicos::convertirFecha($candidato->maximoEstudio()->fecha_finalizacion) }} en la ciudad de {{ \App\Models\Ciudad::GetCiudad($candidato->maximoEstudio()->pais_estudio, $candidato->maximoEstudio()->departamento_estudio, $candidato->maximoEstudio()->ciudad_estudio) }}.
                                @endif
                            @endif
                        @else
                            {{ $candidato->descripcionCandidato() }}
                        @endif
                        </p>
                    </td>
                </tr>
            @endforeach
        </table>

        <!--FIRMAR -->
        <br/>
        <br/>
        <h1>
           __________________
        </h1>
        <p>
            Psicólogo gestionó 
            <strong>
                @if($ultima_transversal_realizada !== null)
                    {{ \App\Models\DatosBasicos::nombreUsuario($ultima_transversal_realizada->realizo_id) }} 
                @endif
            </strong>
        </p>
        <p>
            Fecha realización del informe 
            <strong>
                @if($ultima_transversal_realizada !== null)
                    {{ \App\Models\DatosBasicos::convertirFecha($ultima_transversal_realizada->updated_at) }} 
                @endif
            </strong>
        </p>

        <!--  PIE -->
        <footer>
            <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co
        </footer>
    </body>
</html>
