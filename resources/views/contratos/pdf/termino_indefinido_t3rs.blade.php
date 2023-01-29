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
                      <img src="{{ public_path().'/configuracion_sitio/'.$empresa_contrata->logo }}" width="80" >
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
                <p>CONTRATO DE TRABAJO A TÉRMINO INDEFINIDO</p>
            </th>
        </tr>
    </table>

    <table class="center table justify" width="97%">
        <tr class="pd-1">
            <th class="text-left">
                Nombre del Empleador:
            </th>
            
            <td colspan="4">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->nombre_empresa }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Nombre del trabajador:
            </th>
            
            <td colspan="4">
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
                Nacionalidad:
            </th>
            
            <td colspan="4">
                Colombiano
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Dirección:
            </th>
            
            <td colspan="4">
                {{ $candidato->direccion }}
            </td>

        </tr>

        <tr>

            <th class="text-left">
                Celular:
            </th>
            
            <td colspan="4">
                {{ $candidato->telefono_movil }}
            </td>           
        </tr>

        <tr>

            <th class="text-left">
                Estado Civil:
            </th>
            
            <td colspan="4">
                {{ $candidato->estado_civil_des }}
            </td>           
        </tr>

        <tr>

            <th class="text-left">
                Edad:
            </th>
            
            <td colspan="4">
                {{ $edad }} años
            </td>           
        </tr>

         <tr>
            <th class="text-left">
                Cargo:
            </th>

            <td colspan="4">
                @if(isset($reqcandidato->nombre_cargo_especifico))
                    {{ $reqcandidato->nombre_cargo_especifico }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->nombre_cargo_especifico))
                        {{ $requerimiento_informacion->nombre_cargo_especifico }}
                    @endif
                @endif            
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Salario Base:
            </th>

            <td colspan="4">
                <?php $formatterES = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
                    ?>

                @if(isset($reqcandidato->salario))
                    {{ number_format($reqcandidato->salario) }}
                ( {{ $formatterES->format($reqcandidato->salario) }} de pesos M/Cte.)
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->salario))
                        {{ number_format($requerimiento_informacion->salario) }}
                     ( {{ $formatterES->format($requerimiento_informacion->salario) }} de pesos M/Cte.)
                    @endif
                @endif  

            </td>
        </tr>

        <tr>
            <th class="text-left">
                Forma de Pago:
            </th>

            <td colspan="4">
                Pagos Mensuales el día 7
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Fecha de Ingreso:
            </th>

            <td colspan="4">
                <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime(" %d de %B de %Y", strtotime($fechasContrato->fecha_ingreso)) ?>
            </td>
        </tr>
    </table>

    <table class="center table justify mt-2" width="97%">
        <tr>
            <td>
                <br/><br/>
                Entre el empleador y el trabajador, de las condiciones ya dichas, identificados como aparece al pie de sus firmas, se ha celebrado el presente contrato individual de trabajo, regido además por las siguientes cláusulas:

                <br/><br/>
                <b>Primera</b>. El empleador contrata los servicios personales del trabajador y éste se obliga: 
                <br/>
                a) Ejecutar y desarrollar las funciones propias del cargo de @if(isset($reqcandidato->nombre_cargo_especifico))
                    {{ $reqcandidato->nombre_cargo_especifico }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->nombre_cargo_especifico))
                        {{ $requerimiento_informacion->nombre_cargo_especifico }}
                    @endif
                @endif   
                <br/>

                {!! isset($cuerpo_contrato) ? $cuerpo_contrato->cuerpo_contrato : "" !!}
                
                <br/><br/>
                Para constancia se firma en dos ejemplares del mismo tenor y valor, en la ciudad de Bogotá D. C. el dia {{ date('d') }} del mes de {{ $meses[date('n')] }} del año {{date('Y')}}.
            </td>
        </tr>
    </table>

    {{-- Contrato firmado --}}
    @if($firmaContrato != null || (isset($mostrar_firma) && $mostrar_firma === 'SI'))
        <table class="center table" width="80%">
            <tr>
                <td width="40%">
                    <div style="width: 100%; margin: 4em;">
                        <img src="{{ asset('contratos/Firma-Jorge-t3rs.png') }}" width="180">
                        <p>________________________________</p>
                        El empleador: <br>
                        Jorge Andrés Ortiz Guzmán <br>
                        C.C.80.918.837
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
                        $fecha = null;
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
                        $fecha = null;
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