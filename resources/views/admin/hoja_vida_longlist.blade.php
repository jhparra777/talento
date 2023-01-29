<?php $m = 'Carbon\Carbon'; // para calcular la edad
   $total = $dato_basicos->count(); //para saber la cantidad de hojas a crear
   $hojas = $total / 4;
   $hojas = round($hojas);
   $hojas = (int)$hojas;
   $j = 0;//regulador de hojas nuevas
   $width= "1300px"; $max_width= "1350px"; $min_width= "1300px";
 ?>
<?php
  $load = count($dato_basicos->chunk(4));//elejir el tipo de tabla
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title> Cuadro de Preselección </title>

      <style type="text/css">
          
          @page{ margin: 35px 56px;}

            th{
              word-wrap: break-word;
              max-width: 200px;
            }

            td{
              word-wrap: break-word;
              max-width: 320px;
              width: 320px;
            }

            .cand-todos{
              border-collapse: collapse;
              margin-top: 20px;
            }

            .cand-uno{
              border-collapse: collapse;
            }

            .cand-todos th, .cand-uno th{
              background-color: #ffc000 !important;
              border: 1px solid black;
              text-align: center !important;
              max-width: 200px;
              width: 200px;
            }

            .cand-todos td, .cand-uno td{
              border: 1px solid black;
            }

            .page-break {
              page-break-after: always;
            }

            .table th{
            }

            .table td{
              border: solid 1px black;
            }

            .encabezado{
              width: 900px;
              max-width: 950px;
              min-width: 900px;
            }

            .encabezado th{
              border: none;
              float: center;
              text-align: left;
              padding-left: 10%;
              display: table-cell;
            }

            .encabezado td{
              font-weight: bold;
              border: none;
              text-align: start;
              padding-left: 25%;
              display: table-cell;
            }

            body {
              font-family: 'Times New Roman';
              font-size: 11px;
              background-color: #FFFFFF;
            }

            /* Justificar parrafo */
            p{
              text-align: justify;
            }

            img{
              align-content: center;
              margin-left: 35%;
            }

            .breakAlways{
              page-break-after: always;
            }

            span{
             position: relative;
             margin-left: 40%;
             margin-top: -1px;
            /* margin-top: -12px;
             margin-left: 75.7px;
             text-align: right;*/
            }
            
            .logo_derecha{
              float: right;
              position: absolute;
              top: 3px; 
            }

            .conten-text{
             float: left;
             width: 150px;
             height: 10px;
            }
      </style>

  </head>
<body>

@foreach($dato_basicos->chunk(4) as $datos_basicos) {{--mostrar 4 registros por hoja--}}
  <? $j++; //conteo de hojas ?>
  <table class="table encabezado">
    <tr>
     <th> CLIENTE: {{$requerimiento->nombre_cliente_req()}} </th>
    </tr>

    <tr>
      <th> PROCESO: {{$requerimiento->getCargoEspecifico()->descripcion}} </th>
    </tr>

    <tr>
      <th> FECHA: {{date('d/m/Y')}} </th>
    </tr>
    <h2 style="text-align:center; position:absolute; right:33%; top:3px;"> CUADRO DE PRESELECCIÓN </h2>
    <div class="logo_derecha">
      <img alt="user photo" height="70" src="{{url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo))!!}" width="80">
    </div>
  </table>

  <table class="table cand-todos">
    <tr>
      <th>FOTO</th>
        @foreach($datos_basicos as $candidato)
         <td class="textCenter">
          @if($candidato->foto_perfil != "")
           <img align="center" alt="user photo" height="70" src="{{ public_path().'/recursos_datosbasicos/'.$candidato->foto_perfil}}" width="80"/>
          @elseif($candidato->avatar != "")
            <img align="center" alt="user photo" height="70" src="{{ public_path().'/'.$candidato->avatar}}" width="80"/>
          @else
            <img alt="user photo" height="70" src="{{url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo))!!}" width="80">
          @endif
         </td>
       @endforeach
    </tr>

    <tr>
      <th> CANDIDATO </th>
      @foreach($datos_basicos as $candidato)
       <td style="font-weight: bold; text-align:center;">{{ucwords(mb_strtoupper($candidato->fullname()))}} </td>
      @endforeach
    </tr>

    <tr>
      <th> EDAD / E.CIVIL / HIJOS </th>
      @foreach($datos_basicos as $candidato)
       <td> {{($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "")?$m::parse($candidato->fecha_nacimiento)->age:"No registra"}} / {{mb_strtolower($candidato->estado_civil_des)}} {{(isset($candidato->numero_hijos))?' / '.$candidato->numero_hijos:''}} </td>
      @endforeach
    </tr>
       
    <tr>
      <th> ESTUDIOS </th>
      @foreach($datos_basicos as $candidato)
        <td>
        @if(count($candidato->pregradoEstudio()) > 0)
         <p> {{ucwords(mb_strtolower($candidato->pregradoEstudio()->titulo_obtenido))}} <br> {{ucwords(mb_strtolower($candidato->pregradoEstudio()->institucion))}} </p>
         @else
            No registra
        @endif
          <p> @if(count($candidato->maximoEstudio()) > 0) @if($candidato->maximoEstudio()->nivel_estudio_id != 2) {{ucwords(mb_strtolower($candidato->maximoEstudio()->titulo_obtenido))}} <br>
           {{ucwords(mb_strtolower($candidato->maximoEstudio()->institucion))}} @endif @endif
          </p>
        </td>
      @endforeach
    </tr>

    <tr>
        <th> EMPRESA ACTUAL/ <br> CARGO TIEMPO </th>
        @foreach($datos_basicos as $candidato)
          <td>
            @if(count($candidato->experiencias_cc)>0)
              @foreach($candidato->experiencias_cc as $experiencia)
               <p><div class="conten-text"> {{ucwords(mb_strtoupper($experiencia->nombre_empresa))}}:</div> <span> {{\App\Models\Experiencias::añosMeses($experiencia->fecha_inicio, $experiencia->fecha_final)}} </span> <br> {{ucwords(mb_strtolower($experiencia->cargo_especifico))}} </p>
              @endforeach
            @else
                No registra
            @endif
          </td>
        @endforeach
    </tr>

    <tr>
     <th> REPORTA A </th>
      @foreach($datos_basicos as $candidato)
        <td>
        @if(count($candidato->experiencias_cc)>0)
          @foreach($candidato->experiencias_cc as $experiencia)
           {{($experiencia->cargo_jefe != '' && !is_null($experiencia->cargo_jefe))?ucwords(mb_strtolower($experiencia->cargo_jefe)):'No registra'}}
          @endforeach
        @else
          No registra
        @endif
        </td>
      @endforeach
    </tr>
          
    <tr>
      <th> PERSONAL QUE LE REPORTA </th>
      @foreach($datos_basicos as $candidato)
        <td>
        @if(count($candidato->experiencias_cc)>0)
         @foreach($candidato->experiencias_cc as $experiencia)
          {{($experiencia->le_reportan != '' && isset($experiencia->le_reportan) && !is_null($experiencia->le_reportan))?mb_strtolower($experiencia->le_reportan):'No registra'}}
         @endforeach
        @else
          No registra
        @endif
        </td>
      @endforeach
    </tr>

    <tr>
      <th> AÑOS DE EXPERIENCIA EN EL AREA / CARGO </th>
      @foreach($datos_basicos as $candidato)
        <td>
        @if(count($candidato->experiencias_c) > 0)
         @foreach($candidato->experiencias_c as $experiencia)
          {{\App\Models\Experiencias::añosMeses($experiencia->fecha_inicio,$experiencia->fecha_final)}} {{ucwords(mb_strtolower($experiencia->cargo_especifico))}}/
         @endforeach
        @else
          No registra
        @endif
        </td>
      @endforeach
    </tr>

    <tr>
        <th> GIROS DE NEGOCIO EXPERIENCIA </th>
         @foreach($datos_basicos as $candidato)
          <td>
          @if(count($candidato->experiencias_c) > 0)
            @foreach($candidato->experiencias_c as $experiencia)
             {{ucwords(mb_strtolower($experiencia->linea_negocio))}}/
            @endforeach
          @else
           No registra
          @endif
          </td>
         @endforeach
    </tr>

    <tr>
        <th> TRAYECTORIA LABORAL</th>
         @foreach($datos_basicos as $candidato)
            <td>
             @if(count($candidato->experiencias_c) > 0)
              @foreach($candidato->experiencias_c as $experiencia)
               <p style=""> <div class="conten-text"> {{ucwords(mb_strtoupper($experiencia->nombre_empresa))}}: </div> <span> {{\App\Models\Experiencias::añosMeses($experiencia->fecha_inicio,$experiencia->fecha_final)}} </span> <br> {{ucwords(mb_strtolower($experiencia->cargo_especifico))}} </p>
              @endforeach
             @else
              No registra
             @endif
            </td>
         @endforeach
    </tr>

    <tr>
        <th> CONOCIMIENTOS <br> MANEJO DE HERRAMIENTAS TECNOLÓGICAS </th>
          @foreach($datos_basicos as $candidato)
           <td style=""> 
            {{($candidato->conoc_tecnico != '')?mb_strtolower($candidato->conoc_tecnico):''}} <br> 
            {{($candidato->herr_tecnologicas != '')?mb_strtolower($candidato->herr_tecnologicas):'No registra'}} 
           </td>
          @endforeach
    </tr>

    <tr>
    
       <th> FUNCIONES </th>
        @foreach($datos_basicos as $candidato)
          <td style="">
          @if(count($candidato->experiencias_cc)>0) 
            @foreach($candidato->experiencias_cc as $experiencia)
             {{($experiencia->funciones_logros != '' || !is_null($experiencia->funciones_logros))?ucfirst($experiencia->funciones_logros):'No registra'}}
            @endforeach
          @else
            No registra
          @endif
            </td>
        @endforeach
    </tr>
          
    <tr>
     <th> LOGROS </th>
      @foreach($datos_basicos as $candidato)
        <td style="">
         @if(count($candidato->experiencias_cc)>0) 
           @foreach($candidato->experiencias_cc as $experiencia)
            {{($experiencia->logros !='' || !is_null($experiencia->logros))?ucfirst($experiencia->logros):'No registra'}}
           @endforeach
          @else
           No registra
          @endif
        </td>
      @endforeach
    </tr>

    <tr>
      <th> MOTIVO DE SALIDA DE COMPAÑIAS </th>
      @foreach($datos_basicos as $candidato)
        <td style="">
        @if(count($candidato->experiencias_c) > 0)
         @foreach($candidato->experiencias_c as $experiencia)
          @if(count($experiencia->getmotivo_retiro_des())>0)
           {{ucwords(mb_strtoupper($experiencia->nombre_empresa)).':'.$experiencia->getmotivo_retiro_des()}}/
          @endif
         @endforeach
        @else
         No registra
        @endif
        </td>
      @endforeach
    </tr>

    <tr>
    <th> IDIOMA </th>
      @foreach($datos_basicos as $candidato)
       <td style="">
        @if(count($candidato->idiomas_c) > 0)
         @foreach($candidato->idiomas_c as $idioma)
          {{ucwords(mb_strtolower($idioma->nombre_idioma->descripcion)).'-'.ucwords(mb_strtolower($idioma->nivel_idioma->descripcion)).".\n"}}
         @endforeach
        @else
         No registra
        @endif
       </td>
      @endforeach
    </tr>

    <tr>
     <th> MOTIVACIÓN PARA UN CAMBIO </th>
      @foreach($datos_basicos as $candidato)
       <td style=""> {{($candidato->motivo_cambio != '')?ucfirst($candidato->motivo_cambio):'No registra'}} </td>
      @endforeach
    </tr>

    <tr>
     <th> SALARIO </th>
      @foreach($datos_basicos as $candidato)
        <td style="text-align:center !important;">
        @if(count($candidato->experiencias_cc)>0)
         @foreach($candidato->experiencias_cc as $experiencia)
          {{($experiencia->sueldo_fijo_bruto != '')?'USD $'.$experiencia->sueldo_fijo_bruto:'No registra'}}
         @endforeach
        @else
         No registra
        @endif
        </td>
      @endforeach
    </tr>

    <tr>
     <th> BENEFICIOS </th>
      @foreach($datos_basicos as $candidato)
      <td style="">
       @if(count($candidato->experiencias_cc)>0)
         @foreach($candidato->experiencias_cc as $experiencia)
           {{($experiencia->beneficios_monetario != '' && isset($experiencia->beneficios_monetario))?ucfirst($experiencia->beneficios_monetario):'No registra'}}
         @endforeach
        @else
         No registra
        @endif
      </td>
      @endforeach
    </tr>

    <tr>
      <th> ASPIRACIÓN </th>
        @foreach($datos_basicos as $candidato)
        <td style="text-align:center !important;"> {{($candidato->aspiracion_salarial != '')?' USD $'.$candidato->aspiracion_salarial:'No registra'}} </td>
        @endforeach
    </tr>
          
    <tr>
      <th> OBSERVACIONES </th>
      @foreach($datos_basicos as $candidato)
      <td>{{''}} </td>
      @endforeach
    </tr>
  </table>

 @if($j < $load) {{--regular la cantidad de hojas q se crean--}}
  <div class="breakAlways"></div>
 @endif
 
@endforeach
 </body>
</html>