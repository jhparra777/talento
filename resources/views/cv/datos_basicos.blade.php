@extends("cv.layouts.master")
<?php
    $sitio = FuncionesGlobales::sitio();
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];
?>
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style>
        body { font: 12px arial; }
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

        .py-0 {
            padding-left: 2px;
            padding-right: 2px;
        }

        .py-1 {
            padding-left: 4px;
            padding-right: 4px;
        }

        .pb-1 {
            padding-bottom: 6px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-justify {
            text-align: justify !important;
        }

        .fz-10 {
            font-size: 10pt;
        }

        @media (min-width: 992px) {
            .modal-lg {
                width: 900px !important;
            }
        }

        #div_dir_codificacion > .smk-error-msg {
            position: initial;
            margin-right: 14px;
            text-align: right;
        }

        .input-group-bt4{
          position: relative;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          -webkit-box-align: stretch;
          -ms-flex-align: stretch;
          align-items: stretch;
        }

        .input-group-bt4 input {
          position: relative;
          -webkit-box-flex: 1;
          -ms-flex: 1 1 auto;
          flex: 1 1 auto;
          width: 1%;
          margin-bottom: 0;
        }

        .input-group-append {
          margin-left: -1px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }

        .confirmacion{background:#C6FFD5;border:1px solid green;}
        .negacion{background:#ffcccc;border:1px solid red}
    </style>

    <div class="col-right-item-container">
        <div class="container-fluid">
            {!!Form::model($datos_basicos,["id" => "fr_datos_basicos", "role" => "form", "method" => "POST", "files" => true])!!}
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="submit_listing_box">
                        <h3 class="header-section-form"> 
                            <span class='text-danger sm-text'>
                                Recuerde que los campos marcados con el símbolo (*) son obligatorios.
                            </span>
                        </h3>

                        @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                            <ul style="text-align: justify; padding: 5%; padding-top: 2%; font-size: 1.4rem;" class="instrucciones">
                                <li>
                                    Al ingresar su información utilice mayúsculas únicamente cuando sea necesario, es decir, en nombres propios y al inicio de cada oración.
                                </li>
                                <li>
                                    En la redacción de la información sea concreto y objetivo.
                                </li>
                                <li>
                                    Valide que su información no tenga errores ortográficos y que la redacción sea adecuada.
                                </li>
                                <li>
                                    La información que completará debe ser confiable, estrictamente ajustada a la realidad en todos sus datos y situación personal. 
                                </li>
                                <li>
                                    La trayectoria laboral y formación académica será verificada en las instituciones y con las empresas validando fechas, cargos y motivos de salida. 
                                </li>
                                <li>
                                    Las referencias laborales se aplicarán en el avance final del proceso, por lo que deben constar los jefes directos, una muestra de colegas y colaboradores, sus nombres serán verificados con las empresas previamente.
                                </li>
                                <li>
                                    Coloca N/A en los campos donde la información no aplique a tu caso, no dejes espacios en blanco.
                                </li>
                            </ul>
                        @endif

                        <br>

                        <div class="form-alt">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Imagen personal
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            Profile Photo
                                        @endif
                                       
                                        @if($user->foto_perfil!="" && $user->foto_perfil!=null)
                                            <span>
                                                <a class="" title="Ver" target="_blank" href="{{url("recursos_datosbasicos/".$user->foto_perfil)}}" style="color: green;">
                                                <i class="fa fa-eye"></i> Ver </a>
                                            </span>
                                        @endif
                                    </label>
                                    <p class="text-left"> (Formato png, jpg o jpeg. Tamaño máximo 1.5MB)</p>

                                    <input type="file" class="form-control" name="foto" accept="image/png,.jpeg,.jpg" max-size="2000" id="foto">

                                    <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("foto",$errors)!!} </p>
                                </div>

                                @if(route('home') == "https://gpc.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Hoja de vida (.PDF, .DOC o .DOCX) 
                                            
                                            <span>*@if(!is_null($hoja_vida))
                                                    @if($hoja_vida->nombre_archivo!=null)
                                                <a class="" title="Ver" target="_blank" href="{{url("recursos_documentos/".$hoja_vida->nombre_archivo)}}" style="color: green;">
                                                   <i class="fa fa-eye"> </i>
                                                    Ver
                                                    </a>
                                                    @endif
                                             @endif</span></label>

                                        <input type="file" class="form-control" name="archivo_documento" value="" id="archivo_documento" accept=".pdf,.doc,.docx" @if(!is_null($hoja_vida)) @else required @endif>

                                        <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("archivo_documento", $errors)!!} </p>
                                    </div>
                                @endif

                                {{--<div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Nombres @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Name @endif <span>*</span> 
                                    </label>
                                    <!-- esta etiqueta p con un punto adentro oculta es para que este al nivel del campo de foto que esta al lado -->
                                    <p style="visibility: hidden;">.</p>
                                    {!! Form::text("nombres", null, ["class" => "form-control", "id" => "nombres", "placeholder" => "Nombres" ]) !!}
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("nombres", $errors) !!} </p>
                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Primer nombre <span>*</span> 
                                    </label>
                                    <!-- esta etiqueta p con un punto adentro oculta es para que este al nivel del campo de foto que esta al lado -->
                                    
                                    {!! Form::text("primer_nombre", null, ["class" => "form-control", "id" => "primer_nombre", "placeholder" => "Primer nombre" ]) !!}
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("primer_nombre", $errors) !!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Segundo nombre <span></span> 
                                    </label>
                                    <!-- esta etiqueta p con un punto adentro oculta es para que este al nivel del campo de foto que esta al lado -->
                                   
                                    {!! Form::text("segundo_nombre", null, ["class" => "form-control", "id" => "segundo_nombre", "placeholder" => "Segundo nombre" ]) !!}
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!} </p>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Primer apellido
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            / First Surname
                                        @endif
                                        <span>*</span>
                                    </label>
                                    
                                    {!! Form::text("primer_apellido",null,["class"=>"form-control", "name"=>"primer_apellido" ,"id"=>"primer_apellido", "placeholder"=>"Primer Apellido"]) !!}
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co" ||
                                        route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                                        <label> Segundo apellido <span>*</span></label>
                                    @else
                                        <label>
                                            Segundo apellido
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                / Second Surname
                                            @endif
                                            <span></span>
                                        </label>
                                    @endif

                                    {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"id"=>"segundo_apellido", "placeholder"=>"Segundo Apellido" ]) !!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("segundo_apellido", $errors) !!}
                                    </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Tipo de identificación
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                          / Identification Type
                                        @endif
                                        
                                        <span>*</span>
                                    </label>
                                    
                                    {!! Form::select("tipo_id", $tipos_documentos,null,["class" => "form-control selectcategory","id"=>"tipo_id"]) !!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("tipo_id", $errors) !!}
                                    </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        @if(route('home') == "https://gpc.t3rsc.co") Cédula de identidad @else Número de identificación @endif
                                        @if(route('home') == "https://colpatria.t3rsc.co") / Identification Number @endif
                                        <span>*</span>
                                    </label>

                                    {!! Form::number("numero_id",null,["class"=>"form-control input-number", "id"=>"numero_id","maxlength"=>"16","min"=>"1", "max"=>"9999999999999999","pattern"=>".{1,16}","placeholder"=>"Identificación","readonly"=>""]) !!}
                                    
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("numero_id",$errors) !!} </p>
                                </div>
                                
                                @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" &&
                                    route('home') != "http://nases.t3rsc.co" && route('home') != "https://nases.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>Pais de @if(route("home")=="https://humannet.t3rsc.co") emisión @else expedición @endif de la identificación<span>*</span></label>
                                        {!! Form::select("pais_id",$paises,$datos_basicos->pais_id,["class"=>"form-control","placeholder"=>"","id"=>"pais_id"]) !!}
                                        
                                        <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("ciudad_expedicion_id",$errors) !!} </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        @if(route("home")=="https://humannet.t3rsc.co")
                                            <label>Región de emisión de la identificación<span>*</span></label>
                                        @else
                                            <label>Dpto de expedición de la identificación<span>*</span></label>
                                        @endif
                                        
                                        {!!Form::select("departamento_expedicion_id",$dptos_expedicion,$datos_basicos->departamento_expedicion_id,["id"=>"departamento_expedicion_id","class"=>"form-control","placeholder"=>""])!!}
                                        
                                        <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("ciudad_expedicion_id",$errors)!!} </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                         @if(route("home")=="https://humannet.t3rsc.co")
                                            <label>Provincia de  expedición de la identificación<span>*</span></label>
                                        @else
                                            <label>Ciudad de  expedición de la identificación<span>*</span></label>
                                        @endif
                                        

                                        {!! Form::select("ciudad_expedicion_id",$ciudades_expedicion,$datos_basicos->ciudad_expedicion_id,["class"=>"form-control","placeholder"=>"","id"=>"ciudad_expedicion_id"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("ciudad_expedicion_id",$errors) !!}
                                        </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Fecha de @if(route("home")=="https://humannet.t3rsc.co") emisión @else expedición @endif de la identificación
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                / Expedition Date
                                            @endif
                                            <span>*</span>
                                        </label>

                                        {!! Form::text("fecha_expedicion",null,["class"=>"form-control", "id"=>"fecha_expedicion" ,"placeholder"=>"Fecha Expedición", "readonly" => "readonly"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                         {!! FuncionesGlobales::getErrorData("fecha_expedicion", $errors) !!}
                                        </p>
                                    </div>
                                @endif

                                @if(route('home') != "https://expertos.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>Pais de nacimiento<span>*</span></label>
                                          
                                        {!! Form::select("pais_nacimiento",$paises,$datos_basicos->pais_nacimiento,["class"=>"form-control","placeholder"=>"","id"=>"pais_nacimiento"]) !!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                            {!!FuncionesGlobales::getErrorData("pais_nacimiento", $errors)!!}
                                        </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            @if(route("home")=="https://gpc.t3rsc.co")
                                                Provincia de nacimiento
                                            @else
                                                Dpto de nacimiento
                                            @endif
                                          
                                            <span>*</span>
                                        </label>
                                                                 
                                        {!! Form::select("departamento_nacimiento",$dptos_nacimiento,$datos_basicos->departamento_nacimiento,["id"=>"departamento_nacimiento","class"=>"form-control","placeholder"=>""]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("departamento_nacimiento", $errors) !!}
                                        </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>Ciudad de nacimiento<span>*</span></label>
                                     
                                        {!! Form::select("ciudad_nacimiento",$ciudades_nacimiento,$datos_basicos->ciudad_nacimiento,["class"=>"form-control","placeholder"=>"","id"=>"ciudad_nacimiento"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("ciudad_nacimiento", $errors) !!}
                                        </p>
                                    </div>
                                @endif

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Fecha de nacimiento
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            / Birth Date
                                        @endif
                                        <span>*</span>
                                    </label>

                                    {!! Form::text("fecha_nacimiento",null,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento", "readonly" => "readonly"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("fecha_nacimiento", $errors) !!}
                                    </p>
                                </div>

                                @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                                    {{--ocultar campos para colpatria--}}
                                    @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" &&
                                        route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" &&
                                        route('home')!="https://expertos.t3rsc.co")
                                        @if(route('home') != "https://gpc.t3rsc.co")
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label>Grupo sanguineo <span>*</span></label>

                                                {!! Form::select("grupo_sanguineo",[""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],null,["class"=>"form-control selectcategory", "id"=>"grupo_sanguineo"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!! FuncionesGlobales::getErrorData("grupo_sanguineo", $errors) !!}
                                                </p>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label>RH <span>*</span></label>

                                                {!! Form::select("rh",[""=>"Seleccionar","negativo"=>"Negativo","positivo"=>"Positivo"],null,["class"=>"form-control selectcategory", "id"=>"rh"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!! FuncionesGlobales::getErrorData("rh", $errors) !!}
                                                </p>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label> Género
                                                    @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Gender @endif
                                                    <span>*</span>
                                                </label>
                                                
                                                {!!Form::select("genero",$genero,null,["id"=>"genero","class"=>"form-control selectcategory"])!!}

                                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("genero", $errors)!!} </p>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Estado civil <span>*</span>
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / State Civil @endif
                                                @if(route('home') == "https://gpc.t3rsc.co") <span>*</span> @endif 
                                        </label>

                                        {!! Form::select("estado_civil",$estadoCivil,null,["class"=>"form-control selectcategory" ,"id"=>"estado_civil"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                         {!! FuncionesGlobales::getErrorData("estado_civil",$errors) !!}
                                        </p>
                                    </div>

                                @endif

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co" ||
                                        route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                                        <label> Teléfono móvil <span>*</span> </label>
                                    @else
                                        <label> Teléfono móvil @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Phone Number @endif </label>
                                    @endif
                                        
                                    {!! Form::number("telefono_movil",null,["class"=>"form-control input-number" ,"id"=>"telefono_movil", "maxlength"=>"10","min"=>"1", "max"=>"9999999999","pattern"=>".{1,10}", "placeholder"=>"Móvil"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}
                                    </p>
                                </div>

                                @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co" &&
                                    route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" &&
                                    route('home') != "https://expertos.t3rsc.co")
                
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            @if(route("home")=="https://humannet.t3rsc.co") Red fija @else Número de teléfono fijo @endif  @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif
                                        </label>
                                        
                                        {!! Form::number("telefono_fijo",null,["class"=>"form-control input-number" ,"id"=>"telefono_fijo", "maxlength"=>"7","min"=>"1", "max"=>"9999999","pattern"=>".{1,7}" ,"placeholder"=>"Teléfono Fijo"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}
                                        </p>
                                    </div>
                                @endif

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Correo electrónico @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Email @endif
                                        <span>*</span>
                                    </label>

                                    {!! Form::email("email",null,["class"=>"form-control" ,"id"=>"email" ,"placeholder"=>"Correo Electrónico"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("email",$errors) !!}
                                    </p>
                                </div>

                                @if(route("home")!="https://expertos.t3rsc.co" && route("home")!="https://gpc.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">

                                        <label>@if(route("home")=="https://humannet.t3rsc.co") Pretensiones de renta mensual @else Aspiración salarial @endif  @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / sucked salary @endif
                                            <span>*</span>
                                        </label>

                                        @if(route('home') == "http://localhost:8000" || route('home') == "https://demo.t3rsc.co" ||
                                            route('home') == "https://soluciones.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                                          {!! Form::text("aspiracion_salarial",null,["class"=>"form-control input-number" ,"id"=>"aspiracion_salarial","min"=>"1","placeholder"=>""])!!}
                                        @else
                                          {!! Form::select("aspiracion_salarial",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"aspiracion_salarial"]) !!}
                                        @endif

                                        <p class="error text-danger direction-botones-center">
                                            {!!FuncionesGlobales::getErrorData("aspiracion_salarial",$errors)!!}
                                        </p>
                                    </div>
                                @endif

                                @if((route('home') != "http://komatsu.t3rsc.co") && (route('home') != "http://pta.t3rsc.co/") &&
                                    (route('home') != "http://colpatria.t3rsc.co") && (route('home') != "https://colpatria.t3rsc.co" &&
                                    route('home') != "https://expertos.t3rsc.co" && route('home') != "https://gpc.t3rsc.co"))
                                  
                                  @if(route('home') != "https://capillasdelafe.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Talla zapatos @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif
                                     </label>
                                      {!! Form::select("talla_zapatos",$talla_zapatos,$datos_basicos->talla_zapatos,["class"=>"form-control selectcategory", "id"=>"talla_zapatos"]) !!}
                                        <p class="error text-danger direction-botones-center">
                                         {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                        </p>
                                    </div>
                                  @endif

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Talla camisa @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif 
                                        </label>

                                        {!! Form::select("talla_camisa",$talla_camisa,$datos_basicos->talla_camisa,["class"=>"form-control selectcategory", "id"=>"talla_camisa"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("talla_camisa",$errors) !!}
                                        </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Talla pantalón @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif 
                                        </label>

                                        {!!Form::select("talla_pantalon",$talla_pantalon,$datos_basicos->talla_pantalon,["class"=>"form-control selectcategory", "id"=>"talla_pantalon"])!!}

                                        <p class="error text-danger direction-botones-center">
                                            {!!FuncionesGlobales::getErrorData("talla_pantalon",$errors)!!}
                                        </p>
                                    </div>

                                @endif

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>Pais de residencia<span>*</span></label>
                                         
                                    {!!Form::select("pais_residencia",$paises,$datos_basicos->pais_residencia,["class"=>"form-control","placeholder"=>"","id"=>"pais_residencia"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("pais_residencia",$errors) !!}
                                    </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        @if(route("home")=="https://gpc.t3rsc.co")
                                            Provincia de residencia
                                        @elseif(route("home")=="https://humannet.t3rsc.co")
                                            Región de residencia
                                        @else
                                            Dpto de residencia
                                        @endif
                                          
                                        <span>*</span>
                                    </label>
                    
                                    {!! Form::select("departamento_residencia",$dptos_residencia,$datos_basicos->departamento_residencia,["id"=>"departamento_residencia","class"=>"form-control","placeholder"=>""]) !!}

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("departamento_residencia",$errors) !!}
                                    </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    @if(route("home")=="https://humannet.t3rsc.co")
                                        <label>Provincia de residencia<span>*</span></label>
                                    @else
                                        <label>Ciudad de residencia<span>*</span></label>
                                    @endif
                                         
                                    {!! Form::select("ciudad_residencia",$ciudades_residencia,$datos_basicos->ciudad_residencia,["class"=>"form-control","placeholder"=>"","id"=>"ciudad_residencia"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                     {!! FuncionesGlobales::getErrorData("ciudad_residencia",$errors) !!}
                                    </p>
                                </div>

                                {{--Campos que SI deben aparecer KOMATSU--}}
                                @if((route("home") != "http://komatsu.t3rsc.co") && (route("home") != "https://komatsu.t3rsc.co") && (route('home') != "http://pta.t3rsc.co") && (route('home') != "https://gpc.t3rsc.co"))

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label>@if(route("home")=="https://humannet.t3rsc.co") Comuna @else Barrio @endif @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif</label>

                                      {!!Form::text("barrio",null,["class"=>"form-control","id"=>"barrio","placeholder"=>"" ])!!}

                                     <p class="error text-danger direction-botones-center">
                                      {!!FuncionesGlobales::getErrorData("barrio",$errors)!!}
                                     </p>
                                    </div>

                                @endif

                                @if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                      <label> Dirección de @if(route("home")=="https://humannet.t3rsc.co") domicilio @else residencia @endif @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Residence Adress @endif <span>*</span> </label>
                                            
                                        @if ($sitio->direccion_dian)
                                            <?php
                                                $direccion_dian_candidato = $datos_basicos->getDireccionDian;
                                            ?>
                                            <input class="form-control" type="text" readonly="readonly" placeholder="" id="direccion" name="direccion" value="@if($direccion_dian_candidato != null && $direccion_dian_candidato != '') {{ $datos_basicos->direccion }}@endif"></input>
                                        @else
                                            {!! Form::text("direccion",null,["class"=>"form-control","id"=>"direccion","placeholder"=>"Dirección de residencia" ]) !!}
                                        @endif
                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("direccion",$errors) !!}
                                        </p>
                                    </div>

                                    @if(route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co")
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                         <label>Localidad</label>
                                          {!! Form::text("localidad",null,["class"=>"form-control","id"=>"localidad","placeholder"=>"Localidad" ]) !!}
                                         <p class="error text-danger direction-botones-center">
                                          {!! FuncionesGlobales::getErrorData("localidad",$errors) !!}
                                         </p>
                                        </div>
                                    @endif

                                    @if(route("home")=="https://humannet.t3rsc.co")
                                     <div class="col-md-6 col-sm-12 col-xs-12">
                                      <label> Nivel Estudio </label>
                                       {!!Form::select("nivel_estudio",$nivel_academico,null,["class"=>"form-control","id"=>"nivel_estudio"])!!}
                                       <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("nivel_estudio",$errors) !!}
                                       </p>
                                     </div>
                                    @endif

                                @endif

                                @if(route("home") == "https://gpc.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Tipo vivienda <span>*</span> </label>

                                        {!!Form::select("tipo_vivienda",['' => "Seleccione", 'propia' => "Propia", 'alquilada' => "Alquilada", '0' => "Otro"],null,["class"=>"form-control","id"=>"tipo_vivienda"])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("tipo_vivienda",$errors)!!} </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Direccion skype </label>
                                        {!!Form::text("direccion_skype",null,["class"=>"form-control","id"=>"direccion_skype","placeholder"=>"skype" ])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("direccion_skype",$errors)!!} </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Otro teléfono de ubicación (familiar o amigo)</label>
                                        {!!Form::text("otro_telefono",null,["class"=>"form-control input-number","id"=>"otro_telefono","placeholder"=>"otro" ])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("otro_telefono",$errors)!!} </p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                      <label> Número hijos <span>*</span></label>
                                        {!! Form::select("numero_hijos",["N/A"=>"N/A","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5 o mas"=>"5 o mas"],null,["class"=>"form-control selectcategory", "id"=>"numero_hijos"]) !!}

                                      <p class="error text-danger direction-botones-center">
                                       {!!FuncionesGlobales::getErrorData("numero_hijos", $errors)!!} </p>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                      <label> Edad hijos <span> Separe Edades por comas(,)</span></label>
                                       {!!Form::text("edad_hijos",null,["class"=>"form-control","id"=>"edad_hijos","placeholder"=>" Separe Edades por comas"])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("edad_hijos",$errors)!!}</p>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Tipo vehículo <span>*</span> </label>
                                      {!!Form::select("tipo_vehiculo_t",['' => "Seleccione", 'propio' => "Propio",'prendado' => "Prendado",'0' => "Otro",'N/A' => "N/A"],null,["class"=>"form-control","id"=>"tipo_vehiculo_t"])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("tipo_vehiculo_t", $errors)!!} </p>
                                    </div>
                                @endif

                                @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Tiene licencia <span>*</span> </label>
                                        {!!Form::select("tiene_licencia",[""=>"Seleccionar","1"=>"si","0"=>"no"],null,["class"=>"form-control selectcategory","id"=>"tiene_licencia"]) !!}
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Categoría de la licencia <span>*</span> </label>
                                      {!!Form::select("categoria_licencia",$categoriaLicencias,NULL,["class"=>"form-control selectcategory","id"=>"categoria_licencia"])!!}
                                        <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("categoria_licencia",$errors)!!} </p>
                                    </div>
                                @endif

                                @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                    <div class="col-xs-6">
                                     <label>¿Tiene conflicto de intereses?</label>
                                      {!! Form::select("conflicto",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"conflicto"]) !!}       
                                    <br>
                                     <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">
                                      Ver política de conflicto de intereses
                                     </button>
                                    </div>
                                       
                                    <div class="col-xs-6">
                                     <label>¿Trabaja actualmente en Komatsu? <span>*</span></label>
                                      {!! Form::select("trabaja",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"trabaja"]) !!}
                                    </div>

                                    @if($datos_basicos->descripcion_conflicto && $datos_basicos->conflicto == 1)
                                        <div class="col-xs-12" id="descripcion_conflicto">
                                         <label> ¿Qué parentesco tiene, los nombres y el área del trabajador?  / Caracteres restantes: </label>
                                          {!! Form::textarea("descripcion_conflicto",$datos_basicos->descripcion_conflicto,["maxlength"=>"550","class"=>"form-control ",'rows' => 3,"id"=>"descripcion_conflicto" ]) !!}
                                                
                                            <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("descripcion_conflicto",$errors) !!} </p>
                                        </div>
                                    @else
                                      
                                      <div class="col-xs-12" style="display: none;" id="descripcion_conflicto">
                                        
                                        <label> ¿Qué parentesco tiene, los nombres y el área del trabajador?  / Caracteres restantes: @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Relationship, Worker area? @endif </label>

                                         {!!Form::textarea("descripcion_conflicto",null,["maxlength"=>"550","class"=>"form-control ",'rows' => 3,"id"=>"descripcion_conflicto" ])!!}
                                                
                                        <p class="error text-danger direction-botones-center">
                                         {!! FuncionesGlobales::getErrorData("descripcion_conflicto",$errors) !!}
                                        </p>
                                      </div>
                                    @endif
                                @endif

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label> Estrato</label>
                                    {!! Form::select("estrato",[""=>"Seleccionar","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5", "6"=>"6"],null,["class"=>"form-control selectcategory", "id"=>"estrato"]) !!}

                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("estrato", $errors)!!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        ¿Pertenece a algún Grupo poblacional?
                                    </label>
                                    {!!Form::select("pertenece_grupo_poblacional",["0"=>"No", "1"=>"Si"], (is_null($datos_basicos->grupo_poblacional) || $datos_basicos->grupo_poblacional == "") ? 0 : 1,["class"=>"form-control selectcategory", "id" => "pertenece_grupo_poblacional"])!!}

                                    <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("pertenece_grupo_poblacional",$errors) !!}
                                    </p>
                                </div>

                                <div id="grupo_poblacional" class="col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Grupo Poblacional
                                    </label>
                                    {!!Form::select("grupo_poblacional",[
                                    ""                  =>"Seleccionar", 
                                    "Afrodescendiente"  => "Afrodescendiente",
                                    "Indígena"          => "Indígena",
                                    "Población victima" => "Población victima",
                                    "Desmovilizados"    => "Desmovilizados",
                                    "Inclusión laboral" => "Inclusión laboral",
                                    "Otro" => "Otro"], $datos_basicos->grupo_poblacional,["class"=>"form-control selectcategory", "id" => "select_grupo_poblacional"])!!}

                                    <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("grupo_poblacional",$errors) !!}
                                    </p>
                                </div>

                                <div id="otro_grupo" class="col-md-6 col-sm-12 col-xs-12">
                                    <label> Describa otro grupo poblacional</label>
                                    {!!Form::text("otro_grupo_poblacional",$datos_basicos->otro_grupo_poblacional,["class"=>"form-control", "id" => "otro_grupo_poblacional"])!!}

                                    <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("otro_grupo_poblacional",$errors)!!}
                                    </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                 <label> Nombre Contacto emergencia</label>
                                   {!!Form::text("contacto_emergencia",null,["class"=>"form-control","id"=>"contacto_emergencia","placeholder"=>"" ])!!}
                                   <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("contacto_emergencia",$errors)!!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                 <label> Parentesco del Contacto emergencia</label>
                                   {!!Form::text("parentesco_contacto_emergencia",null,["class"=>"form-control","id"=>"parentesco_contacto_emergencia","placeholder"=>"Parentesco" ])!!}
                                   <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("parentesco_contacto_emergencia",$errors)!!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                 <label> Número teléfono contacto emergencia</label>

                                   {!! Form::number("telefono_emergencia",null,["class"=>"form-control input-number" ,"id"=>"telefono_emergencia", "maxlength"=>"10","min"=>"1", "max"=>"9999999999","pattern"=>".{1,10}", "placeholder"=>"Teléfono emergencia"]) !!}

                                   <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("telefono_emergencia",$errors)!!} </p>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                 <label> Correo Contacto emergencia <span></span></label>

                                   {!! Form::email("correo_emergencia",null,["class"=>"form-control" ,"id"=>"correo_emergencia" ,"placeholder"=>"Correo electrónico emergencia"]) !!}

                                   <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("correo_emergencia",$errors)!!} </p>
                                </div>

                                @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co" && route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                     <label> Perfil laboral  / Caracteres restantes: @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Profile Working @endif<span></span>
                                     </label>

                                        {!!Form::textarea("descrip_profesional",null,["maxlength"=>"550","class"=>"form-control",'rows' => 3,"id"=>"descrip_profesional","placeholder"=>"Escribe aca tu descripcion profesional . Máximo 550 caracteres"])!!}

                                        <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("descrip_profesional",$errors) !!} </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                    {{--Solo GPC Tabulen PERROS --}}
                    @if(route('home') == "https://gpc.t3rsc.co")
                        <div id="submit_listing_box">
                            <h3> Descripción de sus objetivos </h3>
                            
                            <div class="form-alt">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                     <label> Personales <span></span> </label>
                                      {!! Form::textarea("obj_personales",null,["class"=>"form-control" ,"id"=>"obj_personales","placeholder"=>"Objetivos Personales","maxlength"=>"5000"])!!}    
                                        <p class="error text-danger direction-botones-center">
                                         {!!FuncionesGlobales::getErrorData("obj_personales",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label> Profesionales <span></span> </label>
                                        {!! Form::textarea("obj_profesionales",null,["class"=>"form-control" ,"id"=>"obj_profesionales","placeholder"=>"Objetivos Profesionales","maxlength"=>"5000"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("obj_profesionales",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label> Académicos <span></span> </label>
                                        {!! Form::textarea("obj_academicos",null,["class"=>"form-control" ,"id"=>"obj_academicos","placeholder"=>"Objetivos Academicos","maxlength"=>"5000"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("obj_academicos",$errors)!!} </p>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="submit_listing_box">
                            <h3> Disponibilidad para condiciones de trabajo </h3>

                            <div class="form-alt">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Horarios flexibles <span></span> </label>
                                     {!!Form::select("horario_flexible",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"horario_flexible"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("horario_flexible",$errors)!!} </p>   
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Viajes regionales <span></span> </label>
                                        {!!Form::select("viaje_regional",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"viajes_regionales"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("viaje_regional",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Viajes internacionales <span></span> </label>
                                        {!!Form::select("viaje_internacional",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"viaje_internacional"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("viaje_internacional",$errors)!!} </p>   
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Cambio de ciudad <span></span> </label>
                                        {!!Form::select("cambio_ciudad",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"cambio_ciudad"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("cambio_ciudad",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Cambio de pais <span></span> </label>
                                        {!!Form::select("cambio_pais",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"cambio_pais"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("cambio_pais",$errors)!!} </p>   
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Explique su estado de salud actual o cualquier observacion a ser considerada <span></span> </label>
                                        {!! Form::textarea("estado_salud",null,["class"=>"form-control" ,"id"=>"estado_salud","placeholder"=>"","maxlength"=>"5000"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("estado_salud",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Carnet de conadis <span></span> </label>
                                        {!!Form::select("conadis",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"conadis"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("conadis",$errors)!!} </p>   
                                    </div>
                   
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Tipo y grado de discapacidad <span></span> </label>
                                        {!! Form::textarea("grado_disca",null,["class"=>"form-control" ,"id"=>"grado_disca","placeholder"=>"","maxlength"=>"5000"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("grado_disca",$errors)!!} </p>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                  
                    {{--Solo GPC Tabulen PERROS --}}
                    @if(route('home') == "https://gpc.t3rsc.co")
                        {{-- Aspiración salarial candidato--}}
                        <div id="submit_listing_box">
                            <h3> Aspiración salarial y de beneficios </h3>

                            <div class="form-alt">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Sueldo fijo bruto <span></span> </label>
                                        {!!Form::text("sueldo_bruto",null,["class"=>"form-control","id"=>"sueldo_bruto"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("sueldo_bruto",$errors)!!} </p>   
                                    </div>
                   
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label> Ingreso variable mensual (comisiones/bonos) <span></span> </label>
                                        {!! Form::text("comision_bonos",null,["class"=>"form-control" ,"id"=>"comision_bonos","placeholder"=>"","maxlength"=>"5000"])!!}
                      
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("comision_bonos",$errors)!!} </p>   
                                    </div>
                                </div>

                                <div class="row">
                                 <div class="col-md-6 col-sm-12 col-xs-12">
                                  <label> Otros bonos (montos y periodicidad) <span></span> </label>
                                    {!! Form::text("otros_bonos",null,["class"=>"form-control" ,"id"=>"otros_bonos","placeholder"=>"","maxlength"=>"5000"])!!}
                                     <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("otros_bonos",$errors)!!} </p>   
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Total ingreso anual <span></span> </label>
                                        {!! Form::text("ingreso_anual",null,["class"=>"form-control" ,"id"=>"ingreso_anual","placeholder"=>"","maxlength"=>"5000"])!!}
                      
                                      <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("ingreso_anual",$errors)!!} </p>   
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label> Total ingreso mensual <span></span> </label>
                                       {!! Form::text("ingreso_mensual",null,["class"=>"form-control","id"=>"ingreso_mensual input-number","placeholder"=>"","maxlength"=>"5000"])!!}
                                      <p class="error text-danger direction-botones-center">
                                      {!!FuncionesGlobales::getErrorData("ingreso_mensual",$errors)!!} </p>   
                                    </div>
                                
                                  <div class="col-md-6 col-sm-12 col-xs-12">
                                    <label> Otros beneficios <span>*</span> </label>
                                     {!!Form::text("otros_beneficios",null,["class"=>"form-control","id"=>"otros_beneficios"])!!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                        {!!FuncionesGlobales::getErrorData("otros_beneficios",$errors)!!} </p>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--NO deben aparecer KOMATSU--}}
                    @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "https://expertos.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                        <div id="submit_listing_box">
                          <h3> Datos opcionales @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Optional Information @endif
                            </h3>

                            <div class="form-alt">
                                <div class="row">
                                  @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                     <label>@if(route("home")=="https://humannet.t3rsc.co") Fondo de salud @else Entidad promotora de salud (EPS) @endif  @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Health Promotion Entity  @endif <span></span> </label>
                                        {!! Form::select("entidad_eps",$entidadesEps,$datos_basicos->entidad_eps,["class"=>"form-control selectcategory","id"=>"entidad_eps"]) !!}
                                        
                                     <p class="error text-danger direction-botones-center">
                                      {!!FuncionesGlobales::getErrorData("entidad_eps",$errors)!!} </p>
                                    </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                         <label>Administradora de pensiones (AFP) @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Pension Administrador  @endif  <span></span> </label>
                                          {!!Form::select("entidad_afp",$entidadesAfp,null,["class"=>"form-control selectcategory","id"=>"entidad_afp"])!!}
                                        
                                         <p class="error text-danger direction-botones-center">
                                          {!!FuncionesGlobales::getErrorData("entidad_afp",$errors)!!} </p>
                                        </div>
                                    @endif

                                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                         <label>Número de teléfono fijo <span></span></label>
                                          {!! Form::text("telefono_fijo",null,["class"=>"form-control input-number" ,"id"=>"telefono_fijo" ,"placeholder"=>"Teléfono Fijo"])!!}

                                         <p class="error text-danger direction-botones-center">
                                          {!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!} </p>
                                        </div>
                  
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                         <label> Género <span></span> </label>
                                          {!!Form::select("genero",$genero,null,["id"=>"genero","class"=>"form-control selectcategory"])!!}
                                          <p class="error text-danger direction-botones-center">
                                            {!!FuncionesGlobales::getErrorData("genero",$errors)!!} </p>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label>Estado civil<span></span></label>
                                            {!! Form::select("estado_civil",$estadoCivil,null,["class"=>"form-control selectcategory" ,"id"=>"estado_civil"])!!}
                                            
                                            <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("estado_civil",$errors) !!} </p>
                                        </div>
                                    @endif

                                    @if(route('home') != "http://komatsu.t3rsc.co" || route('home') != "https://komatsu.t3rsc.co" ||
                                        route('home') != "http://colpatria.t3rsc.co" || route('home') != "https://colpatria.t3rsc.co")

                                            <div id="situacion_militar">
                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <label>
                                                        ¿Situación militar? @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Military Situation @endif 
                                                        <span></span>
                                                    </label>

                                                    {!!Form::select("situacion_militar_definida",[""=>"Seleccionar","1"=>"si","0"=>"no"],$datos_basicos->situacion_militar_definida,["class"=>"form-control militar_situacion selectcategory"])!!}

                                                    <p class="error text-danger direction-botones-center">
                                                    {!!FuncionesGlobales::getErrorData("situacion_militar_definida",$errors) !!} </p>
                                                </div>
                                            </div>

                                            <div class="libreta_militar">
                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <label>Número de libreta militar @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Number Notepad Military @endif <span></span></label>

                                                    {!! Form::number("numero_libreta",null,["class"=>"form-control", "id"=>"numero_libreta","placeholder"=>"# Libreta Militar"]) !!}

                                                    <p class="error text-danger direction-botones-center">
                                                        {!! FuncionesGlobales::getErrorData("numero_libreta",$errors) !!}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <label>
                                                        Clase libreta @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Notepad Class @endif 
                                                        <span></span>
                                                    </label>

                                                    {!! Form::select("clase_libreta",$claseLibreta,null,["id"=>"clase_libreta","class"=>"form-control selectcategory"]) !!}
                                     
                                                    <p class="error text-danger direction-botones-center">
                                                        {!! FuncionesGlobales::getErrorData("clase_libreta",$errors) !!}
                                                    </p>
                                                </div>

                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <label>
                                                        Número de distrito militar @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Military District Number  @endif 
                                                        <span></span>
                                                    </label>
                                        
                                                    {!! Form::text("distrito_militar",null,["id"=>"distrito_militar","class"=>"form-control","placeholder"=>"Número Distrito"]) !!}

                                                    <p class="error text-danger direction-botones-center">
                                                        {!! FuncionesGlobales::getErrorData("distrito_militar",$errors) !!}
                                                    </p>
                                                </div>
                                            </div>

                                        @if(route("home") != "https://gpc.t3rsc.co")
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label>@if(route("home")=="https://humannet.t3rsc.co")Posee auto? @else Cuenta con vehículo automotor?  @endif  @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Has an Automotive Vehicle @endif <span></span>
                                                </label>

                                                {!! Form::select("tiene_vehiculo",[""=>"Seleccionar","1"=>"si","0"=>"no"],null,["class"=>"form-control selectcategory","id"=>"tiene_vehiculo"]) !!}
                                        
                                                <p class="error text-danger direction-botones-center">
                                                {!! FuncionesGlobales::getErrorData("tiene_vehiculo",$errors) !!} </p>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label> Tipo de vehículo @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Vehicle Type @endif  <span></span> </label>
                                        
                                                {!! Form::select("tipo_vehiculo",$tipoVehiculo,null,["id"=>"tipo_vehiculo","class"=>"form-control selectcategory"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!!FuncionesGlobales::getErrorData("tipo_vehiculo",$errors)!!}
                                                </p>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <label> Número de licencia @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") / Licence Number @endif 
                                                    <span></span>
                                                </label>

                                                {!! Form::number("numero_licencia",null,["class"=>"form-control", "id"=>"numero_licencia","placeholder"=>"# Licencia"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!! FuncionesGlobales::getErrorData("numero_licencia",$errors) !!}
                                                </p>
                                            </div>
                                        @endif
                                    @endif

                                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label> Dirección de residencia <span></span> </label>

                                            @if ($sitio->direccion_dian)
                                                <?php
                                                    $direccion_dian_candidato = $datos_basicos->getDireccionDian;
                                                ?>
                                                <input class="form-control" type="text" readonly="readonly" placeholder="Presione el botón" id="direccion" name="direccion" value="@if($direccion_dian_candidato != null && $direccion_dian_candidato != '') {{ $datos_basicos->direccion }}@endif"></input>
                                            @else
                                                {!! Form::text("direccion",null,["class"=>"form-control","id"=>"direccion","placeholder"=>"Dirección de residencia" ]) !!}
                                            @endif

                                            <p class="error text-danger direction-botones-center">
                                                {!! FuncionesGlobales::getErrorData("direccion",$errors) !!}
                                            </p>
                                        </div>

                                        <div class=" col-xs-6">
                                            <label>¿Tiene disponibilidad para viajar?</label>

                                            {!! Form::select("viaje",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"viaje"]) !!}
                                        </div>

                                        <div class=" col-xs-12">
                                            <label> ¿De donde conoce a Komatsu? / Caracteres restantes: <span></span> </label>

                                            {!! Form::textarea("conocenos",null,["maxlength"=>"550","class"=>"form-control",'rows' => 3,"id"=>"direccion" ]) !!}
                                        
                                            <p class="error text-danger direction-botones-center">
                                                {!! FuncionesGlobales::getErrorData("conocenos",$errors) !!}
                                            </p>
                                        </div>
                                    @endif

                                    @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co" && route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                          <label> Tiene licencia <span></span> </label>

                                            {!! Form::select("tiene_licencia",[""=>"Seleccionar","1"=>"si","0"=>"no"],((!empty($datos_basicos->categoria_licencia))?1:0),["class"=>"form-control selectcategory","id"=>"tiene_licencia"]) !!}

                                            <p class="error text-danger direction-botones-center">
                                                {!! FuncionesGlobales::getErrorData("tiene_licencia",$errors) !!}
                                            </p>
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            @if(route("home")=="https://humannet.t3rsc.co")
                                                <label> Clase de licencia de conducir </label>
                                            @else
                                                <label> Categoría de la licencia </label>
                                            @endif
                                            

                                            {!! Form::select("categoria_licencia",$categoriaLicencias,$datos_basicos->categoria_licencia,["class"=>"form-control selectcategory","id"=>"categoria_licencia"])  !!}

                                            <p class="error text-danger direction-botones-center">
                                                {!! FuncionesGlobales::getErrorData("categoria_licencia",$errors) !!}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label>¿Tiene cuenta bancaria activa?<span></span></label>

                                        {!! Form::select("tiene_cuenta_bancaria",[""=>"Seleccionar","1"=>"Sí","0"=>"No"],null,["class"=>"form-control selectcategory","id"=>"tiene_cuenta_bancaria"]) !!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("tiene_cuenta_bancaria",$errors) !!}</p>
                                    </div>

                                    <div class="banco col-md-6 col-sm-12 col-xs-12">
                                        <label>Nombre del Banco <span>*</span></label>

                                        {!! Form::select("nombre_banco", $bancos,null,["class"=>"form-control selectcategory","id"=>"nombre_banco"]) !!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("nombre_banco",$errors) !!}</p>
                                    </div>

                                    <div class="banco col-md-6 col-sm-12 col-xs-12">
                                        <label>Tipo Cuenta <span>*</span></label>

                                        {!! Form::select("tipo_cuenta", ["" => "Sleccionar", "Ahorro" => "Ahorro", "Corriente" => "Corriente"],null,["class"=>"form-control selectcategory","id"=>"tipo_cuenta"]) !!}
                                        
                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("tipo_cuenta",$errors) !!}</p>
                                    </div>

                                    <div class="banco col-md-6 col-sm-12 col-xs-12">
                                        <label>Número Cuenta <span>*</span></label>
                                        <input
                                            type="number"
                                            name="numero_cuenta"
                                            class="form-control solo-numero"
                                            value="{{ ($candidato->numero_cuenta != 0) ? $candidato->numero_cuenta : '' }}"
                                            id="numero_cuenta"
                                        >
                                    
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
                                    </div>

                                    <!-- Confirma cuenta -->
                                    <div class="banco col-md-6 col-sm-12 col-xs-12">
                                        <label>Confirmar Cuenta <span>*</span></label>

                                        <input
                                            type="number"
                                            name="numero_cuenta_confirmation"
                                            class="form-control solo-numero"
                                            id="confirm_numero_cuenta"
                                            >
                                    
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta_confirmation", $errors) !!}</p>
                                    </div>

                                    <div></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($sitio->direccion_dian)
                    <div class="modal fade" id="modal_direccion_dian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Editor de la Dirección</h4>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-10 form-group" id="div_dir_codificacion">
                                                    {!! Form::text("direccion_dian", null, ["class" => "form-control", "required" => "required", "readonly" => "readonly", "id" => "direccion_dian", "placeholder" => "Dirección con codificación"]); !!}
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-default" id="limpiar_dir" type="button">Limpiar</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-12 text-justify fz-10">
                                                        <ul>
                                                            <li>Use las opciones de abajo para añadir su dirección, la podrá verificar en el cuadro superior.</li>
                                                            <li>Si no requiere algún campo lo puede dejar en blanco.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-8 form-group py-0">
                                                    <table cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="width: 30%">
                                                                <label for="clase_via_principal">Calle/Carrera</label>
                                                                {!! Form::select('clase_via_principal', $clase_via_principal, null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <label for="nro_via_principal">Número</label>
                                                                {!! Form::text("nro_via_principal", null, ["class" => "form-control input-number py-1 select-dir", "maxlength" => "3", "title" => "Número"]); !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <label for="letra_via_principal">Letra</label>
                                                                {!! Form::select('letra_via_principal', $letras_direccion, null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <label for="sufijo_via_principal">BIS</label>
                                                                {!! Form::select('sufijo_via_principal', ["" => "", "BIS" => "BIS"], null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <label for="letra_complementaria">Letra</label>
                                                                {!! Form::select('letra_complementaria', $letras_direccion, null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 15%">
                                                                <label for="sector">Zona</label>
                                                                {!! Form::select('sector', ["" => "", "ESTE" => "Este", "NORTE" => "Norte", "OESTE" => "Oeste", "SUR" => "Sur"], null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 7%" class="pb-1">
                                                                #
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 form-group py-0">
                                                    <table cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="width: 22%">
                                                                <label for="nro_via_generadora">Número</label>
                                                                {!! Form::text("nro_via_generadora", null, ["class" => "form-control input-number py-1 select-dir", "maxlength" => "3", "title" => "Número"]); !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 18%">
                                                                <label for="letra_via_generadora">Letra</label>
                                                                {!! Form::select('letra_via_generadora', $letras_direccion, null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 8%" class="pb-1">
                                                                -
                                                            </td>
                                                            <td style="width: 22%">
                                                                <label for="nro_predio">Número</label>
                                                                {!! Form::text("nro_predio", null, ["class" => "form-control input-number py-1 select-dir", "maxlength" => "3", "title" => "Número"]); !!}
                                                                <p></p>
                                                            </td>
                                                            <td style="width: 30%">
                                                                <label for="sector_predio">Zona</label>
                                                                {!! Form::select('sector_predio', ["" => "", "ESTE" => "Este", "NORTE" => "Norte", "OESTE" => "Oeste", "SUR" => "Sur"], null, ['class' => 'form-control py-1 select-dir']) !!}
                                                                <p></p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-justify fz-10">
                                                <ul>
                                                    <li>Ingrese su dirección complementaria: seleccione el tipo, ingrese el detalle y pique en "Adicionar complemento".</li>
                                                    <li>Puede ingresar tantos complementos como sea necesario.</li>
                                                </ul>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-8 form-group py-1" id="div_dir_codificacion">
                                                    <div class="col-md-6">
                                                        {!! Form::select('select_adc_complemento', $clase_complementaria, null, ['class' => 'form-control py-1', "id" => "select_adc_complemento"]) !!}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {!! Form::text("adc_complemento", null, ["class" => "form-control", "required" => "required", "id" => "adc_complemento"]); !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 py-1">
                                                    <button class="btn btn-default" id="adicionar_complemento" type="button">Adicionar Complemento</button>
                                                    <input type="hidden" name="direccion_complementaria" id="direccion_complementaria">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" id="aceptar_dir_dian">Aceptar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    
                <div class="col-md-12 separador"></div>

                <p class="direction-botones-center set-margin-top">
                    <button class="btn-quote" id="guardar_datos_basicos" type="button">
                        <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                    </button>
                </p>

                @if (route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                    @if ($pregs == 1)
                        <button class="btn pull-right" id="actualizar_pregs" type="button">
                            <i class="fa fa-floppy-o"></i> Actualizar Preguntas
                        </button>
                    @endif
                @endif
            {!! Form::close() !!}

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">CONSENTIMIENTO (POLÍTICA) DE CONFLICTO DE INTERESES</h4>
                        </div>

                        <div class="modal-body" style="height:400px;overflow:auto;">
                            <div id="texto" style="padding:10px;text-align:justify;margin:10px;font-family:arial;">
                                @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                                    tiene el candidato algún tipo de relación de parentesco -civil, afinidad o consanguinidad- con algún empleado o contratista, proveedor, cliente de la compañía; participación en la propiedad o gestión de un tercero como lo indica la Política de Conflicto de Intereses de Komatsu Colombia S.A.S., la cual puede ser consultada en el sitio web www.komatsu.com.co”.
                                    <br>

                                @else
                                    Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S. Por medio del presente documento otorgo mi consentimiento previo, expreso, e informado a T3RS S.A.S., filiales y subordinadas, en caso de tenerlas, para recolectar, almacenar, administrar, procesar, transferir, transmitir y/o utilizar (el “Tratamiento”) (i) toda información relacionada o que pueda asociarse a mí (los “Datos Personales”), y que le he revelado a la Compañía ahora o en el pasado, para ser utilizada bajo las finalidades consignadas en este documento, y (ii) aquella información de carácter sensible, entendida como información cuyo tratamiento pueda afectar mi intimidad o generar discriminación, como lo es, entre otra, información relacionada a salud o a los datos biométricos (los “Datos Sensibles”), para ser utilizada bajo las finalidades consignadas en este documento.
                                    <br/><br/>
                                    Declaro que he sido informado que el Tratamiento de mis Datos Personales y Datos Sensibles se ajustará a la Política de Tratamiento de la Información de T3RS, filiales y subordinadas. (La “Política”), a la cual tengo acceso, conozco y sé que puede ser consultada. Reconozco que, de conformidad con la Ley 1581 de 2012, el Decreto 1377 de 2013 y las demás normas que las modifiquen o deroguen (la “Ley”), mis Datos Personales y Datos Sensibles se almacenarán en las bases de datos administradas por la Compañía, y podrán ser utilizados, transferidos, transmitidos y administrados por ésta, según las finalidades autorizadas, sin requerir de una autorización posterior por parte mía.
                                    <br/><br/>
                                    Datos Sensibles. Declaro que he sido informado que mi consentimiento para autorizar el Tratamiento de mis Datos Sensibles, que hayan sido recolectado o sean recolectados por medio de esta autorización, es completamente opcional, a menos que exista un deber legal que me exija revelarlos o sea necesario revelarlos para salvaguardar mi interés vital y me encuentre en incapacidad física, jurídica y/o psicológica para hacerlo. He sido informado de cuáles son los Datos Sensibles que la Compañía tratará y he dado mi autorización para ello conforme a la Ley.
                                    <br/><br/>
                                    Alcance de la autorización. Declaro que la extensión temporal de esta autorización y el alcance de la misma no se limitan a los Datos Personales y/o Datos Sensibles recolectados en esta oportunidad, sino, en general, a todos los Datos Personales y/o Datos Sensibles que fueron recolectados antes de la presente autorización cuando la Ley no exigía la autorización. Este documento ratifica mi autorización retrospectiva del Tratamiento de mis Datos Personales y/o Datos Sensibles.
                                    <br/><br/>
                                    FFinalidades. Autorizo para que la Compañía realice el Tratamiento de los Datos Personales y Datos Sensibles para el cumplimiento de todas, o algunas de las siguientes finalidades: 
                                    <br/><br/>
                                    a. De licenciamiento de software o prestación de servicios de reclutamiento. <br/><br/>
                                    b. Enviar notificaciones de actualización de información. <br/><br/>
                                    c. Mensajes de agradecimiento y felicitaciones.<br/><br/>
                                    d. Gestionar toda la Información necesaria para el cumplimiento de las obligaciones contractuales y legales de la Compañía.<br/><br/>
                                    e. El proceso de archivo, de actualización de los sistemas, de protección y custodia de información y Bases de Datos de la Compañía.<br/><br/>
                                    i. Procesos al interior de la Compañía, con fines de desarrollo u operativo y/o de administración de sistemas. <br/><br/>
                                    j. Permitir el acceso a los Datos Personales a entidades afiliadas a la Compañía y/o vinculadas contractualmente para la prestación de servicios de consultoría en talento humano, bajo los estándares de seguridad y confidencialidad exigidos por la normativa. <br/><br/>
                                    k. La transmisión de Datos Personales a terceros en Colombia y/o en el extranjero, incluso en países que no proporcionen medidas adecuadas de protección de Datos Personales, con los cuales se hayan celebrado contratos con este objeto, para fines comerciales, administrativos y/u operativos.<br/><br/>
                                    l. Mantener y procesar por computadora u otros medios, cualquier tipo de Información relacionada con el perfil de los candidatos con el fin de análisis sus competencias,  habilidades y conocimiento. <br/><br/>
                                    m. Las demás finalidades que determinen los responsables del Tratamiento en procesos de obtención de Datos Personales para su Tratamiento, con el fin de dar cumplimiento a las obligaciones legales y regulatorias, así como de las políticas de la Compañía.<br/><br/>
                                    <br/><br/>
                                    Datos del responsable del Tratamiento. Declaro que he sido informado de los datos del responsable del Tratamiento de los Datos Personales y Datos Sensibles, los cuales son: 
                                    <br/><br/>
                                    El área responsable es Tecnología de T3RS administracion@t3rsc.co.<br/><br/>

                                    Derechos. Declaro que he sido informado de los derechos de habeas data que me asisten como titular de los Datos Personales y Datos Sensibles, particularmente, los derechos a conocer, actualizar, rectificar, suprimir los Datos Personales o revocar la autorización aquí otorgada, en los términos y bajo el procedimiento consagrado en la Política. Igualmente, declaro que puedo solicitar prueba de la autorización otorgada a la Compañía. He sido informado de los otros derechos que la Política me concede como Titular y soy consciente de los alcances jurídicos de esta autorización.
                                    <br/><br/>
                                    Transmisión o transferencia. He sido informado y autorizo a la Compañía a transmitir o transferir, según sea el caso, mis Datos Personales a terceros, dentro o fuera del territorio colombiano, para los procesos de licenciamiento de software y/o reclutamiento de personal para distintas compañías. Todos los Datos Personales que yo entregue a la Compañía o que hayan sido recibidos por la Compañía por terceros, entran dentro de esta autorización para ser transmitidos o transferidos si es requerido para el cumplimiento cabal de las finalidades aquí descritas. 
                                    <br/><br/>
                                    Autorización de terceros. Declaro que he obtenido la autorización de terceros que han sido incluidos en mis datos personales o de referencia y que he obtenido de ellos la autorización para que la Compañía los contacte, en caso de ser necesario, para verificar los Datos Personales que yo he entregado a la Compañía.
                                    <br/><br/>
                                    Duración. La Compañía podrá realizar el Tratamiento de mis Datos Personales por todo el tiempo que sea necesario para cumplir con las finalidades descritas en este documento y para que pueda prestar sus servicios licenciamiento de software y/o reclutamiento de personal para distintas compañías.
                                    <br/><br/>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-xs col-md-2 pull-right" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            @if (route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                <div class="modal fade" id="questionModal" aria-hidden="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Preguntas de Validación</h4>
                            </div>

                            <div class="modal-body">
                                <div class="alert alert-info" role="alert">
                                    Para completar tu registro debes completar las siguientes preguntas, los campos marcados con (*) son obligatorios.
                                </div>

                                <div id="error-preg" class="alert alert-warning" role="alert" style="display: none;">
                                    Debes completar todas las preguntas.
                                </div>

                                <div class="form-alt">
                                    <div class="row">
                                        {!! Form::model($preg_val,["id"=>"fr_preguntas_val","role"=>"form","method"=>"POST"]) !!}
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>¿ Cuál ha sido su mayor logro ? <span>*</span></label>

                                                {!! Form::text("respuesta_1",null,["class"=>"form-control" ,"id"=>"respuesta_1"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                 {!! FuncionesGlobales::getErrorData("respuesta_1",$errors) !!}
                                                </p>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>¿ Qué lo motiva a trabajar ? <span>*</span></label>

                                                {!! Form::text("respuesta_2",null,["class"=>"form-control" ,"id"=>"respuesta_2"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                 
                                                 {!! FuncionesGlobales::getErrorData("respuesta_2",$errors) !!}
                                                </p>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>¿ Cuáles son sus metas ? <span>*</span></label>

                                                {!! Form::text("respuesta_3",null,["class"=>"form-control" ,"id"=>"respuesta_3"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!! FuncionesGlobales::getErrorData("respuesta_3",$errors) !!}
                                                </p>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>¿ Qué actividades hace en su tiempo libre ? <span>*</span></label>

                                                {!! Form::text("respuesta_4",null,["class"=>"form-control" ,"id"=>"respuesta_4"]) !!}

                                                <p class="error text-danger direction-botones-center">
                                                    {!! FuncionesGlobales::getErrorData("respuesta_4",$errors) !!}
                                                </p>
                                            </div>

                                            {!! Form::hidden("act",null,["id" => "act_pregs"]) !!}

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="guardar_preguntas_validacion" class="btn btn-primary btn-sm col-md-2 pull-right">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
            <strong id="error"></strong>
        </div>
    </div>

    {{-- Modal con aceptación de políticas --}}
    <style>
        .swal-overlay{ z-index: 1000; }
    </style>

    @php

     $politicaActual = $datos_basicos->politicaActual();

    @endphp

    @if ( !$politicaActual['acepto'] )

        @if ( $datos_basicos->politicasPrivacidad()->count() == 0 )
            <script>
                const msgModalPolities = "Para continuar con el uso de nuestra plataforma, debes aceptar nuestras políticas de privacidad. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @elseif( $datos_basicos->politicasPrivacidad()->count() < $cantidad_politicas )
            <script>
                const msgModalPolities = "Hemos actualizado nuestra política de privacidad, para continuar con el uso de nuestra plataforma por favor haz clic en aceptar. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @else
            <script>
                const msgModalPolities = "Para continuar con el uso de nuestra plataforma, debes aceptar nuestras políticas de privacidad. <a target='_blank' href='{{route('admin.aceptacionPoliticaTratamientoDatos', ['politica_id' => $politicaActual['politica_id']])}}'>Ver políticas</a>"
            </script>
        @endif

        <script>
            const p = document.createElement("p")
            /*p.innerHTML = "Para continuar con el uso de nuestra plataforma, debes aceptar nuestras políticas de privacidad. <a type='button' data-toggle='modal' data-target='#modal_polities' href='#'>Ver políticas</a>"*/

            p.innerHTML = msgModalPolities
            
            swal({
                title: "Políticas de privacidad",
                content: p,
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: {
                            politica_id: "{{$politicaActual['politica_id']}}"
                        },
                        url: "{{ route('cv.privacyAccept') }}",
                        success: function (response) {
                            swal({
                                text: "Políticas aceptadas correctamente.",
                                icon: "success"
                            })
                        },
                        error: function (response) {
                            swal({
                                text: "Se ha presentado un error, intenta nuevamente.",
                                icon: "error"
                            })
                        }
                    });
                } else {
                    swal({
                        text: "Debes aceptar nuestras políticas de privacidad para continuar.",
                        icon: "error"
                    })

                    setTimeout(() => {
                        location.reload()
                    }, 2000)
                }
            });
        </script>
    @endif

    <script>
        @if($sitio->direccion_dian)
            $('#direccion').click(function() {
                $('#modal_direccion_dian').modal('show');
            })

            $('#direccion').focus(function() {
                $('#modal_direccion_dian').modal('show');
            })

            $('.select-dir').change(function(){
                var dir_dian = '';
                $('.select-dir').each(function (id, item) {
                    if (item.value != '') {
                        if (dir_dian != '') {
                            dir_dian = dir_dian + ' ' + item.value;
                        } else {
                            dir_dian = item.value;
                        }
                    }
                });
                if ($('#direccion_complementaria').val() != '') {
                    $('#direccion_dian').val(dir_dian + ' ' + $('#direccion_complementaria').val());
                } else {
                    $('#direccion_dian').val(dir_dian);
                }
            });

            $('#adicionar_complemento').click(function() {
                if ($('#adc_complemento').val() != '') {
                    let dir_dian = $('#direccion_dian').val();
                    let dir_complementaria = $('#direccion_complementaria').val();
                    $('#direccion_dian').val(dir_dian + ' ' + $('#select_adc_complemento').val() + ' ' + $('#adc_complemento').val());
                    if (dir_complementaria != '') {
                        $('#direccion_complementaria').val(dir_complementaria + ' ' + $('#select_adc_complemento').val() + ' ' + $('#adc_complemento').val());
                    } else {
                        $('#direccion_complementaria').val($('#select_adc_complemento').val() + ' ' + $('#adc_complemento').val());
                    }
                    $('#select_adc_complemento').val('');
                    $('#adc_complemento').val('');
                }
            })

            $('#limpiar_dir').click(function() {
                $('#direccion_dian').val('');
                $('.select-dir').each(function (id, item) {
                    item.value = '';
                });
                $('#direccion_complementaria').val('');
            });

            $('#aceptar_dir_dian').click(function() {
                if ($('#direccion_dian').smkValidate()) {
                    $('#direccion').val($('#direccion_dian').val());
                    $('#modal_direccion_dian').modal('hide');
                }
            })
        @endif

        $(function () {
            $('#hijos').change(function(){
                if ($(this).val() == 1){
                    $('#numero_hijos').show();
                }else{
                    if ($(this).val() == 0){
                     $('#numero_hijos').hide();
                    }
                }
            });

            $('#conflicto').change(function(){
                if ($(this).val() == 1){
                    $('#descripcion_conflicto').show();
                }else{
                  if($(this).val() == 0){
                        $('#descripcion_conflicto').hide();
                  }
                }
            });

            var inputs = "textarea[maxlength]";

            //Guardar Datos Basicos
            $("#guardar_datos_basicos").on("click", function () {
                var formData = new FormData(document.getElementById("fr_datos_basicos"));

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{route('guardar_datos_basicos')}}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#mensaje-error").hide();
                        $("input").css({"border": "1px solid #ccc"});
                        $("select").css({"border": "1px solid #ccc"});
                        
                        // mensaje_success("Datos Basicos Guardados");
                        swal("Datos Guardados", "Tus datos básicos fueron guardados", "info");

                        @if (route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                            if (data.pregs == 0) {
                                $('#questionModal').modal('show');
                            }else{
                                setTimeout(function(){
                                    window.location.href = '{{route('experiencia').'#fr_experiencias'}}';
                                }, 3000);
                            }
                        @elseif(route('home') == "https://gpc.t3rsc.co")
                            setTimeout(function(){
                                window.location.href = '{{ route('cv.autoentrevista') }}';
                            }, 2000);
                        @else
                            setTimeout(function(){
                                @if(route('home') == "http://komatsu.t3rsc.co" ||route('home') == "https://komatsu.t3rsc.co")
                                    window.location.href = '{{route('video_perfil').'#gum'}}';
                                @else
                                    window.location.href = '{{route('experiencia').'#fr_experiencias'}}';
                                @endif
                            }, 3000);
                        @endif
                    },
                    error:function(data){
                        $(document).ready(function(){
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            $(".text").remove();
                        });

                        @if (route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                            if ($('#archivo_documento').val() == null || $('#archivo_documento').val() == '') {
                                $('#archivo_documento').addClass('borderojo');
                                $('#archivo_documento').focus();
                            }

                            if ($('#numero_hijos').val() == null || $('#numero_hijos').val() == '') {
                                $('#numero_hijos').addClass('borderojo');
                                $('#numero_hijos').focus();
                            }
                        @endif

                        var nombres = $("#nombres").val();

                            
                        $.each(data.responseJSON.errors, function(index, val){

                            document.getElementById(index).style.border = 'solid red';
                            $('input[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                            $('select[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                        });

                        $("#error").html("Upps "+nombres+", olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");

                        $("#mensaje-error").fadeIn();
                    }
                });
            });

            $("#guardar_preguntas_validacion").on("click", function () {
                if ($('#pregunta_1').val() == ''){
                    $('#error-preg').show('slow');
                }else if($('#pregunta_2').val() == ''){
                    $('#error-preg').show('slow');
                }else if($('#pregunta_3').val() == ''){
                    $('#error-preg').show('slow');
                }else if($('#pregunta_4').val() == ''){
                    $('#error-preg').show('slow');
                }else{
                    var formData = new FormData(document.getElementById("fr_preguntas_val"));

                    $.ajax({
                        type: "POST",
                        data: formData,
                        url: "{{route('guardar_preguntas_val')}}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            swal("Datos Guardados", "Las preguntas fueron guardadas.", "info");

                            $('#error-preg').hide('slow');
                            $('#questionModal').modal('hide');

                            setTimeout(function(){
                                @if(route('home') == "http://komatsu.t3rsc.co" ||route('home') == "https://komatsu.t3rsc.co")
                                    window.location.href = '{{route('video_perfil').'#gum'}}';
                                @else
                                    window.location.href = '{{route('experiencia').'#fr_experiencias'}}';
                                @endif
                            }, 3000);
                        },
                        error:function(data){
                            swal("Ocurrio un error", "Vuelve a intentarlo de nuevo.", "danger");
                        }
                    });
                }
            });

            $("#actualizar_pregs").on("click", function () {
                $('#act_pregs').val(1);
                $('#questionModal').modal('show');
            });
           
           @if(route("home") != "https://gpc.t3rsc.co")
            $("#fecha_expedicion, #fecha_nacimiento").datepicker(confDatepicker);
            $("#fecha_expedicion, #fecha_nacimiento").datepicker('option', {
                maxDate: 0,
            });
           @endif

            var countries = [
                {value: 'Andorra', data: 'AD'},
                {value: 'Zimbabwe', data: 'ZZ'}
            ];

            $('#ciudad_autocomplete').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad_expedicion").show();
                $("#select_expedicion_id").val("no");                
            });

            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#error_ciudad_expedicion").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $(this).data("selec")=="si";
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_expedicion_id").val(suggestion.cod_departamento);
                    $("#ciudad_expedicion_id").val(suggestion.cod_ciudad);
                }
            });

            $('#txt_nacimiento').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#error_ciudad_nacimiento").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_nacimiento").val(suggestion.cod_pais);
                    $("#departamento_nacimiento").val(suggestion.cod_departamento);
                    $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
                }
            });

            $('#txt_nacimiento').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad_nacimiento").show();
            });

            $('#txt_residencia').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#error_ciudad_residencia").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_residencia").val(suggestion.cod_pais);
                    $("#departamento_residencia").val(suggestion.cod_departamento);
                    $("#ciudad_residencia").val(suggestion.cod_ciudad);
                }
            });
            
            $('#txt_residencia').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad_residencia").show();
            });

            $(document).on("change", ".direccion", function(){
                var txtConcat = "";
                var campos = $(".direccion");
                $("#direccion").val("");

                $.each(campos, function (key, value){
                    var campos = $(value);
                    var type = campos.attr("type");

                    if (type == "checkbox") {
                        if (campos.prop("checked")) {
                            txtConcat += campos.val() + " ";
                        }
                    } else {
                        txtConcat += campos.val() + " ";
                    }
                })
                $(this).val(txtConcat);
            });
            
            $(document).on("keyup", ".direccion_txt", function () {
                var txtConcat = "";
                var campos = $(".direccion");
                $("#direccion").val("");

                $.each(campos, function (key, value) {
                    var campos = $(value);
                    var type = campos.attr("type");

                    if (type == "checkbox") {
                        if (campos.prop("checked")) {
                            txtConcat += campos.val() + " ";
                        }
                    } else {
                        txtConcat += campos.val() + " ";
                    }

                })
              $(this).val(txtConcat);
            });

            //Para tiempos
            genero();
            licencia();
            situacion_militar();
            vehiculo();
            grupoPoblacional();
            cuenta_bancaria();
            @if( isset($datos_basicos->grupo_poblacional) && $datos_basicos->grupo_poblacional == "Otro" )
                $('#otro_grupo').show()
            @endif
            
            $(document).on("change", "#pertenece_grupo_poblacional", function() {
                grupoPoblacional();
            });

            $(document).on("change", "#select_grupo_poblacional", function() {
                let val = $(this).val();

                if (val == "Otro") {
                    $('#otro_grupo').show()
                }else{
                    $('#otro_grupo').hide()
                }
            });
            
            $(document).on("change", "#genero", function () {
                genero();
            });

            $(document).on("change", "[name='tiene_licencia']", function () {
                licencia();
               $('[name="categoria_licencia"]').val('');
            });

            $(document).on("change", "#tiene_vehiculo", function () {
                vehiculo();
               $('#tipo_vehiculo').val('');
            });

            $(document).on("change", "[name='tiene_cuenta_bancaria']", function () {
                cuenta_bancaria();
            });

            function grupoPoblacional(){
                let val = $('#pertenece_grupo_poblacional').val();
                
                $('#otro_grupo').hide()

                if (val == 1) {
                    $("#grupo_poblacional").show();
                }else{
                    $("#select_grupo_poblacional").val();
                    $("#otro_grupo_poblacional").val();
                    $("#grupo_poblacional").hide();
                }
            }

            function genero(){
                valu = $('#genero').val();
                  
                if(valu == 1){
                    str = $("#nombres").val();
                  
                    $("#nombres").show();
                    $("#situacion_militar").show();

                    @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
              
                        letra = str.substring(str.length-1);

                        if(letra == "a"){
                            alert('Asegurate del diligenciamiento del campo genero');
                        }
              
                    @endif
                }else{
                    $("#situacion_militar").hide();
                }
            }

            function licencia(){
                if ($('[name="tiene_licencia"]').val() == 1){
                    $('[name="categoria_licencia"]').parent('div').show();
                }else{
                    $('[name="categoria_licencia"]').parent('div').hide();
                }
            }

            function vehiculo(){
                if ($('#tiene_vehiculo').val() == 1){
                    $('#tipo_vehiculo').parent('div').show();
                }else{
                    $('#tipo_vehiculo').parent('div').hide();
                }
            }

            function cuenta_bancaria() {
                if( $("#tiene_cuenta_bancaria").val() == 1 ){

                    $(".banco").fadeIn();
                }else{
                    $(".banco").fadeOut();
                }
            }

            //situacion militar definida
            $(document).on('change', '.militar_situacion', function(event){
                situacion_militar();

                $("#numero_libreta").val('');
                $("#clase_libreta").val('');
            })

            function situacion_militar(){
                var value = $('.militar_situacion').val();

                if( value == 1) {
                    $('.libreta_militar').show();
                }else{
                    $('.libreta_militar').hide();
                }
            }

            $("#pais_id").change(function(){
                var valor = $(this).val();

                $.ajax({
                    url: "{{ route('cv.selctDptos') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.dptos;
                        $('#departamento_expedicion_id').empty();
                        $('#departamento_expedicion_id').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#departamento_expedicion_id').append("<option value='" + element.cod_departamento + "'>" + element.nombre + "</option>");
                        });

                        $('#ciudad_expedicion_id').empty();
                        $('#ciudad_expedicion_id').append("<option value=''>Seleccionar</option>");
                    }
                });
            });

            $("#departamento_expedicion_id").change(function(){
                var valor = $(this).val();
                var pais=$("#pais_id").val();

                $.ajax({
                    url: "{{ route('cv.selctCiudades') }}",
                    type: 'POST',
                    data: {
                        id: valor,
                        pais:pais
                    },
                    success: function(response){
                        var data = response.ciudades;
                        $('#ciudad_expedicion_id').empty();
                        $('#ciudad_expedicion_id').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#ciudad_expedicion_id').append("<option value='" + element.cod_ciudad + "'>" + element.nombre + "</option>");
                        });
                    }
                });
            });

            $("#pais_residencia").change(function(){
                var valor = $(this).val();

                $.ajax({
                    url: "{{ route('cv.selctDptos') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.dptos;
                        $('#departamento_residencia').empty();
                        $('#departamento_residencia').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#departamento_residencia').append("<option value='" + element.cod_departamento + "'>" + element.nombre + "</option>");
                        });

                        $('#ciudad_residencia').empty();
                        $('#ciudad_residencia').append("<option value=''>Seleccionar</option>");
                    }
                });
            });

            $("#departamento_residencia").change(function(){
                var valor = $(this).val();
                var pais=$("#pais_residencia").val();
                $.ajax({
                    url: "{{ route('cv.selctCiudades') }}",
                    type: 'POST',
                    data: {
                        id: valor,
                        pais:pais
                    },
                    success: function(response){
                        var data = response.ciudades;
                        $('#ciudad_residencia').empty();
                        $('#ciudad_residencia').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#ciudad_residencia').append("<option value='" + element.cod_ciudad + "'>" + element.nombre + "</option>");
                        });
                    }
                });
            });

            $("#pais_nacimiento").change(function(){
                var valor = $(this).val();

                $.ajax({
                    url: "{{ route('cv.selctDptos') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.dptos;
                        $('#departamento_nacimiento').empty();
                        $('#departamento_nacimiento').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#departamento_nacimiento').append("<option value='" + element.cod_departamento + "'>" + element.nombre + "</option>");
                        });

                        $('#ciudad_nacimiento').empty();
                        $('#ciudad_nacimiento').append("<option value=''>Seleccionar</option>");
                    }
                });
            });

            $("#departamento_nacimiento").change(function(){
                var valor = $(this).val();
                var pais=$("#pais_nacimiento").val();

                $.ajax({
                    url: "{{ route('cv.selctCiudades') }}",
                    type: 'POST',
                    data: {
                        id: valor,
                        pais:pais
                    },
                    success: function(response){
                        var data = response.ciudades;
                        $('#ciudad_nacimiento').empty();
                        $('#ciudad_nacimiento').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#ciudad_nacimiento').append("<option value='" + element.cod_ciudad + "'>" + element.nombre + "</option>");
                        });
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function(){
            var pass1 = $('[name=numero_cuenta]');
            var pass2 = $('[name=numero_cuenta_confirmation]');
            var confirmacion = "Las cuentas si coinciden";
            
            //var longitud = "La contraseña debe estar formada entre 6-10 carácteres (ambos inclusive)";
            var negacion = "No coinciden las cuentas";
            var vacio = "El número de cuenta no puede estar vacío";
            //oculto por defecto el elemento span
            var span = $('<span></span>').insertAfter(pass2);
            span.hide();

            //función que comprueba las dos contraseñas
            function coincidePassword(){
                var valor1 = pass1.val();
                var valor2 = pass2.val();
                
                //muestra el span
                span.show().removeClass();
                
                //condiciones dentro de la función
                if(valor1 != valor2){
                    span.text(negacion).addClass('negacion'); 
                }
                
                if(valor1.length==0 || valor1==""){
                    span.text(vacio).addClass('negacion');  
                }

                /*if(valor1.length<6 || valor1.length>10){
                    span.text(longitud).addClass('negacion');
                }*/

                if(valor1.length!=0 && valor1==valor2){
                    span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
                }
            }
            
            //ejecuta la función al soltar la tecla
            pass2.keyup(function(){
                coincidePassword();
            });
        });
    </script>
@stop