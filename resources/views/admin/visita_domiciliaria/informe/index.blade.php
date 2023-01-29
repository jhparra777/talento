<!DOCTYPE html>
<html lang="en">
<head>
<title>Informe visita</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
* {
  box-sizing: border-box;
  word-break: break-all;
}

body {
  margin: 0;
  font-family: Helvetica, sans-serif;
  color: #3498db;
  background: #fbfcfc;
}

/* Style the side navigation */
.sidenav {
  float: left;
  width: 28%;
  height: 900px;
  background-color: #1a253f;
  text-align:center;
  color: white;
  
}


.content {
  
  font-size: 11px;
  letter-spacing: 0.1px;
}
#content1{
  width: 72%;
  float: left;
}
.content div{
  width: 100%;
}
.main-pic{
  width: 80%;
  height: 150px;
  border-radius: 50%;
  outline:1px solid white;
  margin: 30px auto;
}
.main-pic img{
  width: 100%;
  height: 150px;
}

.header{
  background: #f9f9fa;
  height: 80px;
  margin-top: 0;
  position: relative;
  padding: 3em 1em;
}
.header div{
  display: inline-block;
  height: 80px;
}
.header div:first-child{
  width: 65%;
}
.header div:last-child{
  width: 30%;
}
.header div img{
 width: 100%;
}
.header h1{
  color: #1a253f;
  font-size: 2.2em;
}


.header-title {
  margin-bottom: 8px;
  text-transform: capitalize;
  letter-spacing: 0.02em;
  font-size: 17px;
  font-weight: 600;
  margin-top: 0;
  color: #1a253f;
  text-shadow: 0 0 1px rgba(239, 242, 249, 0.1);
}
.negrita{
  font-weight: bold;
}
.text-dark{
  color: #1a253f;
}
.header p,h1{
  margin: 0;
}

section{
  padding: .8em;
}
section h4{
  background: #0d3c78;
  text-align: right;
  padding: .5em;
  border-radius: 30%;
  color: white;
}
#datos-principales{
  font-size: 10px;
  margin-left: 2px;
  color: white;

}

.header-title:after {
  content: '';
  height: 3px;
  width: 80px;
  position: absolute;
  top: 32px;
  left: 16px;
  border: 1px dotted #f1646c;
  border-radius: 63px;
}
.timeline .time-item {
  position: relative;
  padding-bottom: 1px;
  border-color: #f1f5fa;
}

.timeline .time-item:after {
  position: absolute;
  bottom: 0;
  left: 0;
  top: 5px;
  width: 10px;
  height: 10px;
  margin-left: -6px;
  background-color: #f1f5fa;
  border-color: #4d79f6;
  border-style: solid;
  border-width: 2px;
  border-radius: 10px;
  content: '';
}
.timeline .item-info {
  margin-left: 15px;
  margin-bottom: 15px;
}
.col-print-7 {
    width: 58%;
    float: left;
  }
  .col-print-6 {
    width: 50%;
    float: left;
  }
.personal-detail-title {
  width: 130px;
  float: left;
  font-weight: 500;
  padding-right: 10px;
  position: relative;
  display: block;
}

.personal-detail-title:after {
  content: ":";
  position: absolute;
  right: 0;
  top: 0;
}

.personal-detail-info {
  padding-left: 100px;
  display: block;
}

#datos-principales th,td{
  text-align: left;
  word-break: break-all;


}
#datos-principales tr{
  margin-bottom: 2em;
}
.content table{
  width: 100%;
  border-radius: 30%;
  color: black;
  text-align: center;
}
.content table th,td{
  text-align: left;
}

.content table tr:nth-child(even){
  background-color: #f2f2f2;
}
.content table thead{
  background-color: #1a253f;
  color: #b6c2e4;

}
.content h5{
  background: #f2f2f2;
  text-align: center;
  padding: .5em;
  color: #0d3c78;
}


#ingresos_egresos{
  clear: both;
}
.clear-fix{
  clear: both;
}
.valor,{
  color: black;
}
.centrado{
  text-align: center;
}
.registro-fotografico .fila div{
  display: inline-block;
  width:31%;
 
  outline: 1px solid gray;
  height: 200px;
  margin: 2px;
  vertical-align: top;
  border-radius: 30%;
  position: relative;
  margin-top: 0;

}

.sec-tribu{
  display: inline-block;
  width: 48%;
  text-align: left;
}
.cursivo{
  font-style: italic;
}
#informacion-tributaria table th,#informacion-labora table th{
  text-align: left;
}
#informacion-tributaria table td,#informacion-laboral table td{
  text-align: center;
}

#informacion-tributaria table th,#informacion-laboral table th{
  color: #b6c2e4;
  background: #f2f2f2;
}
#informacion-tributaria table br,#informacion-laboral table br{
  background-color: none;
}

#aspectos-familiares ul{
  list-style-type: none;
}
#aspectos-familiares .respuesta,#recreacion .respuesta,#informacion-laboral .content{
  outline: 1px solid #d2c7e4;
  border-radius:30%;
  background: #f2f2f2;
  padding: 1.5em;
  color:#1a253f;
}
#content2{
  clear: both!important;
  float: none!important;
  widows: 100%!important;
}
.vivienda{

  display: inline-block;
  width: 48%!important;
}
.registro-fotografico .img-registro{
  width: 100%;
  height: 180px;
}
.registro-fotografico .pie{
 
  width: 100%!important;
  height: 10px!important;
  background: #0d3c78;
  color: #b6c2d6;
  padding: .5em;
  margin:0;
  text-align: center;
}
#informacion-laboral .medio{
  display: inline-block;
  width: 48%;
  outline: 1px solid gray;
}
#informacion-laboral .content{
  background: #f2f2f2;

}
p.no-data{
  text-align: center;
  font-style: italic;
}
div.no-image{
  width: 100%!important;
  height: 180px!important;
  outline: none!important;
  position: relative;


}
.no-image span{
  position: absolute;
  top: 80px;
}
#imagen-resumen-vetting{
  outline: 1px solid gray;
  width: 80%;
  height: 400px;
  margin: auto;
  margin-bottom: 1em;
}
#imagen-resumen-vetting img{
  width: 100%;
  height: 400px;
}
#text-fijo{
  text-align: justify;
}


</style>
</head>
<body>
<main>
    <div class="sidenav">
      <div class="main-pic">
        
          @if($user->foto_perfil != "")
              <img  alt="user photo" src="{{ url('recursos_datosbasicos/'.$user->foto_perfil)}}"/>
          @elseif($user->avatar != "")
              <img  alt="user photo"  src="{{ $user->avatar }}"/>
          @else
              <img alt="user photo" src="{{ url('img/personaDefectoG.jpg')}}"/>
          @endif
          
          
        
      </div>
      <h5>{{$visita->primer_nombre}} {{$visita->segundo_nombre}} {{$visita->primer_apellido}} {{$visita->segundo_apellido}}</h5>
      <br>
      <br>
      <div id="datos-principales">
       <table>

        <tr>
           <th>Identificación:</th>
           <td>{{$visita->numero_id}}</td>
         </tr>
         <tr>
           <th>Fecha expedición:</th>
           <td>{{date("d-m-Y",strtotime($visita->fecha_expedicion))}}</td>
         </tr>
         <tr>
           <th>Fecha nacimiento:</th>
           <td>{{date("d-m-Y",strtotime($visita->fecha_nacimiento))}}</td>
         </tr>
         <tr>
           <th>Tipo sangre:</th>
           <td>{{$visita->grupo_sanguineo}}
              @if($visita->rh==positivo)
                +
              @else
                -
              @endif
          </td>
         </tr>
         <tr>
           <th>Email:</th>
           <td>{{$visita->email}}</td>
         </tr>
         <tr>
           <th>Telefono movil:</th>
           <td>{{$visita->telefono_movil}}</td>
         </tr>
         <tr>
           <th>Telefono fijo:</th>
           <td>{{$visita->telefono_fijo}}</td>
         </tr>
         <tr>
           <th>Estado civil:</th>
           <td>{{$visita->estado_civil_persona}}</td>
         </tr>
         <tr>
           <th>Nivel escolaridad:</th>
           <td>{{$visita->nivel}}</td>
         </tr>
         
         <tr>
           <th>Dirección</th>
           <td>{{$visita->direccion}}</td>
         </tr>
         <tr>
           <th>Barrio</th>
           <td>{{$visita->barrio}}</td>
         </tr>
         @if($visita->numero_libreta!=null)
           <tr>
             <th>No. Libreta</th>
             <td>{{$visita->numero_libreta}}</td>
           </tr>
           <tr>
             <th>clase libreta</th>
             <td>{{$visita->clase_libreta}}</td>
           </tr>
         @endif
         
       </table>
       
      </div>
    <!--aca va la imagen y los datos principales -->
    </div>

    <div id="content1" class="content">
      <div class="header">
        <div>
          <h1>Informe Visita Domiciliaria</h1>
          
            @if(!is_null($visita->requerimiento_id))
              <h2 class="cursivo">
                {{$visita->cliente}}
              </h2>
              <P><span class="negrita">Cargo:</span>{{$visita->cargo}}</P>
            @endif
          
          
          <p>Fecha: {{date("d-m-Y",strtotime($visita->visita_candidato->fecha_gestion_admin))}}</p>
        </div>
        <div>
          
           <img class="img-main" src='{{ asset("configuracion_sitio/$logo->logo_empresa")}}'/> 
        </div>
      
        
      </div>
    

          
        
        @include('admin.visita_domiciliaria.include.informe._aspecto_vivienda')
      </div>
      <div class="clear-fix"></div>
      <div id="content2" class="content">
         @include('admin.visita_domiciliaria.include.informe._estructura_familiar')
        @include('admin.visita_domiciliaria.include.informe._ingresos_egresos')
        @include('admin.visita_domiciliaria.include.informe._bienes_inmuebles')
        @include('admin.visita_domiciliaria.include.informe._informacion_tributaria')
        @include('admin.visita_domiciliaria.include.informe._estado_salud')
        @if($candidatos->clase_visita_id!=1)
          @include('admin.visita_domiciliaria.include.informe._aspectos_familiares')
          @include('admin.visita_domiciliaria.include.informe._recreacion')
          @include('admin.visita_domiciliaria.include.informe._referencia_vecinal')
        @else
          @include('admin.visita_domiciliaria.include.informe._informacion_laboral')
        @endif
        @include('admin.visita_domiciliaria.include.informe._observaciones_generales')
        @include('admin.visita_domiciliaria.include.informe._registro_fotografico')

         <section id="verificaciones">

                    @if(count($estudios_verificados))
                        <h4>
                            VERIFICACIÓNES ACADÉMICAS 
                        </h4>
                        <?php
                            $contador2=1;
                        ?>
                        @foreach($estudios_verificados as $estudio)
                            <h5>Estudio {{$contador2}}</h5>
                           <table>
                               <tr>
                                   <th>
                                       Nombre de la institución
                                   </th>
                                   <td>
                                       {{$estudio->estudio->institucion}}
                                   </td>
                                   <th>
                                       Título obtenido
                                   </th>
                                   <td>
                                       {{$estudio->estudio->titulo_obtenido}}
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th>
                                       Fecha de título
                                   </th>
                                   <td>
                                       {{$estudio->estudio->fecha_finalizacion}}
                                   </td>
                                   <th>
                                       Número de acta
                                   </th>
                                   <td>
                                       {{$estudio->numero_acta}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       No. Folio
                                   </th>
                                   <td>
                                       {{$estudio->numero_folio}}
                                   </td>
                                   <th>
                                       Ciudad
                                   </th>
                                   <td>
                                       {{$estudio->ciudad}}
                                   </td>
                               </tr>
                                <tr>
                                   <th>
                                       No. Registro
                                   </th>
                                   <td>
                                       {{$estudio->numero_registro}}
                                   </td>
                                   <th>
                                       Quién confirma la verificación
                                   </th>
                                   <td>
                                       {{$estudio->nombre_referenciante}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       Cargo
                                   </th>
                                   <td>
                                       {{$estudio->cargo_referenciante}}
                                   </td>
                                   <th>
                                       
                                   </th>
                                   <td>
                                       
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th colspan="1">
                                       Observaciones
                                   </th>
                                   <td colspan="3">
                                       {{$estudio->observaciones}}
                                   </td>
                                   
                               </tr>
                           </table>

                           <?php
                                $contador2++;
                           ?>
                        @endforeach
                    @endif

                    @if(count($experiencias_verificadas))

                        <h4>
                            VERIFICACIÓN DE REFERENCIAS LABORALES 
                        </h4>
                        <?php
                            $contador=1;
                        ?>
                        @foreach($experiencias_verificadas as $exp)
                            <h5>Experiencia {{$contador}}</h5>
                           <table>
                               <tr>
                                   <th>
                                       Nombre de la empresa
                                   </th>
                                   <td>
                                       {{$exp->experiencia->nombre_empresa}}
                                   </td>
                                   <th>
                                       Teléfonos
                                   </th>
                                   <td>
                                       {{$exp->experiencia->telefono_temporal}}
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th>
                                       Nombre de jefe inmediato
                                   </th>
                                   <td>
                                       {{$exp->experiencia->nombres_jefe}}
                                   </td>
                                   <th>
                                       Cargo desempeñado
                                   </th>
                                   <td>
                                       {{$exp->experiencia->cargo_jefe}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       Dirección de la empresa
                                   </th>
                                   <td>
                                       {{$exp->direccion_empresa}}
                                   </td>
                                   <th>
                                       Tipo de contrato
                                   </th>
                                   <td>
                                       {{$exp->tipo_contrato}}
                                   </td>
                               </tr>
                                <tr>
                                   <th>
                                       Quién confirma la verificación
                                   </th>
                                   <td>
                                       {{$exp->nombre_referenciante}}
                                   </td>
                                   <th>
                                       Cargo
                                   </th>
                                   <td>
                                       {{$exp->cargo_referenciante}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       Motivo retiro
                                   </th>
                                   <td>
                                       {{$exp->name_motivo}}
                                   </td>
                                   <th>
                                       Labora actualmente
                                   </th>
                                   <td>
                                       {{($exp->tipo_contrato)?"Si":"No"}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       Fecha ingreso
                                   </th>
                                   <td>
                                       {{$exp->fecha_inicio}}
                                   </td>
                                   <th>
                                       Fecha retiro
                                   </th>
                                   <td>
                                       {{$exp->fecha_retiro}}
                                   </td>
                               </tr>
                               <tr>
                                   <th colspan="1">
                                       Observaciones
                                   </th>
                                   <td colspan="3">
                                       {{$exp->observaciones_referencias}}
                                   </td>
                                   
                               </tr>
                           </table>

                           <?php
                                $contador++;
                           ?>
                        @endforeach

                    @endif



                    


          </section>


      

        @if(count($vetting)>0)
              <section id="vetting">
                 <h4>
                    VETTING 
                  </h4>
                <table>
                  <tr>
                      <th>
                        Grado confiabilidad:
                      </th>
                      <td>
                        {{$vetting->grado}}
                      </td>
                      <th>
                        Descripción:
                      </th>
                      <td style="text-align: justify;">
                        {{$vetting->descripcion_grado}}
                      </td>
                  </tr>
                </table>
                <div id="imagen-resumen-vetting">
                  <img src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/vetting/$vetting->resumen")}}'>
                    
                </div>
                <div id="text-fijo">
                  <p>Debido a lo sensible de la información entregada en estos requerimientos se recomienda tener en cuenta: Se recuerda que todas las anotaciones de contrainteligencia, al igual que los antecedentes de tipo judicial están protegidos por la reserva legal. Es deber de toda autoridad asegurar la confidencialidad de la misma, de conformidad con el art. 294,418,419 y 463 del Código Penal (Ley 599/2000), art. 149 y 150, Código Penal Militar (Ley 522/99); por lo tanto, no deben ser de conocimiento de las personas relacionadas en su requerimiento.
                  Es importante tener en cuenta que el reporte no sustituye la decisión judicial, por tal motivo, la información debe ser verificada con la autoridad judicial correspondiente que aparece en el mismo, esto para descartar posibles homónimos, el delito por el cual se adelanta el proceso y el estado del mismo. Es de anotar que tal y como lo estipula la normatividad vigente, la información relacionada con anotaciones (medidas de aseguramiento y órdenes de captura), está sujeta a la reserva legal, la violación o desconocimiento a esta reserva genera para el funcionario que la viole consecuencias de orden penal, disciplinario y hasta patrimonial (acción de repetición).</p>
                </div>
                <table>
                  
                  <tr>
                      <th>
                        Concepto:
                      </th>
                      <td style="text-align: justify;">
                        {{$vetting->concepto}}
                      </td>
                  </tr>

                  <tr>
                      <th>
                        Consulta seguridad
                      </th>
                      <td>
                        @if(!is_null($visita->requerimiento_id))
                          @if(!is_null($consulta))
                            <a type="button" class="btn btn-info" target="_blank" href='{{asset("recursos_pdf_consulta/$consulta->pdf_consulta_file")}}' style="text-decoration: none;">
                                                     Ver resultado
                            </a>
                            @endif
                        @else
                          @if(!is_null($consulta))
                              <a type="button" class="btn btn-info" target="_blank" href='{{asset($consulta)}}' style="text-decoration: none;">
                                                     Ver resultado
                            </a>
                          @endif
                        @endif
                      </td>
                  </tr>
                </table>
              </section>
        @endif

        <!-- SOPORTES ACADÉMICOS -->
        @if(count($estudios_verificados))
           
            <section>
                <h4>
                  SOPORTES ACADÉMICOS 
                </h4>
                @foreach($estudios_verificados as $estudio)
                  <?php
                    $contadorEstudios=1;
                  ?>
                  @if($estudio->soportes!=null)
                    <h5>Estudio {{$contadorEstudios}}</h5>
                    <?php
                    $soportes=explode(",",$estudio->soportes);
                    $countSopEst=0;
                    ?>
                    @foreach($soportes as $sop)
                      <div id="imagen-resumen-vetting">
                      <img src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/soportes/estudio/$soportes[$countSopEst]")}}'>
                        
                      </div>
                      <?php
                        $countSopEst++;
                      ?>
                    @endforeach
                  @endif
                  <?php
                    $contadorEstudios++;
                  ?>
                @endforeach
            </section>
         
        @endif

        @if(count($experiencias_verificadas))
           
            <section>
                <h4>
                  SOPORTES LABORALES
                </h4>
                @foreach($experiencias_verificadas as $expe)
                  <?php
                    $contadorExp=1;
                  ?>
                  @if($expe->soportes!=null)
                    <h5>Experiencia {{$contadorExp}}</h5>
                    <?php
                    $soportes=explode(",",$expe->soportes);
                    $countSopLab=0;
                    ?>
                    @foreach($soportes as $sop)
                      <div id="imagen-resumen-vetting">
                      <img src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/soportes/experiencia/$soportes[$countSopLab]")}}'>
                        
                      </div>
                      <?php
                        $countSopLab++;
                      ?>
                    @endforeach
                  @endif
                  <?php
                    $contadorExp++;
                  ?>
                @endforeach
            </section>
         
        @endif
      </div>
       



    
      
   
</main>
</body>
</html>
