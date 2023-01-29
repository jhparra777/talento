<!DOCTYPE html>
<html lang="es">
    <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Contratación</title>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    </head>
  
    <style>
        
        body{
          font-size: 10px;
          margin: 0;
          font-family: Arial, Helvetica, sans-serif;
        }
            
          .tabla1{
            border-collapse: collapse;
            width: 100%;
          }

          .tabla1, .tabla1 th, .tabla1 td,.tabla3 th, .tabla3 td {
            border: 1px solid black;
            padding: 0;
            margin: 0;
          }

          .tabla2{
           border-collapse: collapse;
          }

          .tabla3{
           border-collapse: collapse;
           width: 60%;
          }

            .tabla2 td {
                border-top: 0px solid black;    
                border: 1px solid black;    
                padding: 0px;
                margin: 0;
                text-align: center;
                font-size: 10px
            }

            .tabla3 td{
               padding-left: 12px !important;
               text-align: center;
            }

            @page { margin: 15px 15px; }
            .page-break {
                page-break-after: always;
            }

            .imagen{
              height: 150px
            }

            .titulo{
                background-color: #cacaca;
                padding: 1px 0px;
                text-align: center;
                font-size: 10px;
            }

            .tabla3 tr th{
                background-color: #fafafa;
                font-weight: bold;
            }

            span {
                width: 72% !important;
                padding: 5px 0px 5px 0px;
                /*padding-bottom: 9px;*/
                /*border: 1px solid Black;*/
            }

            td span {
              margin-left: 23px;
            }

            span .td {
                border: none !important;
                background: White !important;
                /*  display: table-cell;*/
                padding-left: 10px;
                font-size: 16px;
                margin-bottom: 30px;
                border:none !important;
            }

            span .tr {
                /* display: table-row;*/
              border: 1px solid Black;
              background-color: #f5f5f5;
            }

            span .th {
              text-align: left;
              font-weight: bold;
            }

            .titulo h3{
             font-size: 9px;
            }

            td h3{
             text-align: center;
            }

            tr td{

             text-align: center;
            }

            td label{
             text-align: center;
            }

    </style>

    <body>
        <table class="tabla1">
            <tr>
                <td style="padding-top: 12px; border-bottom: none !important;">
                    @if(isset($requerimiento->empresa_contrata))
                        @if($logo != "")
                            <img style="max-width: 200px" src="{{ url('configuracion_sitio')}}/{!!$logo!!}">
                        @else
                            <img style="max-width: 200px" src="{{url('img/logo.png')}}" >
                        @endif
                    @else
                        <img style="max-width: 200px" src="{{url('img/logo.png')}}">
                    @endif
                </td>

                <td><strong>PROCESO: @if($requerimiento->tipo_proceso_id == 6) CONTRATACIÓN @else SELECCIÓN @endif</strong></td>
                <td><strong>Código: SEFM15</strong></td>
                <tr>
                    <td style="border-top: none !important;"></td>
                    <td><strong>ORDEN DE CONTRATACIÓN PERSONAL</strong></td>
                    <td><strong>Versión:2.0 </strong></td>
                </tr>   
            </tr>
        </table>

        <table class="tabla1">
            <tr>
                <td class="titulo"><h3> FECHA DE LA ELABORACIÓN </h3> </td>
                <td class="titulo"><h3> NÚMERO DE REQUISICIÓN </h3></td>
                <td class="titulo"><h3> NÚMERO KACTUS </h3></td>
                <td class="titulo"><h3> EMPRESA POR LA CUAL SE CONTRATA </h3> </td>
                <td class="titulo"><h3> EMPRESA CLIENTE </h3></td>
            </tr>

            <tr>
                <td>{{ date('d-m-Y',strtotime($requerimiento->created_at)) }}</td>
                <td>{{ $requerimiento->id_requerimiento }}</td>
                <td>{{ $requerimiento->id_kactus }}</td>
                <td>{{ (isset($empresa_logo))?$empresa_logo->nombre_empresa:FuncionesGlobales::sitio()->nombre }}</td>
                <td>
                    {{ $requerimiento->nombre_cliente_req() }}
                </td>
            </tr>
        </table>

        <table class="tabla1">
            <tr>
                <td class="titulo"><h3> CARGO A CONTRATAR </h3> </td>
                <td class="titulo"><h3> ATEP </h3></td>
                <td class="titulo"><h3> CENTRO DE COSTOS </h3></td>
                <td class="titulo"><h3> ENTERPRISE </h3></td>
                <td class="titulo"><h3> TIPO DE CONTRATO </h3></td>
            </tr>

            <tr>
                <td>
                    {{ $requerimiento->cargo_req() }}
                </td>
                <td>
                    {{ $requerimiento->getCentroTrabajo()->nombre_ctra }}
                </td>
                <td>{{ $requerimiento->codigo }} - {{ $requerimiento->centro_costos }}</td>
                <td>{{ $requerimiento->enterprise }}</td>
                <td>
                    {{ $requerimiento->getTipoContrato()->descripcion }}
                </td>
            </tr>
        </table>

        <table class="tabla1">
           <tr>
            <td class="titulo"><h3>GRUPO DE PROTOTIPOS DE PAGO </h3></td>
            <td class="titulo"> <strong> TIPO REMUNERACIÓN </strong></td>
            <td class="titulo"><h3>SALARIO BÁSICO</h3></td>
            <td class="titulo"><h3>VALOR POR DÍA </h3></td>
            <td class="titulo"><h3>VALOR EXACTO POR HORA </h3></td>
           </tr>
          <tbody>
           <tr>
            <td>
              {{$requerimiento->getTipoNomina()->descripcion}}
            </td>
            <td> 
              {{$requerimiento->getTipoSalario()->descripcion}}
            </td>
            <td>{{number_format($requerimiento->salario, 2)}}</td>

            <?php $pdia = $requerimiento->salario/30; ?>
            
            <td>{{number_format($pdia,2)}}</td>

            <?php $phora = $pdia/8; ?>
            
            <td>{{number_format($phora,2)}}</td>
           </tr>
          </tbody>
         </table>

         <table class="tabla1">
           <tr>
            <td class="titulo"><h3 style="font-size: 12px;">NOTAS ADICIONALES</h3></td>
           </tr>
           <tr>
             <td>
               <h4> Observación: </h4>
               <p style="font-size: 12px;">
                 {{(isset($proceso_candidato_contra->observaciones))?$proceso_candidato_contra->observaciones: ''}}
               </p>
             </td>
           </tr>
           <tr>
           <td> <p> </p> </td>
           </tr>

         </table>
            
          <table class="tabla2">
           <tr>
            <td><strong> NOMBRE </strong></td>
            <td><strong> N° CÉDULA </strong></td>
            <td><strong> TIPO DE INGRESO </strong></td>
            @if(isset($proceso_candidato_contra->fecha_ultimo_contrato))
              <td>
                <strong> FECHA DE TERMINACIÓN DEL CONTRATO ANTERIOR </strong>
              </td>
            @elseif(isset($datos_basicos) && $datos_basicos->count() > 0)
              <td>
                <strong> FECHA DE TERMINACIÓN DEL CONTRATO ANTERIOR </strong>
              </td>
            @endif
            <td><strong> FECHA INICIO CONTRATO </strong></td>
            <td><strong> FECHA Y HORA DE PRESENTACIÓN <br>
             CON EMPRESA CLIENTE </strong></td>
            <td><strong> FECHA DE TERMINACIÓN DE LABOR </strong></td>
            <td><strong> AUXILIO DE TRANSPORTE </strong></td>
            <td><strong> EPS </strong></td>
            <td><strong> ARL </strong></td>
            <td><strong> CAJA DE COMPENSACIÓN FAMILIAR </strong></td>
            <td><strong> FONDO DE PENSIONES </strong></td>
            <td><strong> FONDO DE CESANTÍAS </strong></td>
            <td><strong> NOMBRE DEL BANCO </strong></td>
            <td><strong> TIPO DE CUENTA </strong></td>
            <td><strong> NÚMERO DE CUENTA </strong></td>
           </tr>

        @if(isset($datos_basico))
        
           <tr>
            <td> {{$datos_basico->nombres.' '.$datos_basico->primer_apellido.' '.$datos_basico->segundo_apellido}} </td>
            <td>{{$datos_basico->numero_id}}</td>
            <td>{{($datos_basico->tipo_ingreso == 1)?'Nuevo':'Reingreso'}}
            </td>
            @if(isset($proceso_candidato_contra->fecha_ultimo_contrato))
             <td> {{$proceso_candidato_contra->fecha_ultimo_contrato }} </td>
            @endif
            <td>{{ $proceso_candidato_contra->fecha_ingreso_contra }} {{$proceso_candidato_contra->fecha_inicio_contrato }} </td>
            <td>{{ $proceso_candidato_contra->fecha_ingreso_contra }}{{$proceso_candidato_contra->fecha_inicio_contrato.' '.$proceso_candidato_contra->hora_entrada}}</td>
            <td>{{$proceso_candidato_contra->fecha_fin_contrato}}</td>
            <td>{{$datos_basico->auxilio_transporte}}</td>
            <td>{{$datos_basico->entidades_eps_des}}</td>
            <td>{{'Colpatria'}}</td>
            <td>{{$datos_basico->caja_compensacion_des}}</td>
            <td>{{$datos_basico->entidades_afp_des}}</td>
            <td>{{$datos_basico->fondo_cesantia_des}}</td>
            <td>{{$datos_basico->nombre_banco_des}}</td>
            <td>{{$datos_basico->tipo_cuenta}}</td>
            <td>{{$datos_basico->numero_cuenta}}</td>
          </tr>
        
        @elseif(isset($datos_basicos))

          @foreach($datos_basicos as $datos)
           <tr>
            <td>{{$datos->nombres.' '.$datos->primer_apellido.' '.$datos->segundo_apellido}}</td>
            <td>{{$datos->numero_id}}</td>
            <td>{{($datos->tipo_ingreso == 1)?'Nuevo':'Reingreso'}}</td>
            
            @if(isset($datos->fecha_ultimo_contrato))
              <td> {{$datos->fecha_ultimo_contrato }} </td>
            @elseif($datos_basicos->count() > 0)
              <td> </td>
            @endif

            
            <td> {{ $datos->fecha_ingreso_contra }}</td>
            <td>{{ $datos->fecha_ingreso_contra.' '.$datos->hora_entrada}}</td>

            <td>{{$datos->fecha_fin_contrato}}</td>
            <td>{{$datos->auxilio_transporte}}</td>
            <td>{{$datos->entidades_eps_des}}</td>
            <td>{{'Colpatria'}}</td>
            <td>{{$datos->caja_compensacion_des}}</td>
            <td>{{$datos->entidades_afp_des}}</td>
            <td>{{$datos->fondo_cesantia_des}}</td>
            <td>{{$datos->nombre_banco_des}}</td>
            <td>{{$datos->tipo_cuenta}}</td>
            <td>{{$datos->numero_cuenta}}</td>
           </tr>
          @endforeach
          
        @endif

          </table>

          <table class="tabla1">
           <tr><td class="titulo"><h3>REMITIDO POR PSICÓLOGO(A)</h3></td>
           <td> {{$remitido}} </td></tr>

           <tr><td class="titulo"><h3>DETALLES DOTACIÓN</h3></td>
           <td> {{$requerimiento->detalle_dotacion}} </td></tr>

           <tr><td class="titulo"><h3>JEFE INMEDIATO</h3></td>
           <td> {{$requerimiento->jefe_inmediato}} </td></tr>
          </table>
        
    </body>
</html>