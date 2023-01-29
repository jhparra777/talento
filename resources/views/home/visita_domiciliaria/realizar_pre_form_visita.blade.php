<?php
    $sitio = FuncionesGlobales::sitio();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    ?>
    <meta content="T3RS" name="author">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{csrf_token()}}" name="token">

    <title>{{ $configuracion_sst->titulo_prueba }}</title>

    @if($sitio->favicon)
        @if($sitio->favicon != "")
          <link href="{{ url('configuracion_sitio')}}/{{$sitio->favicon }}" rel="shortcut icon">
        @else
          <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif
   
    <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}"></script>
    
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script> --}}

    {{-- drawingboard JS --}}
    <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>

    {{-- Webcam JS - Pictures --}}
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

    {{-- SmokeJS - CSS --}}
    <link rel="stylesheet" href="{{ asset("js/smoke/css/smoke.min.css") }}">

    <script>
        $(function () {
            @if(empty($candidatos))
                window.location.href= '{{ route("datos_basicos") }}';
            @endif
        });
    </script>

    <script>
        $(function () {
            $.ajaxSetup({
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                }
            });
        });
    </script>

    <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ route('generar_css_cv') }}"/>
    <link href="{{ url('public/css/responsive_style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

    <style>
        label { display: block; }

        textarea {
            box-sizing: border-box; font: 12px arial;
            height: 200px; margin: 5px 0 15px 0;
            padding: 5px 2px; width: 100%;  
        }

        .borderojo { outline: none; border: solid #f00 !important; }
        .bordegris { border: 1px solid #d4d4d; }

        .swal2-popup {
            font-size: 1.6rem !important;
        }

        .form-check-input{ float: left; }

        .form-check{ text-align: left; }

        .pointer {
            cursor: pointer;
        }

        .m-checkbox {
            margin-top: 4px !important;
            margin-right: 10px !important;
            margin-bottom: 15px !important;
        }

        .d-none { display: none !important; }

        .preg-faltante {
            color: #801f1f;
        }

        label{
            font-size: 15px;
            font-weight: 500;
        }

        a {
            text-decoration-thickness: 2px !important;
            color: blue;
        }

        a:hover {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }

        a:link { 
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }
      
        a:visited {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }

        a:active {
            text-decoration-thickness: 2px !important;
            color: blue !important;
        }
    </style>
</head>
<body>
    <div class="col-md-10 col-md-offset-1 col-right-item-container" style="text-align:justify !important;">
        <div class="container-fluid">
            @if(Session::has("mensaje_success"))
                <div class="col-md-12" id="mensaje-resultado">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            @endif 

            <table width="100%" style="margin-left: -37px;">
                <tr>
                    <th class="col-md-12 text-left">
                        @if($logo != "")
                            <img style="margin-top: 10px;" alt="Logo" class="izquierda" height="auto" src="{{url('configuracion_sitio')}}/{!!$logo!!}" width="150">
                        @elseif(isset($sitio->logo))
                            @if($sitio->logo != "")
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="150">
                            @else
                                <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{ asset('img/logo.png')}}" width="150">
                            @endif
                        @else
                            <img style="margin-top: 10px;" alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    </th>
                </tr>
            </table>
      
            <div class="col-md-12 text-center">
                <h2>{{ $configuracion_sst->titulo_prueba }}</h2>
            </div>

            <div class="col-md-12">
                @if($configuracion_sst->instrucciones_prueba != '' && $configuracion_sst->instrucciones_prueba != null)
                    <div class="alert alert-info" style="font-size: 18px; margin-top: 1rem;">
                        {!! $configuracion_sst->instrucciones_prueba !!}
                    </div>
                @endif
            </div>

            {!! Form::open(["id" => "fr_evaluacion"]) !!}
                {!! Form::hidden("candidato_req", $candidatos->req_can_id, ["id" => "candidato_req_fr"]) !!}
                
                <?php 
                    $nro_preg = 0;
                ?>
                <h3>I. Datos identificacion del aspirante</h3>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            Primer nombre <span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("primer_nombre",$candidatos->primer_nombre,["required","class"=>"
                            form-control","id"=>"primer_nombre"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            Segundo nombre <span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("segundo_nombre",$candidatos->segundo_nombre,["required","class"=>"
                            form-control","id"=>"segundo_nombre"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            Primer apellido <span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("primer_apellido",$candidatos->primer_apellido,["required","class"=>"
                            form-control","id"=>"primer_apellido"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            Segundo apellido <span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("segundo_apellido",$candidatos->segundo_apellido,["required","class"=>"
                            form-control","id"=>"segundo_apellido"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            fecha nacimiento<span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("fecha_nacimiento",null,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento", "readonly" => "readonly"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>
                    
                         <div class="col-md-6 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                            Segundo apellido <span>*</span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("segundo_apellido",$candidatos->segundo_apellido,["required","class"=>"
                            form-control","id"=>"segundo_apellido"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12" for="inputEmail3">
                                Email<span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("email",$candidatos->email,["class"=>"
                                form-control","id"=>"direccion"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 " for="inputEmail3">
                                Estado civil <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("estado_civil",$estadoCivil,$candidatos->estado_civil,["class"=>"form-control selectcategory" ,"id"=>"estado_civil"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Dirección<span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("dirección",$candidatos->direccion,["class"=>"
                                form-control","id"=>"direccion"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Barrio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("barrio",$candidatos->barrio,["class"=>"
                                form-control","id"=>"barrio"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Libreta militar<span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("numero_libreta",$candidatos->numero_libreta,["class"=>"
                                form-control","id"=>"direccion"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Categoría <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("estado_civil",$claseLibreta,$candidatos->clase_libreta,["class"=>"form-control selectcategory" ,"id"=>"clase_libreta"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Cargo <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("cargo_nombre",$candidatos->cargo,["class"=>"
                                form-control","id"=>"cargo_nombre","disabled"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Cliente <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("cliente_nombre",$candidatos->cliente,["class"=>"
                                form-control","id"=>"cliente_nombre","disabled"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>


                    
                </div>
                <h3>II. Estructura familiar</h3>
                <div class="row" id="nuevo_familiar">
                    <div class="old">
                            <div class="row padre">
                            <div class="item">
                             <table class="table table-bordered tbl_info_familia">

                                <tbody>

                                    <tr>
                                        <td>Parentesco:</td>
                                        <td>{!! Form::text("parentesco[]",null,["class"=>"form-control","id"=>"cargo"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Nombre:</td>
                                        <td>{!! Form::text("nombre_vive[]",null,["class"=>"form-control","id"=>"cargo"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Edad:</td>
                                        <td>{!! Form::text("edad_vive[]",null,["class"=>"form-control","id"=>"cargo"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Ocupación:</td>
                                        <td>{!! Form::text("ocupacion_vive[]",null,["class"=>"form-control","id"=>"cargo"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Estado civil:</td>
                                        <td>{!! Form::text("estado_civil_familiar[]",null,["class"=>"form-control","id"=>"estado_civil_familiar"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>Convide con el:</td>
                                        <td>{!! Form::text("convive_con_el[]",null,["class"=>"form-control","id"=>"convive_con_el"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>Número contacto:</td>
                                        <td>{!! Form::text("num_contacto[]",null,["class"=>"form-control","id"=>"num_contacto"]); !!}</td>

                                      
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                        </div>
                            <div class="col-md-12 form-group last-child" style="display: block;text-align:center;">
                                <button type="button" class="btn btn-success add-item" title="Agregar">+</button>
                            </div>
                        </div>
                
                </div>

                <h3>III. Aspectos generales de la vivienda</h3>
                <div class="row">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Tipo vivienda <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("tipo_vivienda",$tipoVivienda,null,["class"=>"form-control selectcategory" ,"id"=>"tipo_vivienda"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Propiedad <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("propiedad",[],null,["class"=>"form-control selectcategory" ,"id"=>"propiedad"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Nro de familias que habitan <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("nro_familias",null,["class"=>"form-control selectcategory" ,"id"=>"nro_familias"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Nro de pisos <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("nro_pisos",null,["class"=>"form-control selectcategory" ,"id"=>"nro_pisos"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Estrato <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estrato",null,["class"=>"form-control selectcategory" ,"id"=>"estrato"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Sector <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("sector",$sector,null,["class"=>"form-control selectcategory" ,"id"=>"sector"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Facilidades de trasnporte del sector <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("facilidades_transporte",["1"=>"Bueno","2"=>"Regular","3"=>"Malo"],null,["class"=>"form-control selectcategory" ,"id"=>"facilidades_transporte"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Sector <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("sector",[],null,["class"=>"form-control selectcategory" ,"id"=>"nro_pisos"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Tiempo de vivienda al trabajo <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("tiempo_trabajo",null,["class"=>"form-control selectcategory" ,"id"=>"tiempo_trabajo"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Medio utilizado <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("medio_utilizado",null,["class"=>"form-control selectcategory" ,"id"=>"medio_utilizado"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Techo<span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("material_techo",$material_techo,null,["class"=>"form-control selectcategory" ,"id"=>"material_techo"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Paredes <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("material_paredes",$material_paredes,null,["class"=>"form-control selectcategory" ,"id"=>"material_paredes"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                         <div class="col-md-4 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Piso <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::select("material_piso",$material_piso,null,["class"=>"form-control selectcategory" ,"id"=>"material_piso"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>

                    <div class="row">
                        <h4>Distribución espacial de la vivienda</h4>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Habitaciones <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("habitaciones",0,["class"=>"form-control selectcategory" ,"id"=>"habitaciones"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Baños <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("baños",0,["class"=>"form-control selectcategory" ,"id"=>"baños"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Cocina <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("cocina",0,["class"=>"form-control selectcategory" ,"id"=>"cocina"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                         <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Sala <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("sala",0,["class"=>"form-control selectcategory" ,"id"=>"sala"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Patio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("patio",0,["class"=>"form-control selectcategory" ,"id"=>"patio"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Comedor <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("comedor",0,["class"=>"form-control selectcategory" ,"id"=>"comedor"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Garaje <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("garaje",0,["class"=>"form-control selectcategory" ,"id"=>"garaje"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Estudio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estudio",0,["class"=>"form-control selectcategory" ,"id"=>"estudio"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>

                    <div class="row">
                        <h4>Mobiliario</h4>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Televisor <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("televisor",0,["class"=>"form-control selectcategory" ,"id"=>"televisor"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Lavadora <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("lavadora",0,["class"=>"form-control selectcategory" ,"id"=>"lavadora"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Estereo <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estereo",0,["class"=>"form-control selectcategory" ,"id"=>"estereo"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                         <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Nevera <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("nevera",0,["class"=>"form-control selectcategory" ,"id"=>"nevera"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                DVD/Teatro en casa <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("dvd",0,["class"=>"form-control selectcategory" ,"id"=>"dvd"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Video juegos <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("video_juegos",0,["class"=>"form-control selectcategory" ,"id"=>"video_juegos"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Estufa <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("estufa",0,["class"=>"form-control selectcategory" ,"id"=>"estufa"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Horno microondas <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("microondas",0,["class"=>"form-control selectcategory" ,"id"=>"microondas"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                PC escritorio <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("pc",0,["class"=>"form-control selectcategory" ,"id"=>"pc"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Portatil <span>*</span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("portatil",0,["class"=>"form-control selectcategory" ,"id"=>"portatil"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                        
                    </div>
                
                </div>


                <div class="col-md-12 text-center" style="margin-bottom: 2rem;">
                    <button class="btn-quote" id="guardar_evaluacion" type="submit">
                        <i class="fa fa-floppy-o"></i> Guardar
                    </button>
                </div>
                <br>
            {!! Form::close() !!}
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Firma</h3>
                    </div>

                    <div class="modal-body" style="overflow:auto;">
                        <div id="texto">
                            <p>Por favor dibuja tu firma en el panel blanco usando tu mouse o usa tu dedo si estás desde un dispositivo móvil</p>

                            {!! Form::hidden("id", null, ["id" => "fr_id"]) !!}

                            <table class="col-md-12 col-xs-12 col-sm-12 center table" bgcolor="#f1f1f1">
                                <tr>
                                    <td width="10%"></td>
                                    <td>
                                        <div>
                                            <div>
                                                <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="background-color: white;" id="webcamBox">
            <div class="col-md-12 text-center" style="z-index: -1;">
                <video id="webcam" autoplay playsinline width="640" height="420"></video>
                <canvas id="canvas" class="d-none" hidden></canvas>
            </div>
        </div>

        <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    
        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>

        <script src="{{ asset('js/cv/evaluacion_sst/evaluacion-sst-webcam.js') }}"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

        <script>
            $(function () {
                initWebcam()

                $(document).on('click', '.add-person', function (e) {
                    fila_person = $(this).parents('#nuevo_familiar').find('.grupos_fams').eq(0).clone();
                    fila_person.find('input').val('');
                    fila_person.find('.boton_aqui').append('<button type="button" class="btn btn-danger pull-right rem-person" title="Remover grupo">-</button>');

                    $('#nuevo_familiar').append(fila_person);
                });

                var confDatepicker = {
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
                    yearRange: "1930:2050"
                };

                $("#fecha_nacimiento").datepicker(confDatepicker);

                let firmBoard = new DrawingBoard.Board('firmBoard', {
                    controls: [
                        { DrawingMode: { filler: false, eraser: false,  } },
                        { Navigation: { forward: false, back: false } }
                        //'Download'
                    ],
                    size: 2,
                    webStorage: 'session',
                    enlargeYourContainer: true
                });

                //listen draw event
                firmBoard.ev.bind('board:stopDrawing', getStopDraw);
                firmBoard.ev.bind('board:reset', getResetDraw);

                function getStopDraw() {
                    $(".guardarFirma").attr("disabled", false);
                }

                function getResetDraw() {
                    $(".guardarFirma").attr("disabled", true);
                }

                $('input').click(function(){
                    _attr_id = $(this).parent().parent().parent().parent().attr('id');
                    $('#titulo_' + _attr_id).removeClass('preg-faltante');
                    $('#' + _attr_id).removeClass('preg-faltante');
                });

                $(document).on("click", ".guardarFirma", function() {
                    $('.drawing-board-canvas').attr('id', 'canvas');

                    var canvas1 = document.getElementById('canvas');
                    var canvas = canvas1.toDataURL();

                    var cand_id = $("#fr_id").val();
                    var token = ('_token', '{{ csrf_token() }}');
           
                    $.ajax({
                        type: 'POST',
                        data: {
                            id_evaluacion : $("#fr_id").val(),
                            _token : token,
                            firma : canvas
                        },
                        url: "{{ route('save_firma_evaluacion_sst') }}",
                        beforeSend: function(response) {
                            document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                            $.smkAlert({
                                text: 'Guardando su firma, por favor espere',
                                type: 'info'
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                clearInterval(intervalWebcam)
                                stopWebcam()

                                document.querySelector(".guardarFirma").removeAttribute('disabled')

                                //
                                let rutaRedir = response.ruta

                                let rutaDashboard = "{{ route('dashboard') }}";

                                //Guardar fotos
                                let induccionImagenes = JSON.stringify(induccionPictures);

                                $.ajax({
                                    type: 'POST',
                                    data: {
                                        evaluacionId: $("#fr_id").val(),
                                        _token : token,
                                        induccionImagenes: induccionImagenes
                                    },
                                    url: "{{ route('save_fotos_sst') }}",
                                    beforeSend: function(response) {
                                        document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                                    },
                                    success: function(response) {
                                        swal("Felicitaciones", "Haz finalizado tu evaluación de inducción, el profesional de selección que está llevando tu proceso se contactará contigo para indicarte el paso a seguir.", "success", {
                                            buttons: {
                                                finalizar: {text: "Continuar", className:'btn btn-success'}
                                            },
                                            closeOnClickOutside: false,
                                            closeOnEsc: false,
                                            allowOutsideClick: false,
                                        }).then((value) => {
                                            switch (value) {
                                                case "finalizar":
                                                    window.open(rutaRedir, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
                                                    window.location.href = rutaDashboard;
                                                break;
                                            }
                                        });
                                    }
                                });
                            }else{
                                document.querySelector(".guardarFirma").removeAttribute('disabled')
                            }
                        }
                    });
                });

                $(document).on("click", "#guardar_evaluacion", function (e) {
                    e.preventDefault();

                    guardar = true;
                    preguntas = [];

                    $('.preguntas').each(function (index, item){
                        if ($('#' + item.id).hasClass('seleccion_simple') || $('#' + item.id).hasClass('seleccion_multiple')) {
                            respta = false;
                            $('#' + item.id + ' input').each(function (_index, input) {
                                if (input.checked) {
                                    respta = true;
                                    $('#titulo_' + item.id).removeClass('preg-faltante');
                                    $('#' + item.id).removeClass('preg-faltante');
                                }
                            });
                            if (!respta) {
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                preguntas.push(parseInt(index)+1);
                                guardar = false;
                            }
                        } else {
                            if ($('#' + item.id + ' textarea').val() == '' || $('#' + item.id + ' textarea').val() == undefined || $('#' + item.id + ' textarea').val() == null) {
                                preguntas.push(parseInt(index)+1);
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                guardar = false;
                            } else {
                                $('#titulo_' + item.id).removeClass('preg-faltante');
                                $('#' + item.id).removeClass('preg-faltante');
                            }
                        }
                    });

                    if (!guardar) {
                        mensaje = 'Debes responder todas las preguntas. Verifica la ';
                        preguntas.forEach(element => mensaje += ' pregunta ' + element + ', ');
                        $.smkAlert({
                            text: mensaje,
                            type: 'danger'
                        });
                    }

                    if (guardar) {
                        $('#guardar_evaluacion').attr('disabled', true);
                        var formData = new FormData(document.getElementById("fr_evaluacion"));
                        clearInterval(intervalWebcam);
                        $.smkAlert({
                            text: 'Guardando sus respuestas, por favor espere',
                            type: 'info'
                        });

                        $.ajax({
                            url: "{{ route('save_evaluacion_sst') }}",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        }).done(function (res) {
                            var res = $.parseJSON(res);
                            var id_c = res.id;

                            if(res.success) {
                                if(res.paso == 1){ //prueba definitiva 6gh
                                    swal("Felicitaciones", res.mensaje, "success", {
                                        buttons: {
                                            cancelar: {text: "Firmar", className:'btn btn-success'}
                                        },
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                                $("#myModal").modal({
                                                    backdrop: 'static',
                                                    keyboard: false
                                                });
                                                $("#fr_id").val(id_c);
                                            break;
                                        }
                                    });
                                }else {
                                    clearInterval(intervalWebcam)
                                    stopWebcam()

                                    swal("Debes repetir la evaluación", res.mensaje, {
                                        buttons: {
                                            cancelar: {text: "Reintentar Evaluación", className:'btn btn-success'}
                                        },
                                        icon: "warning",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                                location.reload(true)
                                            break;
                                        }
                                    });
                                }
                            } else {
                                $("#modal_peq").find(".modal-content").html(res.view);
                            }
                        });
                    }

                    return false;
                });
            });
        </script>
    </body>
</html>