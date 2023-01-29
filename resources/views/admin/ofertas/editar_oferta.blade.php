@extends("admin.layout.master")
@section("contenedor")
    <style>
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .check-pd{ padding: 4.5px; }

        .jqte{
            margin: 0 !important;
        }

        .vertical-flex{ display: flex; align-items: center; }

        .toggle {
            --width: 50px;
            --height: calc(var(--width) / 2);
            --border-radius: calc(var(--height) / 2);

            display: inline-block;
            cursor: pointer;
        }

        .toggle__input { display: none; }

        .toggle__fill {
            position: relative;
            width: var(--width);
            height: var(--height);
            border-radius: var(--border-radius);
            background: #dddddd;
            transition: background 0.2s;
        }

        .toggle__input:checked ~ .toggle__fill { background: #008d4c; }

        .toggle__fill::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: var(--height);
            width: var(--height);
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            border-radius: var(--border-radius);
            transition: transform 0.2s;
        }

        .toggle__input:checked ~ .toggle__fill::after { transform: translateX(var(--height)); }

        .nopad {
        padding-left: 0 !important;
        padding-right: 0 !important;
        }
        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            margin-bottom: 0;
            outline: 0;
        }
        .image-checkbox input[type="radio"] {
            display: none;
        }

        .image-checkbox-checked {
            border-color: #4783B0;
        }
        .image-checkbox .fa {
          position: absolute;
          color: #4A79A3;
          background-color: #fff;
          padding: 10px;
          top: 0;
          right: 0;
        }
        .image-checkbox-checked .fa {
          display: block !important;
        }
    </style>

    @if(Session::has('preguntas_oferta'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <ul>
                <li>{!! Session::get('preguntas_oferta') !!}</li>
            </ul>
        </div>
    @endif


    <h3>Editar Oferta</h3>

    {!! Form::model($requerimiento, ["route" => "admin.actualizar_oferta"]) !!}
        {!! Form::hidden("req_id", $requerimiento->id) !!}
        {!! Form::hidden("fecha_publicacion", $requerimiento->fecha_publicacion) !!}

        
        <div class="col-md-12">
            <div class="box box-info collapsed-box | tri-bt-purple tri-br-1">
                <div class="box-header with-border">
                    <h3 class="box-title | tri-fs-14">
                        Informacion Básica del Requerimiento 
                        
                    </h3>

                    <div class="box-tools pull-right">
                        <button 
                            type="button"
                            class="btn btn-box-tool" 
                            data-widget="collapse" 

                            data-toggle="tooltip"
                            data-placement="top"
                            data-container="body"
                            title="Despliega para ver la información del requerimiento.">
                            <i class="fa fa-eye" aria-hidden="true"></i> Ver más
                        </button>
                    </div>
                </div>
                 <div class="box-body">
                    <div class="chart">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered tbl_iinfo">
                                    <tr>
                                        <th>No. Oferta</th>
                                        <td>{{ $requerimiento->id }}</td>
                                        @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")

                                        @else
                                            <th>Cliente</th>
                                            <td>{{ $cliente->nombre }}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th>Fecha ingreso requerimiento</th>
                                        <td>{{ $requerimiento->created_at }}</td>
                                        <th>Fecha limite requerimiento</th>
                                        <td>{{ $requerimiento->fecha_terminacion }}</td>
                                    </tr>

                                    <tr>
                                        @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                        @else
                                            <th>Tipo de solicitud</th>
                                            <td>{{ $requerimiento->tipo_proceso }}</td>
                                            <th>Contacto</th>
                                            <td>{{ $cliente->contacto }}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                            <th>Cargo específico</th>
                                            <td>{{ $requerimiento->cargo }}</td>
                                        <th>Número vacantes</th>
                                        <td>{{ $requerimiento->num_vacantes }}</td>
                                    </tr>

                                    <tr>
                                        @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                            <th>Sede</th>
                                        @else
                                            <th>Ciudad</th>
                                        @endif
                                        <td colspan="4">{{ $requerimiento->getUbicacion() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
        

        <button class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-req="{{ $requerimiento->id }}" id="detalle_req" type="button">Detalle Requerimiento</button>

        <div class="btn-group">
            <button type="button" class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" >
                Crear preguntas
            </button>
            <button type="button" class="btn btn-default dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    @if($user_sesion->hasAccess("boton_crear_pregunta"))
                        <button
                            type="button"
                            data-req="{{ $requerimiento->id }}"
                            data-cargo_id="{{ $requerimiento->cargo_id }}"
                            class="btn btn-default btn-sm btn-block btn_aprobar_cliente_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            id="definir_preguntas"
                        >
                            Definir Cantidad Preguntas
                        </button>
                    @endif
                </li>

                <li>
                    @if($user_sesion->hasAccess("boton_crear_pregunta"))
                        <button
                            type="button"
                            data-req="{{ $requerimiento->id }}"
                            data-cargo_id="{{ $requerimiento->cargo_id }}"
                            class="btn btn-default btn-sm btn-block btn_aprobar_cliente_masivo | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                            id="crear_preg"
                        >
                            Crear Pregunta
                        </button>
                    @endif
                </li>

                <li>
                    @if($user_sesion->hasAccess("boton_crear_prueba_idioma"))
                        <button
                            type="button"
                            data-req="{{ $requerimiento->id }}"
                            data-cargo_id="{{ $requerimiento->cargo_id }}"
                            class="btn btn-block btn-primary crear_prueba_idio"
                            id="crear_prueba_idio"
                        >
                            Crear Prueba Idioma
                        </button>
                    @endif
                </li>
            </ul>
        </div>

        @if($user_sesion->hasAccess("boton_crear_pregunta"))
            @if($preguntas_req->count() != 0)
                <button
                    type="button"
                    data-cargo_id="{{ $requerimiento->cargo_id }}"
                    data-req="{{ $requerimiento->id }}"
                    class="btn btn-primary ver_ranking"
                    id="ver_ranking"
                >
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Ver ranking ajuste de perfil
                </button>

                <button
                    type="button"
                    data-cargo_id="{{ $requerimiento->cargo_id }}"
                    data-req="{{ $requerimiento->id }}"
                    class="btn btn-primary ver_respuestas"
                    id="ver_respuestas"
                >
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    Ver Respuestas
                </button>
            @endif

            {{-- Lista de preguntas --}}
            <div class="col-md-12 col-lg-12 mt-2">
                <div class="row">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">PREGUNTAS DEL REQUERIMIENTO</h3>
                        </div>

                        <div class="box-body table-responsive no-padding">
                            <table class="table table-bordered" id="tbl_preguntas">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Filtro</th>
                                        <th>Tipo de pregunta</th>
                                        <th>Respuestas</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($preguntas_oferta as $count => $pregunta)
                                        <tr id="tr_{{ $pregunta->id }}">
                                            <td>
                                                {{ $pregunta->descripcion }}
                                            </td>
                                            <td>
                                                {{ (($pregunta->filtro == 1) ? "Si" : "No") }}
                                            </td>
                                            <td>
                                                {{ $pregunta->tipo_pregunta_descripcion }}
                                            </td>

                                            <td>
                                                @if($pregunta->tipo_id == 3)
                                                    <p>No tiene respuestas</p>
                                                @elseif($pregunta->tipo_id == 4)
                                                    <p>Pregunta idioma</p>
                                                @else
                                                    @foreach($pregunta->respuestas_pregunta() as $index => $respuestas)
                                                        <div id="respuestas" >
                                                            <b>{{ ++$index }}</b>. {{ $respuestas->descripcion }}<br> 
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>

                                            @if($pregunta->activo == 1 )
                                                <td class="text-center">
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        id="editar_pregunta"
                                                        data-pregunta_id="{{ $pregunta->id }}"
                                                    >
                                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        EDITAR PREGUNTA
                                                    </button>

                                                    <a
                                                        class="btn btn-primary btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        target="_black"
                                                        data-preg_id ={{ $pregunta->id }}
                                                    >
                                                        INACTIVAR 
                                                    </a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    {{--
                                                        <a class="btn btn-warning btn-sm " target="_black" data-preguntas_req="{{ $pregu->id }}">
                                                            EDITAR PREGUNTA
                                                        </a>
                                                    --}}

                                                    <a 
                                                        class="btn btn-success btn-sm btn-block btn_activar" 
                                                        target="_black" 
                                                        data-preg_id={{ $pregunta->id }}
                                                    >
                                                        ACTIVAR
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>       
                </div>
            </div>
        @endif

        <div class="row mt-2">
            <div class="col-md-12 mb-2">
                <label>¿ Publicar Oferta ?</label>

                {!! Form::checkbox("estado_publico", 1, null, [
                    "style" => "width: 100px !important;",
                    "class" => "checkbox-preferencias",
                    "id"=>"estado_publico",
                    "checked"
                ]) !!}
            </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha límite para postulaciones:</label>
                            {!! Form::text("fecha_tope_publicacion",$requerimiento->fecha_tope_publicacion, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Fecha límite","id"=>"fecha_tope_publicacion"]); !!}

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!}</p>
                    </div>
                 </div>
            

            <div class="col-md-12 ">
                @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                @else
                    <label class="control-label" for="descripcion_oferta">Detalle Oferta</label>
                @endif

                @if(route('home') == "http://vym.t3rsc.co")
                    <div class="col-sm-12">
                        {!! Form::textarea("descripcion_oferta", ($requerimiento->descripcion_oferta) ? $requerimiento->descripcion_oferta : $mensaje_listos, [
                            "style" => "width: 100%;",
                            "rows" => "10",
                            "placeholder" => "Describa las caracteristicas de la oferta",
                            "id"  =>  "descripcion_oferta"
                        ]); !!}
                    </div>
                @elseif(route('home') == "http://komatsu.t3rsc.co")
                @else
                    {!! Form::textarea("descripcion_oferta", ($requerimiento->descripcion_oferta) ? $requerimiento->descripcion_oferta : $mensaje, [
                        "style" => "width: 100%;",
                        "rows" => "10",
                        "placeholder" => "Describa las caracteristicas de la oferta",
                        "id" => "descripcion_oferta"
                    ]); !!}
                @endif

                <p class="error text-danger direction-botones-center">
                    {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                </p>
            </div>

            {{--RECLUTAMIENTO PURO --}}
            @if($requerimiento->reclutamiento_puro)
                <div class="col-md-6">
                    <label for="tipo_reclutamiento">
                        Tipo reclutamiento:
                    </label>

                    {!! Form::select("tipo_reclutamiento", $tipo_reclutamiento, $requerimiento->tipo_reclutamiento,[
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "tipo_reclutamiento"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("tipo_reclutamiento", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="pago_por">
                        Pago por:
                    </label>

                    {!! Form::select("pago_por", $motivo_pago, $requerimiento->pago_por,[
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "pago_por"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("pago_por", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="precio_hv">
                        Precio HV:
                    </label>

                    {!! Form::text("precio_hv", $requerimiento->precio_hv, [
                        "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "style" => "width: 100%;",
                        "placeholder" => "Escriba el precio de la HV"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("precio_hv", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="cantidad_hv">
                        Cantidad HV:
                    </label>

                    {!! Form::text("cantidad_hv", $requerimiento->cantidad_hv, [
                        "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "style" => "width: 100%;",
                        "placeholder" => "Escriba la cantidad de HV"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("cantidad_hv", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="fecha_cierre_externo">
                        Fecha cierre:
                    </label>

                    {!! Form::text("fecha_cierre_externo", $requerimiento->fecha_cierre_externo, [    
                        "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "style" => "width: 100%;",
                        "id"=> "fecha_cierre_externo"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("fecha_externo", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="hora_cierre_externo">
                        Hora cierre:
                    </label>

                    {!! Form::text("hora_cierre_externo", $requerimiento->hora_cierre_externo, [
                        "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "style" => "width: 100%;"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("hora_externo", $errors) !!}
                    </p>
                </div>

                <div class="col-md-6">
                    <label for="cluster">
                        Cluster:
                    </label>

                    {!! Form::select("cluster", $clusters, $requerimiento->cluster,[
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "cluster"
                    ]); !!}

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("pago_por", $errors) !!}
                    </p>
                </div>
            @endif

            @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                <br><br>

                <div class="col-md-12">
                    <label class="control-label" for="inputEmail3">
                        Misión
                    </label>

                    <div class="col-sm-12">
                        {!! Form::textarea("funciones", null, [
                            "style" => "width: 100%;",
                            "rows" => "5",
                            "placeholder" => "Escriba la misión del cargo"
                        ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                    </p>
                </div>

                <div class="col-md-12">
                    <br>

                    <label class="control-label">REQUISITOS</label>
                    
                    <br><br>

                    <label class="control-label" for="inputEmail3">
                        Formación Académica
                    </label>
                    
                    <div class="col-sm-12">
                        {!! Form::textarea("formacion_academica", null, [
                            "style" => "width: 100%;",
                            "rows" => "4",
                            "placeholder" => "Escriba la formación académica"
                        ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                    </p>
                </div>

                <div class="col-md-12">
                    <label class="control-label" for="inputEmail3">
                        Experiencia Laboral
                    </label>
                    
                    <div class="col-sm-12">
                        {!! Form::textarea("experiencia_laboral", null, [
                            "style" => "width: 100%;",
                            "rows" => "4",
                            "placeholder" => "Escriba la experiencia laboral"
                        ]); !!}
                    </div>
                    
                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                    </p>
                </div>

                <div class="col-md-12">
                    <label class="control-label" for="inputEmail3">
                        Conocimientos
                    </label>
                    
                    <div class="col-sm-12">
                        {!! Form::textarea("conocimientos_especificos", null, [
                            "style" => "width: 100%;",
                            "rows" => "4",
                            "placeholder" => "Escriba los conocimientos requeridos"
                        ]); !!}
                    </div>
                    
                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                    </p>
                </div>

                <div class="col-md-12">
                    <br>
                    {{-- <label class="control-label" for="inputEmail3">
                        Conocimientos
                    </label> --}}
                    
                    <div class="col-sm-12">
                        {!! Form::textarea("descripcion_oferta", $mensaje_koma, [
                            "style" => "width: 100%;",
                            "rows" => "10",
                            "placeholder" => "Describa las caracteristicas de la oferta"
                        ]); !!}
                    </div>

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre", $errors) !!}
                    </p>
                </div>
            @else
            @endif

            <br>
            <div class="col-md-12 col-lg-12 mt-2">
                <div class="row">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Imagen de la oferta(opcional)</h3>
                            <a class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right" id="add-img" data-cargo_id="{{$requerimiento->cargo_generico_id}}">+ Imagen</a>
                        </div>

                        <div class="box-body table-responsive no-padding" style="height: 220px;overflow: scroll;">

                            <!-- aqui van las imagenes -->
                            <!-- 
                            Image Checkbox Bootstrap template for multiple image selection
                            https://www.prepbootstrap.com/bootstrap-template/image-checkbox
                            -->
                           
                            <div class="container" id="container-img-oferta" >
                              @if(count($imagenes_cargo))
                                  @foreach($imagenes_cargo as $imagen)
                                      <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                                        <label class="image-checkbox">
                                          <img class="img-responsive" src='{{asset("imagenes_cargos/$imagen->nombre")}}' />
                                          <input type="radio" name="imagen" value="{{$imagen->id}}" @if($requerimiento->imagen_oferta==$imagen->id) checked=true @endif />
                                          <i class="fa fa-check hidden"></i>
                                        </label>
                                      </div>
                                  @endforeach
                              @else
                              <div class="jumbotron" id="empty-message">
                                  <h3 style="text-align: center;">No hay imágenes en la galería</h3>
                              </div>
                              @endif
                              <!--<div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                                <label class="image-checkbox">
                                  <img class="img-responsive" src="https://dummyimage.com/600x400/000/fff" />
                                  <input type="radio" name="imagen" value="2" />
                                  <i class="fa fa-check hidden"></i>
                                </label>
                              </div>
                              <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                                <label class="image-checkbox">
                                  <img class="img-responsive" src="https://dummyimage.com/600x400/000/fff" />
                                  <input type="checkbox" name="image[]" value="" />
                                  <i class="fa fa-check hidden"></i>
                                </label>
                              </div>
                              <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                                <label class="image-checkbox">
                                  <img class="img-responsive" src="https://dummyimage.com/600x400/000/fff" />
                                  <input type="checkbox" name="image[]" value="" />
                                  <i class="fa fa-check hidden"></i>
                                </label>
                              </div>
                              <div class="col-xs-4 col-sm-3 col-md-2 nopad text-center">
                                <label class="image-checkbox">
                                  <img class="img-responsive" src="https://dummyimage.com/600x400/000/fff" />
                                  <input type="checkbox" name="image[]" value="" />
                                  <i class="fa fa-check hidden"></i>
                                </label>
                              </div>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 text-right">
                <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ route('admin.ofertas') }}">Volver</a>
                <button class="btn btn-success mt-5">Actualizar Oferta</button>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="modal fade" id="modal_resultados_x_candidato" style="z-index: 2000;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <script>
        $(function () {
            

            $("#descripcion_oferta").jqte({
                placeholder: "Ingresa la descripción de la oferta",
                center: false,
                color: false,
                fsize: false,
                format: false,
                b: false,
                i: false,
                link: false,
                ol: false,
                outdent: false,
                remove: false,
                rule: false,
                source: false,
                u: false,
                ul: false,
                unlink: false,
                sub: false,
                sup: false
            });

            var confDatepicker2 = {
                altFormat: "yy-mm-dd",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                buttonImage: "img/gifs/018.gif",
                buttonImageOnly: true,
                autoSize: true,
                dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                yearRange: "1930:2050",
                minDate:new Date()
            };

            $("#fecha_cierre_externo").datepicker(confDatepicker2);
            $("#fecha_tope_publicacion").datepicker(confDatepicker2);

            const table_preguntas = $('#tbl_preguntas').DataTable({
                "searching": false,
                "responsive": true,
                "paginate": true,
                "autoWidth": true,
                "lengthChange": false,
                "pageLength": 4,
                "language": {
                    "url": '{{ url("js/Spain.json") }}'
                }
            })

            //Definir cantidad preguntas
            $("#definir_preguntas").on("click", function () {
                const req_id = $(this).data("req");
                const cargo_id = $(this).data("cargo_id");

                $.ajax({
                    data: {
                        req_id: req_id,
                        cargo_id: cargo_id
                    },
                    url: "{{ route('admin.definir_cantidad_preguntas') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            //Crear pregunta
            $("#crear_preg").on("click", function () {
                const req_id = $(this).data("req");
                const cargo_id = $(this).data("cargo_id");

                $.ajax({
                    data: {
                        req_id: req_id,
                        cargo_id: cargo_id
                    },
                    url: "{{ route('admin.crear_pregunta_req') }}",
                    success: function (response) {
                        if(response.no_definidas) {
                            $.smkAlert({
                                text: 'Debes definir el número de preguntas para la oferta. En la opción <b>Definir Cantidad Preguntas</b>',
                                type: 'danger',
                                icon: 'glyphicon-remove',
                                permanent: true
                            });
                        }else {
                            $("#modal_gr").find(".modal-content").html(response);
                            $("#modal_gr").modal("show");
                        }
                    }
                });
            });

            //Guardar pregunta
            $(document).on("click", "#guardar_preg", function () {
                if($('#frm_crear_pregunta').smkValidate()) {
                    $(this).prop("disabled", false)

                    const options = document.querySelectorAll('#nueva_opcion_descripcion')

                    let emptyOption = false;

                    options.forEach((option) => {
                        if(option.value == "")
                            emptyOption = true
                    })

                    if(emptyOption == true) {
                        let form_group_nuevas_opciones = document.querySelectorAll('#form_group_nuevas_opciones')
                        
                        for (var i = 0; i < form_group_nuevas_opciones.length; ++i) {
                           form_group_nuevas_opciones[i].classList.add('has-error')
                        }

                        $.smkAlert({
                            text: 'Debes completar los campos de opciones definidos.',
                            type: 'danger',
                            icon: 'glyphicon-remove'
                        });

                        //Remover clase de error
                        setTimeout(() => {
                            for (var i = 0; i < form_group_nuevas_opciones.length; ++i) {
                               form_group_nuevas_opciones[i].classList.remove('has-error');
                            }
                        }, 2000)
                    }else{

                        $.ajax({
                            type: "POST",
                            data: $("#frm_crear_pregunta").serialize(),
                            url: "{{ route('admin.guardar_pregunta_cargo') }}",
                            beforeSend: function() {
                                $.smkAlert({
                                    text: 'Creando pregunta ...',
                                    type: 'info'
                                });
                            },
                            success: function (response) {
                                $("#modal_gr").modal("hide");

                                if(response.no_definidas){
                                    $.smkAlert({
                                        text: 'Debes definir el número de preguntas para la oferta.',
                                        type: 'danger',
                                        icon: 'glyphicon-remove',
                                        permanent: true
                                    });
                                }

                                if(response.limite){
                                    $.smkAlert({
                                        text: 'Has llegado al limite de preguntas definido para la oferta.',
                                        type: 'danger',
                                        icon: 'glyphicon-remove',
                                        permanent: true
                                    });
                                }

                                if(response.limite_porcentaje){
                                    $.smkAlert({
                                        text: 'No puedes sobrepasar el 100%, debes modificar el pero porcentual de las preguntas creadas en <b>Definir Cantidad Preguntas</b>',
                                        type: 'danger',
                                        icon: 'glyphicon-remove',
                                        permanent: true
                                    });
                                }

                                if(response.success){
                                    $.smkAlert({
                                        text: 'Pregunta creada correctamente.',
                                        type: 'success'
                                    });

                                    setTimeout(() => {
                                        window.location.reload(true)
                                    }, 1500)
                                }
                            },
                            error:function(response) {
                                $.smkAlert({
                                    text: 'Ha ocurrido un error, intente nuevamente.',
                                    type: 'danger'
                                });
                            }
                        });
                    }
                }
            });

            //
            $(document).on("click",".agregar_pregunta", function () {
                const preguntas_req = $(this).data("preguntas_req");
                const req_id = $(this).data("req_id")

                $.ajax({
                    data: {
                        pregunta_req_id: preguntas_req,
                        req_id: req_id
                    },
                    url: "{{ route('admin.agregar_pregunta_req') }}",
                    success: function (response) {
                        mensaje_success("Se ha agregado la pregunta al requerimiento con éxito.")

                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    }
                });
            });

            //Editar pregunta
            $(document).on("click", "#editar_pregunta", function () {
                const pregunta_id = $(this).data("pregunta_id");

                $.ajax({
                    data: {
                        pregunta_id: pregunta_id
                    },
                    url: "{{ route('admin.editar_pregunta_req') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            //Actualizar pregunta
            $(document).on("click", "#actualizar_preg", function() {
                if($('#frm_editar_pregunta').smkValidate()) {
                    $(this).prop("disabled", true)

                    $.ajax({
                        type: "POST",
                        data: $("#frm_editar_pregunta").serialize(),
                        url: "{{ route('admin.actualizar_pregunta_req') }}",
                        beforeSend: function(response) {
                            $.smkAlert({
                                text: 'Cargando información ...',
                                type: 'info'
                            });
                        },
                        success: function(response) {
                            $.smkAlert({
                                text: 'Pregunta editada correctamente.',
                                type: 'success'
                            });

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                        },
                        error: function(response) {
                            $.smkAlert({
                                text: 'Ha ocurrido un error, intente nuevamente.',
                                type: 'danger'
                            });

                            $(this).prop("disabled", false)
                        }
                    })
                }
            })

            //
            $("#detalle_req").on("click", function () {
                const req = $(this).data("req");
                
                $.ajax({
                    data: {
                        id: req
                    },
                    url: "{{ route('admin.detalle_requerimiento') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            //
            $(document).on("click",".btn_inactivar", function () {
                const preg_id = $(this).data("preg_id");
                const btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {
                        preg_id: preg_id
                    },
                    url: "{{ route('admin.inactivar_pregunta') }}",
                    success: function (response) {
                        const prueba = $(this).data("prueba");
                        const req = $(this).data("req");
                        mensaje_success("Pregunta inactiva.");

                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    }
                });
            });

            $(document).on("click",".btn_activar", function () {
                const preg_id = $(this).data("preg_id");
                const btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {
                        preg_id: preg_id
                    },
                    url: "{{ route('admin.activar_pregunta') }}",
                    success: function (response) {
                        const prueba = $(this).data("prueba");
                        const req = $(this).data("req");

                        mensaje_success("Pregunta activa.");

                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    }
                });
            });

            //--- Crear prueba idioma, pregunta
            $("#crear_prueba_idio").on("click", function () {
                const req_id = $(this).data("req");
                const cargo_id = $(this).data("cargo_id");

                $.ajax({
                    data: {
                        req_id: req_id,
                        cargo_id: cargo_id
                    },
                    url: "{{ route('admin.crear_pregunta_prueba_idio') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_preg_prueba_idioma", function () {
                $(this).prop("disabled", false);

                $.ajax({
                    type: "POST",
                    data: $("#fr_preg_prueba_idioma").serialize(),
                    url: "{{ route('admin.guardar_pregunta_prueba_idioma') }}",
                    success: function (data) {
                        $.smkAlert({
                            text: 'Pregunta creada correctamente.',
                            type: 'success'
                        });

                        setTimeout(() => {
                            window.location.reload(true)
                        }, 1500)
                    },
                    error:function(data) {
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intente nuevamente.',
                            type: 'danger'
                        });
                    }
                });
            });

            //--
            $("#ver_ranking").on("click", function () {
                const req_id = $(this).data("req")
                const cargo_id = $(this).data("cargo_id")

                $.ajax({
                    data: {
                        req_id: req_id,
                        cargo_id : cargo_id
                    },
                    url: "{{ route('admin.ver_ranking') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            //
            $("#ver_respuestas").on("click", function () {
                const req_id = $(this).data("req");
                const cargo_id = $(this).data("cargo_id")

                $.ajax({
                    data: {
                        req_id: req_id,
                        cargo_id: cargo_id
                    },
                    url: "{{ route('admin.ver_respuestas') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });


                        // image gallery
            // init the state from the input
            $(".image-checkbox").each(function () {
              if ($(this).find('input[type="radio"]').first().attr("checked")) {
                $(this).addClass('image-checkbox-checked');
              }
              else {
                $(this).removeClass('image-checkbox-checked');
              }
            });

            // sync the state to the input
            $(".image-checkbox").on("click", function (e) {

                $(".image-checkbox").each(function () {
     
                    $(this).removeClass('image-checkbox-checked');
                  
                });
              $(this).toggleClass('image-checkbox-checked');
              var $checkbox = $(this).find('input[type="radio"]');
              $checkbox.prop("checked",!$checkbox.prop("checked"))

              e.preventDefault();
            });

            $("#add-img").click(function(){

                let cargo_id=$(this).data("cargo_id");
                $.ajax({
                    url: "{{ route('admin.oferta.add_img') }}",
                    type: "POST",
                    data:{
                        cargo_id:cargo_id
                    },
                    /*beforeSend: function(){
                        //imagen de carga
                        $.blockUI({
                            message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                            css: {
                                border: "0",
                                background: "transparent"
                            },
                            overlayCSS:  {
                                backgroundColor: "#fff",
                                opacity:         0.6,
                                cursor:          "wait"
                            }
                        });
                    },*/
                    success: function(response) {
                        $.unblockUI();
                        console.log("success");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
        
            });



            
        });
    </script>
@stop
