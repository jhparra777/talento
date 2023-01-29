@extends("admin.layout.master")
@section('contenedor')
 {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestionar visita domiciliaria"])

    
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="page-header">
                                <h4 class="tri-fw-600">
                                    INFORMACIÓN GENERAL DE LA VISITA
                                    <a type="button" class="btn btn-primary btn-sm pull-right | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('admin.visita.gestionar_informe_new',['id_visita'=>$candidato->id_visita])}}" target="_blank"><b><i class="fa fa-file-pdf-o" aria-hidden="true"></i> GENERAR INFORME</b></a>
                                </h4>

                        </div>
                    </div>
                    <h5 class="titulo1"><b>Información del candidato</b></h5>
    
                    <table class="table table-bordered">
                        <tr>
                            <th>Nombres y apellidos</th>
                            <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
                            <th>Cédula</th>
                            <td>{{$candidato->numero_id}}</td>
                        </tr>
                        <tr>
                            {{-- <th>Teléfono</th>
                            <td>{{$candidato->telefono_fijo}}</td> --}}
                            <th>Móvil</th>
                            <td>{{$candidato->telefono_movil}}</td>
                            <th>Email</th>
                            <td>{{$candidato->email}}</td>
                        </tr>
                        {{-- <tr>
                            <th>Email</th>
                            <td>{{$candidato->email}}</td>
                        </tr> --}}
                    </table>
                    <h5 class="titulo1"><b>Información de la visita</b></h5>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 160px">Clase visita</th>
                            <td>{{$candidato->clase_visita}}</td>
                        </tr>
                       
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    

        
        
        @if(!is_null($candidato->requerimiento_id))
            <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
        @endif

        
    
    <br>
    <br>

    <ul class="nav nav-tabs">
        <li class="active">

            <a data-toggle="tab" href="#visita">Visita domiciliaria 
                @if($candidato->gestionado_admin)
                    <i class="fa fa-check-circle-o" style="color: green;"></i>
            
                @endif
            </a>

        </li>
        @if($candidato->tipo_visita_id==3 && $candidato->clase_visita_id!=1)
            <li>
                <a data-toggle="tab" href="#referencia-experiencia">
                Referencias Laborales
                @if(count($experiencias_verificadas)>0)
                        <i class="fa fa-check-circle-o" style="color: green;"></i>
                @endif
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#referencia-estudio">
                    Verificaciones académicas
                    @if(count($estudios_verificados)>0)
                        <i class="fa fa-check-circle-o" style="color: green;"></i>
                @endif
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#vetting">Vetting
                    @if($candidato->vetting)
                        <i class="fa fa-check-circle-o" style="color: green;"></i>
                    @endif
                </a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <div id="visita" class="tab-pane fade in active">
            <h3>Gestión de formulario de visita domiciliaria</h3>
            <div class="jumbotron text-center">

                        @if(!$candidato->gestionado_admin)
                            <p>Para realizar la visita al evaluado, por favor haz clic en el siguiente botón</p>
                            <div>
                                <a type="button"  href="{{route('admin.visita.realizar_visita_admin',['visita_id'=>$candidato->id_visita])}}" target="_blank" class="btn btn-info" id="realizar_visita">Realizar Visita</a>
                            </div>
                        @else
                            <div class="jumbotron">
                                <h3>La visita ya ha sido gestionada</h3>
                                <div>
                                    <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;font-size: 2em;"></i>
                                    <div>
                                        <a type="button"  href="{{route('admin.visita.realizar_visita_admin',['visita_id'=>$candidato->id_visita,'edit'=>true])}}" target="_blank" class="btn btn-warning" id="realizar_visita">Editar</a>
                                        <br>
                                        <br>
                                        <button type="button" class="btn btn-primary" id="registrarLink" data-visita="{{$candidato->id_visita}}">
                                            Insertar link de la videollamada
                                        </button>
                                        {{-- <a class="btn btn-sm btn-primary" id="registrarLink" data-visita="{{$candidato->id_visita}}">Insertar link de la videollamada </a> --}}
                                    </div>

                                </div>
                            </div>
                        @endif
            </div>
        </div>

        @if($candidato->tipo_visita_id==3 && $candidato->clase_visita_id!=1)
            <div id="referencia-experiencia" class="tab-pane fade in">
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a
                            role="button"
                            style="width: 100%; display: block;"
                            data-toggle="collapse"
                            data-parent="#accordion"
                            href="#collapseOne"
                            aria-expanded="false"
                            aria-controls="collapseOne"
                        >
                            Referencias Laborales
                        </a>
                    </h4>
                </div>

                    <div class="panel-body">
                        @if(count($experiencias_laborales>0))
                        
                        @foreach($experiencias_laborales as $experiencia)
                            <div class="container_referencia">
                                <div class="referencia">
                                    <table class="table table-bordered tbl_info" style="margin-bottom: 0px;text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Nombre Empresa</th>

                                                <th>Ciudad</th>
                                                <th>Cargo Desempeñado</th>
                                                <th>Teléfono Empresa</th>
                                                <th>Verificado</th>
                                                <th>Soportes</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$experiencia->nombre_empresa}}</td>
                                                <td>{{$experiencia->ciudades}}</td>
                                                <td>{{$experiencia->cargo_especifico}}</td>
                                                <td>{{$experiencia->telefono_temporal}}
                                                <td>
                                                    @if(($experiencia->experiencia_verificada->id!=null))

                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_null($experiencia->experiencia_verificada->soportes))
                                                        <i>Sin soportes</i>
                                                    @else
                                                       
                                                        @foreach(explode(',',$experiencia->experiencia_verificada->soportes) as $clave=>$archivo)
                                                        <p><a href='{{ route("view_document_url", encrypt("recursos_visita_domiciliaria/$candidato->id_visita/soportes/experiencia/"."|$archivo"))}}' target="_blank">Soporte{{++$clave}}</a></p>

                                                       
                                                         
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(($experiencia->experiencia_verificada->id==null))
                                            <!--
                                                <a class="btn btn-success verficar_referencia" data-ref_hv="{$experiencia->id}}" >Verificado</a>  
                                            -->
                                                        <a class="btn btn-sm btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple gestionar_referencia" data-ref_hv="{{$experiencia->id}}" data-visita="{{$candidato->id_visita}}">Gestionar</a> 
                                                    @else
                                                        <a class="btn btn-warning detalle_referencia" data-ref_hv="{{$experiencia->id}}" data-visita="{{$candidato->id_visita}}">Editar</a>
                                                        <a class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right soporte_verificacion" data-ref_hv="{{$experiencia->id}}" data-visita="{{$candidato->id_visita}}"
                                                        data-tipo="experiencia">+ soportes</a>

                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>

                                {{--<div class="requerimientos">
                                    <div class="btn_procesos">
                                        
                                    </div>

                                    <h4 class="titulo1" style="margin: 0">Requerimientos</h4>

                                    @foreach($experiencia->getRequerimientos() as $req)
                                        <div class="badge">
                                            <label>
                                                {!! Form::radio("ref_gestionada",$req->entidad_id,null,["class"=>"referencias_verificadas"]) !!} 
                                                <span> Req:{{$req->requerimiento_id}} </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>--}}
                            </div>
                        @endforeach
                        @else
                            <h4>No hay registros de experiencias</h4>
                        @endif
                    </div>
                </div>
            
            </div>

            <div id="referencia-estudio" class="tab-pane fade in">
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading3">
                    <h4 class="panel-title">
                        <a class="collapsed" style="display: block;width: 100%;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Verificaciones académicas
                        </a>
                    </h4>
                </div>
            
                    <div class="panel-body">
                        @if(count($estudios>0))
                            @foreach($estudios as $estudio)
                            <div class="container_referencia">
                                <div class="referencia">
                                    <table class="table table-bordered tbl_info" style="margin-bottom: 0px;text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Nivel Estudios</th>

                                                <th>Institución</th>
                                                <th>Titulo obtenido</th>
                                                <th>Verificado</th>
                                                <th>Soportes</th>
                                                <th>Acción</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$estudio->nivel_estudio}}</td>
                                                <td>{{$estudio->institucion}}</td>
                                                <td>{{$estudio->titulo_obtenido}}</td>
                                                <td>
                                                    @if(($estudio->estudio_verificado->id!=null))
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_null($estudio->estudio_verificado->soportes))
                                                        <i>Sin soportes</i>
                                                    @else
                                                       
                                                        @foreach(explode(',',$estudio->estudio_verificado->soportes) as $clave=>$archivo)
                                                        <p><a href='{{ route("view_document_url", encrypt("recursos_visita_domiciliaria/$candidato->id_visita/soportes/estudio/"."|$archivo"))}}' target="_blank">Soporte{{++$clave}}</a></p>

                                                       
                                                         
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(($estudio->estudio_verificado->id==null))
                                                        <a class="btn btn-sm btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple gestionar_estudio" data-estudio="{{$estudio->id}}" data-visita="{{$candidato->id_visita}}">Gestionar</a>
                                                     @else
                                                        {{--<a class="btn btn-warning detalle_referencia" data-ref_hv="{{$estudio->id}}" data-visita="{{$candidato->id_visita}}">Editar</a>--}}
                                                        <a class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right soporte_verificacion" data-ref_hv="{{$experiencia->id}}" data-visita="{{$candidato->id_visita}}"
                                                        data-tipo="estudio">+ soportes</a>

                                                     @endif
                                                </td>
                                            </tr>
                                        
                                        </tbody>
                                
                                    </table>
                                </div>
     
                            </div>
                            @endforeach
                        @else
                            <h4>No hay registros de estudios realizados</h4>
                        @endif
                    </div>
                
            </div>
            </div>


            <div id="vetting" class="tab-pane fade in">
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading4">
                    <h4 class="panel-title">
                        <a class="collapsed" style="display: block;width: 100%;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            Vetting
                        </a>
                    </h4>
                </div>
                
                    <div class="panel-body">
                        @if(count($vetting)==0)
                            @if(!is_null($candidato->requerimiento_id))
                                
                             
                                   @if(is_null($consulta))
                                       <p>Para realizar la consulta de seguridad para el evaluado, por favor haz clic en el siguiente botón
                                        
                                            <button 
                                            type="button" 
                                            class="btn btn-sm btn-warning" 
                                            onclick="consultaSeguridad(
                                            '{{ route("admin.consulta_seguridad_verifica") }}',
                                            '{{ route("admin.consulta_seguridad") }}',
                                            {{ $candidato->numero_id }}, 
                                            {{ $candidato->user_id }}, 
                                            {{ $candidato->requerimiento_id }}, 
                                            {{ $candidato->cliente_id }});" 
                                             >
                                            CONSULTA DE SEGURIDAD
                                            </button>
                                        </p>
                                        
                                    @else
                                        <div class="alert alert-success">
                                             <strong>Info!</strong> Ya fue realizada una consulta de seguridad para el evaluado en el requerimiento #{{$candidato->requerimiento_id}}. Puede revisar el resultado en el siguiente botón: 
                                             <a type="button" class="btn btn-info" target="_blank" href='{{asset("recursos_pdf_consulta/$consulta->pdf_consulta_file")}}' style="text-decoration: none;">
                                                 Ver resultado
                                             </a>
                                        </div>
                                   @endif
                                   <br>
                                   <br>
                                        {!! Form::model(Request::all(),["id" => "fr_vetting", "data-smk-icon" => "fa fa-times-circle","enctype"=>"multipart/form-data"]) !!}
                                            {!! Form::hidden("visita_candidato_id",$candidato->id_visita) !!}
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                                        Grado de confiabilidad:<span></span> 
                                                    </label>
                                                    <div class="col-sm-6">
                                                         {!! Form::select("grado_confiabilidad",$grados,null,["class"=>"form-control selectcategory" ,"id"=>"grado_confiabilidad","required"=>true]) !!}
                                                    </div>
                                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                                </div>
                                                <div class="form-group col-xs-6 col-sm-6 col-sm-offset-6">
                                                    <label for="banner">Imagen resumen

                                                    </label>
                                                    <div class="input-group">
                                                            <label class="input-group-btn">
                                                                <span class="btn btn-primary btn-file">
                                                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="img_resumen" type="file" id="img_resumen">
                                                                </span>
                                                            </label>
                                                            <input class="form-control" id="IMG_RESUMEN_CAPTURA" readonly="readonly" name="img_resumen_captura" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label class="col-sm-12 pull-left" for="inputEmail3">
                                                        Concepto final:<span></span> 
                                                    </label>
                                                    <div class="col-sm-12">
                                                         {!! Form::textarea("concepto",null,["class"=>"form-control" ,"id"=>"concepto","required"=>true,"rows"=>5]) !!}
                                                    </div>
                                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-success" id="guardar-vetting" >Guardar</button>
                                            </div>
                                            
                                        {!! Form::close()!!}
                                        
                                  
                                
                            @else

                                <p>Para realizar la consulta de seguridad para el evaluado, por favor haz clic en el siguiente botón
                                        
                                            <button 
                                            type="button" 
                                            class="btn btn-sm btn-warning"
                                            id="consultaBtn"
                                            data-cedula="{{ $candidato->numero_id }}"
                                            data-visita="{{ $candidato->id_visita }}"
                                             >
                                            CONSULTA DE SEGURIDAD
                                            </button>
                                </p>
                                {!! Form::model(Request::all(),["id" => "fr_vetting", "data-smk-icon" => "fa fa-times-circle","enctype"=>"multipart/form-data"]) !!}
                                            {!! Form::hidden("visita_candidato_id",$candidato->id_visita) !!}
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                                        Grado de confiabilidad:<span></span> 
                                                    </label>
                                                    <div class="col-sm-6">
                                                         {!! Form::select("grado_confiabilidad",$grados,null,["class"=>"form-control selectcategory" ,"id"=>"grado_confiabilidad","required"=>true]) !!}
                                                    </div>
                                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                                </div>
                                                <div class="form-group col-xs-6 col-sm-6 col-sm-offset-6">
                                                    <label for="banner">Imagen resumen

                                                    </label>
                                                    <div class="input-group">
                                                            <label class="input-group-btn">
                                                                <span class="btn btn-primary btn-file">
                                                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="img_resumen" type="file" id="img_resumen">
                                                                </span>
                                                            </label>
                                                            <input class="form-control" id="IMG_RESUMEN_CAPTURA" readonly="readonly" name="img_resumen_captura" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label class="col-sm-12 pull-left" for="inputEmail3">
                                                        Concepto final:<span></span> 
                                                    </label>
                                                    <div class="col-sm-12">
                                                         {!! Form::textarea("concepto",null,["class"=>"form-control" ,"id"=>"concepto","required"=>true,"rows"=>5]) !!}
                                                    </div>
                                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                                </div>
                                                
                                                
                                                
                                            </div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-success" id="guardar-vetting" >Guardar</button>
                                            </div>
                                            
                                {!! Form::close()!!}
                                    
                           
                            @endif
                        @else
                        <div class="jumbotron text-center">
                            <h3> ¡ Vetting realizado con exito !</h3>
                            <div>
                                 <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;font-size: 2em;"></i>

                            </div>
                        </div>
                        @endif
                    </div>
                
            </div>
            </div>


        @endif
    </div>
    
   @if(count($visitas))
    <div class="row">

        <h3 class="titulo1">Visitas Realizadas</h3>

        
    
        <h4 style="color: #1183e1;" >Visitas</h4>
        
        
            
                <div class="container_referencia listas">
                    <div class="referencia">
                        <table class="table table-bordered table-striped" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th>#visita </th>
                                    <th>Fecha de gestión</th>
                                    <th>Usuario gestión</th>
                                    <th>Acción</th>
                                    
                                    <!--
                                        <th>Aspecto Familiar</th>
                                        <td>{$entrevista->aspecto_familiar}}</td>
                                    -->
                                </tr>
                            </thead>
                            @foreach($visitas as $visitas)
                                <tr>
                                    <td>{{$visitas->id}}</td>
                                    <td>{{$visitas->fecha_gestion_admin}}</td>
                                    <td>{{$visitas->user_gestion}}</td>
                                    <td>
                                        <a type="button" class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-greeny pull-right" href="" target="_blank">Ver informe</a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            <!--
                                <tr>
                                    <th>Aspectos Académicos</th>
                                    <td>{$entrevista->aspecto_academico}}</td>
                                    <th>Aspectos Experiencia</th>
                                    <td>{$entrevista->aspectos_experiencia}}</td>
                                </tr>
                            -->
                            
                        </table>
                    </div>

                    
                </div>
            

        
    </div>
    @endif
<style>
 .usar + .slide:after {
    position: absolute;
    content: "NO" !important;
 }

.usar:checked + .slide:after {
   content: "SI"  !important;
}

.listas table tr{
    text-align: center;
}
</style>

    <script>
        function validar_campos(){

         i = 0;
         message = "";
         //se validaran los campos de nombre ref*, cargo ref*, fecha inicio*, adecuado*
          c_dos =  $("#nombre_ref").val();
          c_tres = $("#cargo_ref").val();
          c_cuatro = $("#fecha_inicio").val();
          c_cinco = $("#adecuado").val();// if(c_dos.length!=0 && c_tres.length!=0){ //validar solo si se lleno 
            
            if(c_dos == ""){

             message += " Debes Colocar nombre del referenciante \n";

             i=1;

              $("#fr_referencia #nombre_ref").css('border', 'solid 1px red');
              $("#fr_referencia #nombre_ref").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #nombre_ref");

            }
            if(c_tres == ""){ message += 'Debes Escribir el cargo del referenciante';

             i=1;

              $("#fr_referencia #cargo_ref").css('border', 'solid 1px red');
              $("#fr_referencia #cargo_ref").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #nombre_ref");
              
            }
            
            if(c_cuatro == ""){ message += 'Debes Escribir el cargo del referenciante';

              i=1;

               $("#fr_referencia #fecha_inicio").css('border', 'solid 1px red');
               $("#fr_referencia #fecha_inicio").focus();
               $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #fecha_inicio");
                        
            }

            //if(i === 1){ alert(message);}
           // }else{
             // alert('Debes Llenar los campos Obligatorios');
            // i=1;
           // }
          return i;
      }

      function validar_campos_per(){

         i = 0;
         message = "";
         //se validaran los campos de nombre ref*, cargo ref*, fecha inicio*, adecuado*
          c_dos =  $("#encuestado").val();
          c_tres = $("#dificultades").val();
          c_cuatro = $("#observaciones").val();
          //c_cinco = $("#adecuado").val();// if(c_dos.length!=0 && c_tres.length!=0){ //validar solo si se lleno 
            if(c_dos == ""){

             message += " Debes Colocar nombre del referenciante \n";

             i=1;

              $("#fr_referencia #encuestado").css('border', 'solid 1px red');
              $("#fr_referencia #encuestado").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #encuestado");

            }
            if(c_tres == ""){ message += 'Debes Escribir el cargo del referenciante';

             i=1;

              $("#fr_referencia #dificultades").css('border', 'solid 1px red');
              $("#fr_referencia #dificultades").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #dificultades");
              
            }
            
            if(c_cuatro == ""){ message += 'Debes Escribir el cargo del referenciante';

              i=1;

               $("#fr_referencia #observaciones").css('border', 'solid 1px red');
               $("#fr_referencia #observaciones").focus();
               $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #observaciones");
                        
            }
            //if(i === 1){ alert(message);}
           // }else{
             // alert('Debes Llenar los campos Obligatorios');
            // i=1;
           // }
          return i;
      }
        $(function () {
         
        


            //Nueva entravista (modal)
            

            //Guardar entrevista semi

            $("#guardar-vetting").click(function(){
                if($("#fr_vetting").smkValidate()){
                     $.ajax({
                        type: "POST",
                        data: new FormData(document.getElementById("fr_vetting")),
                        url: "{{route('admin.visita.guardar_vetting')}}",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.success){
                                $.smkAlert({
                                text: 'Registro de vetting creado exitosamente',

                                type: 'success',
                                position:'top-right',
                                time:3
                                });

                                setTimeout(function(){
                                
                                    window.location.reload();
                                }, 2000);


                            }
                        }
                   });
                }
            });

    $(document).on("click", "#consultaBtn", function() {
            
       
            const numero_cedula = $(this).data("cedula");
            const visita = $(this).data("visita");

            $.ajax({
                type: "POST",
                data: {
                    'numero_cedula' : numero_cedula,
                    'id_visita': visita
                },
                url: "{{ route('admin.consulta_seguridad_verifica_view') }}",
                success: function(response) {
                    if(response.limite === true){

                        alert("Has alcanzado el limite máximo de consultas, contacta con el administrador del sistema.");

                    }else{

                        const url = "{{ route('admin.consulta_seguridad_consulta') }}";

                        const urldef = url.concat("?a="+numero_cedula);

                        window.open(urldef, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600");
                    }
                }
            });
        

    });
           

         @if(!is_null($candidato->requerimiento_id))
            $("#cambiar_estado").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: {
                        ref_id:{{$proceso->id}},
                        id_visita:{{$candidato->id_visita}}
                    },
                    url: "{{route('admin.cambiar_estado_view')}}",
                    success: function (response) {
                        console.log("af");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_estado", function () {
                $.ajax({
                    data: $("#fr_cambio_estado").serialize(),
                    url: "{{route('admin.guardar_cambio_estado')}}",
                    success: function (response) {
                        if(response.success) {
                          mensaje_success("Estado actualizado");
                          setTimeout(function(){
                             location.reload() }, 3000);
                          //window.location.href = ruta;
                        }else{

                          $("#modal_peq").find(".modal-content").html(response.view);
                        }

                    }
                });
            });

        @endif

            $(document).on("click",".entrevista_semi_utilizada", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_semi_entidad') }}",
                    success: function (response) {
                        mensaje_success("Entrevista Semi no mostrada");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                    }
                });
            });

            $(document).on("click",".entrevista_semi_utilizada2", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_semi_entidad2') }}",
                    success: function (response) {
                        mensaje_success("Entrevista Semi mostrada");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                   }
                });
            });

            $("#nueva_entrevista").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}",
                    url: "{{ route('admin.nueva_visita_domiciliaria') }}",
                    success: function (response) {
                        $('#modal_gr').modal({ backdrop: 'static', keyboard: false });
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });           

            $(document).on("click", "#guardar_entrevista", function(){
                $('.text.error').hide()
                $(this).prop("disabled",true);
                //guarda entrevista definitiva 3gh
                $.ajax({
                    type: "POST",
                    data: $("#fr_entrevista").serialize(),
                    url: "{{ route('admin.guardar_entrevista') }}",
                    success: function (response) {
                      $("#guardar_entrevista").removeAttr("disabled");
                        mensaje_success("Entrevista creada con éxito!!");

                        if(response.final == 1){
                         // window.location.href = '{{route("admin.entrevistas")}}';
                          mensaje_success("Entrevista Guardada con Exito!!");
                            setTimeout(function(){
                             location.href=ruta; }, 3000);
                        }else{
                         window.location.href = '{{route("admin.gestionar_entrevista",[$candidato->ref_id])}}';
                        }
                    },
                    error: function (response) {
                      $("#guardar_entrevista").removeAttr("disabled");
                        $.each(response.responseJSON, function(index, val){
                            $('#error-'+index).show();
                            $('#error-'+index).html(val);
                        });

                        $("#modal_peq").find(".modal-content").html(response.view);
                    }

                });
            });
         
            $(document).on("click",".entrevista_utilizada", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);
                   
                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{route('admin.registra_entrevista_entidad')}}",
                    success: function (response) {
                        var prueba = $(this).data("prueba");
                        var req = $(this).data("req");
                        mensaje_success("Entrevista no mostrada!!");
                        window.location.href = '{{route("admin.gestionar_entrevista",[$candidato->ref_id])}}'
                    }
                });
            });

            $(document).on("click",".entrevista_utilizada2", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_entidad2') }}",
                    success: function (response) {
                        mensaje_success("Entrevista  mostrada!!");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                   }
                });
            });

            $(".ver_detalle").on("click", function () {
                var id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    data: {entrevista_id: id, ref_id: "{{$candidato->ref_id}}"},
                    url: " {{ route('admin.detalle_entrevista_modal') }} ",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");   
                    }
                });
            });

            //GESTION DE REFERENCIAS

            $(".gestionar_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var id_visita=$(this).data("visita");
            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}",id_visita:id_visita},
                url: " {{route('admin.gestionar_referencia_candidato')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $(".gestionar_estudio").on("click", function () {
            var estudio = $(this).data("estudio");
            var id_visita=$(this).data("visita");
            $.ajax({
                type: "POST",
                data: {estudio_id: estudio,id_visita:id_visita},
                url: " {{route('admin.gestionar_estudio_candidato')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $("#registrarLink").on("click", function () {
            var visita = $(this).data("visita");
            $.ajax({
                type: "POST",
                data: { visita:visita},
                url: " {{route('admin.modal_enlace_visita')}} ",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(".soporte_verificacion").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var id_visita=$(this).data("visita");
            var tipo=$(this).data("tipo");
            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv,id_visita:id_visita,tipo_soporte:tipo},
                url: " {{route('admin.visita.agregar_soporte_view')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

       
        
        $(".detalle_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");

            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{route('admin.editar_referencia_candidato')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                    $("#modal_gr #ref_id").val("{{$candidato->ref_id}}");
                }
            });
        });
        
        $(".gestionar_referencia_personal").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{ route('admin.gestionar_referencia_personal_candidato') }} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        
        $(".editar_referencia_personal").on("click", function (){
            var ref_hv = $(this).data("ref_hv");

            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{ route('admin.editar_referencia_personal_candidato') }} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                    $("#modal_gr #ref_id").val("{{$candidato->ref_id}}");
                }
            });
        });

        $(".verficar_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var padre = $(this).parents(".requerimientos");
            var id_req = padre.find(".referencias_verificadas:checked").val();
            
            if(id_req == undefined){
                alert("Debe seleccionar un requerimiento.");
            }else{
                $.ajax({
                    type: "POST",
                    data: "referencia_id=" + ref_hv + "&ref_id={{$candidato->ref_id}}&req_id=" + id_req,
                    url: "{{route('admin.verificar_referencia_candidato')}}",
                    success: function (response){
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            }
        });

        $(".verficar_referencia_personal").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var padre = $(this).parents(".requerimientos");
            var id_req = padre.find(".referencias_verificadas:checked").val();
            if(id_req == undefined) {
              alert("Debe seleccionar un requerimiento.");
            }else{
                $.ajax({
                    type: "POST",
                    data: "referencia_id=" + ref_hv + "&ref_id={{$candidato->ref_id}}&req_id=" + id_req,
                    url: "{{route('admin.verificar_referencia_personal_candidato')}}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            }
            
        });

        $(document).on("click", "#guardar_nueva_referencia", function () {             
            $(this).prop("disabled",true);
              
            valid =  validar_campos();
            
            if(valid === 1){return false;} //validar si los campos estan llenos

            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),

                url: "{{route('admin.guardar_referencia_verificada')}}",
                success: function (response) {
                    $("#guardar_nueva_referencia").removeAttr("disabled");
                    if(response.success) {
                        $("#modal_gr").modal("hide");
                        mensaje_success("Referencia Verificada!!");
                        //window.location.href = "{{route('admin.gestionar_referencia',[$candidato->ref_id])}}";
                    }else{
                        $("#modal_gr").find(".modal-content").html(response.view);
                    }
                },
                error: function (response) {
                    $("#guardar_nueva_referencia").removeAttr("disabled");
                    $(document).ready(function(){
                        $(".text").remove();
                    });

                    $.each(response.responseJSON, function(index, val){
                        $('input[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('textarea[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('select[name='+index+']').after('<span  style ="color:red;" class="text">'+val+'</span>');
                    });
                    
                    $("#modal_peq").find(".modal-content").html(response.view);
                }

            })
        });

        $(document).on("click", "#guardar_nuevo_estudio", function () {             
            
            //valid =  validar_campos();
            
           
            if($('#fr_estudio').smkValidate()){
                $.ajax({
                    type: "POST",
                    data: $("#fr_estudio").serialize(),

                    url: "{{route('admin.guardar_estudio_verificado')}}",
                    success: function (response) {
                        
                        if(response.success) {
                            $("#modal_gr").modal("hide");
                            mensaje_success("Estudio Verificado!!");
                            //window.location.href = "{{route('admin.gestionar_referencia',[$candidato->ref_id])}}";
                        }else{
                            $("#modal_gr").find(".modal-content").html(response.view);
                        }
                    },
                    error: function (response) {
                      
                    }

                })
            }
        });

        $(document).on("click", "#guardar_nueva_referencia_personal", function () {
            valid =  validar_campos_per();
            
            if(valid === 1){return false;} //validar si los campos estan llenos
            
            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{ route('admin.guardar_referencia_personal_verificada') }}",
                success: function (response) {
                    if(response.success){
                     $("#modal_gr").modal("hide");
                     mensaje_success("Referencia Verificada!!");
                     window.location.href = "{{ route('admin.gestionar_referencia',[$candidato->ref_id])}}";

                    }else{
                      $("#modal_gr").find(".modal-content").html(response.view);
                    }
                }

            })
        });


         
        });
    </script>
    </style>
<script type="text/javascript">
    $(document).on('change','.btn-file :file',function(){
  var input = $(this);
  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);
});
$(document).ready(function(){
  $('.btn-file :file').on('fileselect',function(event,numFiles,label){
    var input = $(this).parents('.input-group').find(':text');
    var log = numFiles > 1 ? numFiles + ' files selected' : label;
    if(input.length){ input.val(log); }else{ if (log) alert(log); }
  });
});
</script>

@stop