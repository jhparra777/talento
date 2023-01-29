<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Firma de contrato</title>

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            color: black;
            background-color: #fff;
        }

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .m-1{ margin: 1rem; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .pd-1{ padding: 1rem; }

        .center{ margin: auto; }

        .table{
            border-collapse:separate; 
            /*border-spacing: 6px;*/
        }

        .justify{ text-align: justify; }

        .list{ list-style: none; }

        .space{ line-height: 18px; }

        hr{
            page-break-after: always;
            border: none;
            margin: 0;
            padding: 0;
        }

        footer{
            position: fixed; 
            bottom: -20px; 
            font-size: 7pt;
        }
        
    </style>
</head>
<body>
    @include('contratos.includes._section_footer_marca_agua')
    <table width="100%" class="mt-1">
        <tr>
            <th width="10%"></th>

            <th class="text-left">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                      <img src="{{ asset('configuracion_sitio/'.$empresa_contrata->logo) }}" width="80" >
                    @endif
                @endif
            </th>

            <th class="text-right text-light">
                Fecha: <strong>{{ $fecha }}</strong>
            </th>

            <th width="10%"></th>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <th class="text-center">
                <p>Firma de contrato</p>
                @if (isset($anulado))
                    <h4 style="color:red; margin:0; padding:0; font-size: 24px;">CONTRATO ANULADO</h4>
                @endif
            </th>
        </tr>

        @if($foto != null)
            <tr>
                <td class="text-center">
                    <img src="{{ asset('recursos_datosbasicos/'.$foto) }}" width="80" height="80" style="border-radius: 10px;">
                </td>
            </tr>
        @endif

        <tr>
            <td class="text-center mt-1">
                {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <th class="text-center">
                <p>CONTRATO DE TRABAJO POR EL TIEMPO
                    <br/><br/>
                QUE DURE LA REALIZACIÓN DE LA OBRA O LABOR CONTRATADA</p>
            </th>
        </tr>
    </table>

    <table class="center table justify" width="97%">
        <tr class="pd-1">
            <th class="text-left" width="25%">
                Nombre del Empleador:
            </th>
            
            <td width="25%">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->nombre_empresa }}
                    @endif
                @endif
            </td>

            <th class="text-left" width="25%">
                NIT del Empleador:
            </th>
            
            <td colspan="2" width="25%">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->nit }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Domicilio del Empleador:
            </th>
            
            <td width="25%">
                @if(isset($reqcandidato->agencia_direccion))
                    {{ $reqcandidato->agencia_direccion }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->agencia_direccion))
                        {{ $requerimiento_informacion->agencia_direccion }}
                    @endif
                @endif
            </td>

            <th class="text-left" width="25%">
                Ciudad:
            </th>
            
            <td colspan="2" width="25%">
                @if(isset($reqcandidato->nombre_ciudad))
                    {{ $reqcandidato->nombre_ciudad }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->nombre_ciudad))
                        {{ $requerimiento_informacion->nombre_ciudad }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="50%">
                Teléfono:
            </th>
            
            <td colspan="4" width="50%">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->telefono }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Nombre del trabajador:
            </th>
            
            <td colspan="4" width="25%">
                {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
            </td>

        </tr>

        <tr>
            <th class="text-left">
                Identificación:
            </th>

            <td colspan="4">
                {{ ucwords(mb_strtolower($candidato->dec_tipo_doc))}}
                {{ $candidato->numero_id }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Lugar y fecha de nacimiento:
            </th>
            
            <td colspan="4">
                {{ $candidato->fecha_nacimiento }}

                @if($lugarnacimiento != null)
                    {{ $lugarnacimiento->value }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Dirección del Trabajador:
            </th>
            
            <td width="25%">
                {{ $candidato->direccion }}
            </td>

           <th class="text-left">
                Correo electrónico de notificaciones: 
            </th>

            <td colspan="2">
                {{ $candidato->email }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Ciudad:
            </th>
            
            <td>
                @if($lugarresidencia != null)
                    {{ $lugarresidencia->value }}
                @endif
            </td>

            <th class="text-left" width="25%">
                Teléfono:
            </th>
            
            <td colspan="2" width="25%">
                {{ $candidato->telefono_movil }}
            </td>
        </tr>

        <tr>
            <th class="text-left" width="50%">
                Afiliación:
            </th>
            
            <td colspan="2" width="50%">
                <b>ARL:</b> AXA COLPATRIA  <b>AFP:</b> {{ $candidato->entidades_afp_des }} <b>EPS:</b> {{ $candidato->entidades_eps_des }}
            </td>
        </tr>

        <tr>
            <th class="text-left" width="50%">
                Obra o Labor particular a realizar:
            </th>

            <td colspan="4" width="50%">
                @if(isset($reqcandidato->motivo_requerimiento))
                    {{ $reqcandidato->motivo_requerimiento }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->motivo_requerimiento))
                        {{ $requerimiento_informacion->motivo_requerimiento }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Fecha de inicio:
            </th>

            <td colspan="4" width="25%">
                @if(isset($fechasContrato->fecha_ingreso))
                    {{ $fechasContrato->fecha_ingreso }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Salario Básico:
            </th>

            <td width="25%">
                @if(isset($reqcandidato->salario))
                    $ {{ number_format($reqcandidato->salario) }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->salario))
                        $ {{ number_format($requerimiento_informacion->salario) }}
                    @endif
                @endif
            </td>

            <th class="text-left">
                Tipo Salario:
            </th>
            
            <td colspan="2">
                @if(isset($reqcandidato->descripcion_tipo_salario))
                    {{ $reqcandidato->descripcion_tipo_salario }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->descripcion_tipo_salario))
                        {{ $requerimiento_informacion->descripcion_tipo_salario }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">Adicionales:</th>

            <td colspan="4">
                @if(isset($reqcandidato->adicionales_salariales))
                    {{ $reqcandidato->adicionales_salariales }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->adicionales_salariales))
                        {{ $requerimiento_informacion->adicionales_salariales }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left" width="50%">
                Períodos de pagos:
            </th>

            <td colspan="4" width="50%">
                @if(isset($reqcandidato->descripcion_tipo_liquidacion))
                    {{ $reqcandidato->descripcion_tipo_liquidacion }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->descripcion_tipo_liquidacion))
                        {{ $requerimiento_informacion->descripcion_tipo_liquidacion }}
                    @endif
                @endif
            </td>
        </tr>
    </table>

    <table class="center table justify mt-2" width="97%">
        {!! isset($cuerpo_contrato) ? $cuerpo_contrato->cuerpo_contrato : "" !!}

        <tr>
            <td>
                <p>
                    Para constancia se firma en dos ejemplares del mismo tenor y valor, en la ciudad y fecha que se indican a continuación. BOGOTA, {{ $dias_semana[date('N')] }} {{ date('d') }} de {{ $meses[date('n')] }} del 2020.
                </p>
            </td>
        </tr>
    </table>

    {{-- Contrato firmado --}}
    @if($firmaContrato != null || (isset($mostrar_firma) && $mostrar_firma === 'SI'))
        <table class="center table" width="80%">
            <tr>
                <td width="40%">
                    <div style="width: 100%; margin: 4em;">
                        <img src="{{ asset('contratos/default.jpg') }}" width="180">
                        <p>________________________________</p>
                        El empleador: <br>
                        James Ceron Palza <br>
                        Jefe nacional de Archivo.
                        <br>
                    </div>
                </td>
                <td width="30%"></td>
                <td width="40%">
                    <div style="width: 100%; margin: 4em;">
                        @if ($firmaContrato != null)
                            <img src="{{ $firmaContrato->firma }}" width="180">
                        @endif
                        <p>________________________________</p>
                        El trabajador:<br>
                        {{ mb_strtoupper($candidato->nombres) }} {{ mb_strtoupper($candidato->primer_apellido)}} {{ mb_strtoupper($candidato->segundo_apellido)}}
                        <br>
                        {{ ucwords(mb_strtolower($candidato->dec_tipo_doc))}} : {{ $candidato->numero_id }}
                    </div>
                </td>
            </tr>
        </table>
    @endif

    @if(!isset($anulado) || (isset($mostrar_adicionales) && $mostrar_adicionales === 'SI'))
        @if(isset($adicionales))
            @if($adicionales->count() > 0)
                @foreach($adicionales as $ad)
                    <hr>
                    
                    <?php
                        $firma = null;
                        $documento_mostrar = "home.include.adicionales.documento_".$ad->adicional_id;
                        if($ad->firma != null && $ad->firma != ""){
                            $firma=$ad->firma;
                        }
                    ?>
                    
                    @include($documento_mostrar)

                    <?php
                        if(isset($firma)){
                            unset($firma);
                        }
                    ?>
                @endforeach
            @endif
        @endif

        @if(isset($adicional_externo))
            @if($adicional_externo->count() > 0)
                <div style="page-break-after:always;"></div>
                @include("home.include.adicionales.documento_medico_recomendaciones", [
                    "recomendaciones" => $requerimiento_candidato_orden_pdf->especificacion,
                    "firma" => isset($adicional_externo->firma) ? $adicional_externo->firma : null,
                    "lugarexpedicion" => $lugarexpedicion_medica
                ])
            @endif
        @endif

        {{-- cláusulas creadas --}}
        @if(isset($adicionales_creadas))
            @if($adicionales_creadas->count() > 0)
                @foreach($adicionales_creadas as $clausula)
                    <hr>
                    
                    <?php
                        $firma = null;
                        if($clausula->firma != null && $clausula->firma != ""){
                            $firma = $clausula->firma;
                        }

                        $nuevo_cuerpo = App\Jobs\FuncionesGlobales::search_and_replace(
                            $replace, 
                            $clausula->contenido_clausula, 
                            ['adicional_id' => $clausula->adicional_id, 'req_id' => $req_id, 'cargo_id' => $clausula->cargo_id, 'user_id' => $userId]
                        );
                    ?>

                    @include('admin.clausulas.template.layout', ["nuevo_cuerpo" => $nuevo_cuerpo, "empresa_contrata" => $empresa_contrata, "firma" => $firma, 'opcion_firma' => $clausula->opcion_firma]) 
                
                    <?php
                        if(isset($firma)){
                            unset($firma);
                        }
                    ?>
                @endforeach
            @endif
        @endif

        @if (isset($mostrar_adicionales) && $mostrar_adicionales === 'SI')
            <div style="page-break-after:always;"></div>
            @include("home.confirmacion_manual", array('firma' => '-1'))
        @endif
    @endif

    @if($firmaContrato != null)
        <div style="page-break-after:always;"></div>

        <table class="center table justify" width="80%">
            <tr>
                <td>
                    <p>Información especial del contrato</p>
                    <ul class="list">
                        <li>IP: {{ $firmaContrato->ip }}</li>
                        <li>Fecha y hora de firma: {{ date("Y-m-d H:i:s") }}</li>
                        <li>Token de acceso: {{ $reqcandidato->token_acceso }}</li>
                        {{--<li>{!!QrCode::size(200)->generate("www.t3rsc.com") !!}</li>--}}
                    </ul>
                </td>
            </tr>
        </table>
    @endif

    @if(count($contrato_fotos) > 0)
        <div style="page-break-after:always;"></div>

        <section>
            <p class="text-center">
                <b>
                    Fotos tomadas durante la firma de los documentos
                </b>
            </p>
        </section>

        <section>
			<div class="text-center">
				@foreach($contrato_fotos as $key => $foto)
                    @if (empty($foto->estado))
                        <img 
                            class="m-1" 
                            src="{{ url("recursos_firma_contrato_fotos/contrato_foto_"."$userId"."_"."$req_id"."_"."$firmaContrato->id/$foto->descripcion") }}" 
                            alt="Foto candidato"
                            width="220"
                            style="padding: .25rem; width: 220px; background-color: #fff; border: 1px solid #dee2e6; border-radius: .25rem; max-width: 100%;">
                        <div style="margin-top: -1rem; font-size: 8pt; color: gray;">{{ $foto->created_at }}</div>
                    @else
                        <div class="m-1" style="padding: .25rem; font-size: 8pt; color: rgb(95, 95, 95);">{{ $foto->estado }}</div>
                    @endif

                    <?php
						if ($key === 6) {
							break;
						}
					?>
	            @endforeach
			</div>
		</section>
    @endif
</body>
</html>