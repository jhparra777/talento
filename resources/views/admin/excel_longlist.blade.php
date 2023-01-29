<?php $m = 'Carbon\Carbon'; // para calcular la edad ?>
  <table>
    <tr>
     <th colspan="5" style="text-align: left;"> CLIENTE: {{$requerimiento->nombre_cliente_req()}} </th>
    </tr>

    <tr>
      <th colspan="5" style="text-align: left;"> PROCESO: {{$requerimiento->getCargoEspecifico()->descripcion}} </th>
    </tr>

    <tr>
      <th colspan="5" style="text-align: left;"> FECHA: {{date('d/m/Y')}} </th>
    </tr>

  </table>

  <table>
    <tr>
      <th style="background-color: #ffc000;">FOTO</th>
        @foreach($datos_basicos as $candidato)
         <td colspan="2" >
          @if($candidato->foto_perfil != "")
           <img align="center" alt="user photo" height="70" src="{{ public_path().'/recursos_datosbasicos/'.$candidato->foto_perfil}}" width="80" style="margin-left: 35%;"/>
          @elseif($candidato->avatar != "")
            <img align="center" alt="user photo" height="70" src="{{ public_path().'/'.$candidato->avatar}}" width="80" style="margin-left: 35%;"/>
          @else
            <img alt="user photo" height="70" src="{{public_path().'/configuracion_sitio/'.FuncionesGlobales::sitio()->logo}}" width="80" style="margin-left: 35%;"/>
          @endif
         </td>
       @endforeach
    </tr>

    <tr>
      <th style="background-color: #ffc000;text-align: center;"> CANDIDATO </th>
      @foreach($datos_basicos as $candidato)
       <td colspan="2" style="font-weight: bold;">{{ucwords(mb_strtolower($candidato->fullname()))}} </td>
      @endforeach
    </tr>

    <tr>
      <th style=" background-color: #ffc000; text-align: center;"> EDAD/E.CIVIL/HIJOS</th>
      @foreach($datos_basicos as $candidato)
       <td colspan="2" style=""> {{($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "")?$m::parse($candidato->fecha_nacimiento)->age:"No registra"}} /{{mb_strtolower($candidato->estado_civil_des)}} {{(isset($candidato->numero_hijos))?'/'.$candidato->numero_hijos:''}} </td>
      @endforeach
    </tr>
       
    <tr>
      <th style="background-color: #ffc000; text-align: center;"> ESTUDIOS </th>
       @foreach($datos_basicos as $candidato)
        <td colspan="2">
         @if(count($candidato->pregradoEstudio()) > 0)
          {{ucwords(mb_strtolower($candidato->pregradoEstudio()->titulo_obtenido))}} / {{ucwords(mb_strtolower($candidato->pregradoEstudio()->institucion))}}
         @else
            No registra
         @endif
          @if(count($candidato->maximoEstudio()) > 0) @if($candidato->maximoEstudio()->nivel_estudio_id != 2) {{ucwords(mb_strtolower($candidato->maximoEstudio()->titulo_obtenido))}}
          / {{ucwords(mb_strtolower($candidato->maximoEstudio()->institucion))}} @endif @endif
        </td>
      @endforeach
    </tr>

    <tr>
      <th style="background-color: #ffc000;text-align: center;"> EMPRESA ACTUAL/CARGO TIEMPO </th>
        @foreach($datos_basicos as $candidato)
         <td colspan="2">
          @if(count($candidato->experiencias_cc)>0)
            @foreach($candidato->experiencias_cc as $experiencia)
             {{ucwords(mb_strtoupper($experiencia->nombre_empresa))}}: {{ucwords(mb_strtolower($experiencia->cargo_especifico))}} / {{\App\Models\Experiencias::añosMeses($experiencia->fecha_inicio, $experiencia->fecha_final)}}
            @endforeach
          @else
           No registra
          @endif
         </td>
        @endforeach
    </tr>

    <tr>
     <th style="background-color: #ffc000;text-align: center;"> REPORTA A </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style="">
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
      <th style="background-color: #ffc000;text-align: center;"> PERSONAL QUE LE REPORTAN </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style="">
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
      <th style="background-color: #ffc000;text-align: center;"> AÑOS DE EXPERIENCIA EN EL AREA/CARGO </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style="">
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
        <th style="background-color: #ffc000;text-align: center;"> GIROS DE NEGOCIO EXPERIENCIA </th>
         @foreach($datos_basicos as $candidato)
          <td colspan="2" style="">
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
        <th style="background-color: #ffc000;text-align: center;"> TRAYECTORIA LABORAL</th>
         @foreach($datos_basicos as $candidato)
            <td colspan="2" style="">
             @if(count($candidato->experiencias_c) > 0)
              @foreach($candidato->experiencias_c as $experiencia)
              {{ucwords(mb_strtoupper($experiencia->nombre_empresa))}} <br> {{ucwords(mb_strtolower($experiencia->cargo_especifico))}} ({{\App\Models\Experiencias::añosMeses($experiencia->fecha_inicio,$experiencia->fecha_final)}})
              @endforeach
             @else
              No registra
             @endif
            </td>
         @endforeach
    </tr>

    <tr>
      <th style="background-color: #ffc000;text-align: center;"> CONOCIMIENTOS MANEJO DE HERRAMIENTAS TECNOLÓGICAS </th>
        @foreach($datos_basicos as $candidato)
         <td colspan="2" style=""> 
          {{($candidato->conoc_tecnico != '')?mb_strtolower($candidato->conoc_tecnico):''}} <br> 
          {{($candidato->herr_tecnologicas != '')?mb_strtolower($candidato->herr_tecnologicas):'No registra'}} 
         </td>
        @endforeach
    </tr>

    <tr>
      <th style="background-color: #ffc000;text-align: center;"> FUNCIONES </th>
        @foreach($datos_basicos as $candidato)
          <td colspan="2" style="">
          @if(count($candidato->experiencias_cc)>0) 
            @foreach($candidato->experiencias_cc as $experiencia)
             {{($experiencia->funciones_logros != '' || !is_null($experiencia->funciones_logros))?ucwords(mb_strtolower($experiencia->funciones_logros)):'No registra'}}
            @endforeach
          @else
            No registra
          @endif
            </td>
        @endforeach
    </tr>
          
    <tr>
    <th style="background-color: #ffc000;text-align: center;"> LOGROS </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style="">
         @if(count($candidato->experiencias_cc)>0) 
           @foreach($candidato->experiencias_cc as $experiencia)
            {{($experiencia->logros !='' || !is_null($experiencia->logros))?ucwords(mb_strtolower($experiencia->logros)):'No registra'}}
           @endforeach
          @else
           No registra
          @endif
        </td>
      @endforeach
    </tr>

    <tr>
      <th style="background-color: #ffc000;text-align: center;"> MOTIVO DE SALIDA DE COMPAÑIAS </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style="">
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
    <th style="background-color: #ffc000;text-align: center;"> IDIOMA </th>
      @foreach($datos_basicos as $candidato)
       <td colspan="2">
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
     <th style=" background-color: #ffc000;text-align: center;"> MOTIVACIÓN PARA UN CAMBIO </th>
      @foreach($datos_basicos as $candidato)
       <td colspan="2" style=""> {{($candidato->motivo_cambio != '')?ucwords(mb_strtolower($candidato->motivo_cambio)):'No registra'}} </td>
      @endforeach
    </tr>

    <tr>
     <th style="background-color: #ffc000; text-align: center;"> SALARIO </th>
      @foreach($datos_basicos as $candidato)
        <td colspan="2" style=" text-align:center !important;">
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
     <th style=" background-color: #ffc000;text-align: center;"> BENEFICIOS </th>
      @foreach($datos_basicos as $candidato)
      <td colspan="2" style="">
       @if(count($candidato->experiencias_cc)>0)
         @foreach($candidato->experiencias_cc as $experiencia)
           {{($experiencia->beneficios_monetario != '' && isset($experiencia->beneficios_monetario))?ucwords(mb_strtolower($experiencia->beneficios_monetario)):'No registra'}}
         @endforeach
        @else
         No registra
        @endif
      </td>
      @endforeach
    </tr>

    <tr>
      <th style=" background-color: #ffc000;text-align: center;"> ASPIRACIÓN </th>
        @foreach($datos_basicos as $candidato)
         <td colspan="2" style=" text-align:center !important;"> {{($candidato->aspiracion_salarial != '')?' USD $'.$candidato->aspiracion_salarial:'No registra'}} </td>
        @endforeach
    </tr>

    <tr>
      <th style=" background-color: #ffc000;text-align: center;"> OBSERVACIONES </th>
      @foreach($datos_basicos as $candidato)
       <td colspan="2" style="">{{''}} </td>
      @endforeach
    </tr>
  </table>
 </body>