@extends("cv.layouts.master")
<?php
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];
?>
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" )
        <style>
            .ui-datepicker-calendar {
                display: none;
            }
        </style>
    @endif

    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1 class="titulo-principal-seccion">Empleos Anteriores</h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="submit_listing_box">
                    <h3 class="header-section-form"> 
                        <span class='text-danger sm-text'>
                            Recuerde que los campos marcados con el símbolo (*) son obligatorios. 
                        </span>
                    </h3>

                    @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                        <ul style="text-align: justify; padding: 5%; padding-top: 2%; font-size: 1.4rem;"  class="instrucciones">
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

                    <p class="text-primary set-general-font-bold">
                        Por favor ingresa los datos de tus empleos anteriores, ingresa desde el más antiguo al más reciente.
                    </p>
                
                    {!!Form::open(["role"=>"form", "id"=>"fr_experiencias"]) !!}
                        {!! Form::hidden("id",null,["class"=>"id_modificar_experiencia", "id"=>"id_modificar_experiencia"]) !!}

                        <div class="form-alt">
                            <div class="row">
                                <p class="direction-botones-left">
                                 <a href="#grilla" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Experiencias</a>
                                </p>

                                <div id="no_tengo" class="col-md-12 mb-4">
                                    <label>
                                        {!! Form::checkbox("tiene_experiencia",0,isset($datos_basicos->tiene_experiencia) && $datos_basicos->tiene_experiencia == "0" ? 1 : null,["class"=>"tiene_experiencia","id"=>"tiene_experiencia", "style" => "height:initial;"]) !!}
                                        No tengo experiencia</label>
                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Nombre empresa
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            /Company Name
                                        @endif : <span>*</span>
                                    </label>
                
                                    {!! Form::text("nombre_empresa",null,["class"=>"form-control", "id"=>"nombre_empresa", "placeholder"=>"Nombre Empresa" ])!!}
                                </div>
                                
                                @if(route('home') != "https://gpc.t3rsc.co" )
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Teléfono empresa
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /Company Phone
                                            @endif: <span></span>
                                        </label>

                                        {!! Form::number("telefono_temporal",null,["class"=>"form-control", "id"=>"telefono_temporal", "placeholder"=>"Telefono Empresa" ]) !!}
                                    </div>
                                @endif

                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Ciudad
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /City
                                            @endif : <span>*</span>

                                            <span style="color:red;display: none;" id="error_ciudad">Debe seleccionar de la lista</span>
                                        </label>

                                        {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                                        {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                                        {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}

                                        {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}
                                    </div>
                                @endif

                                {{--@if(route('home') == "https://gpc.t3rsc.co")--}}
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            Cargo desempeñado
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /Position Held
                                            @endif : <span> * </span>
                                        </label>

                                        {!!Form::text("cargo_especifico",null,["class"=>"form-control","id"=>"cargo_especifico","placeholder"=>"Cargo Desempeñado"])!!}
                                    </div>
                                {{--@endif--}}

                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label> Nivel cargo
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /Lavel Charge
                                            @endif :

                                            @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif
                                        </label>

                                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                                            {!! Form::select("nivel_cargo",[
                                                "" => "Seleccionar",
                                                "Operativo" => "Operativo",
                                                "Comercial" => "Comercial",
                                                "Medio" => "Medio",
                                                "Profesional" => "Profesional",
                                                "Directivo" => "Directivo"
                                            ],null,["class"=>"form-control", "id"=>"nivel_cargo"]) !!}
                                        @else
                                            {!! Form::select("nivel_cargo",[
                                                "" => "Seleccionar",
                                                "Asesor" => "Asesor",
                                                "Asistencial" => "Asistencial",
                                                "Directivo" => "Directivo",
                                                "Operativo" => "Operativo",
                                                "Profesional" => "Profesional",
                                                "Técnico" => "Técnico"
                                            ],null,["class"=>"form-control", "id"=>"nivel_cargo"]) !!}
                                        @endif
                                    </div>
                                @endif

                                @if(route('home')!= "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            @if(route('home') != "https://gpc.t3rsc.co")
                                                Cargo similar
                                            @else
                                                Cargo genérico
                                            @endif

                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /Similar Charge
                                            @endif : <span>*</span>
                                        </label>
                                        
                                        {!!Form::select("cargo_desempenado", $cargoGenerico, null, ["class" => "form-control" ,"id" => "cargo_desempenado"])!!}
                                    </div>

                                    @if (route('home') == "https://gpc.t3rsc.co")
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12" style="display: none;" id="cargoOtro">
                                            <label>
                                                Digite cargo
                                                <span>*</span>
                                            </label>

                                            {!!Form::text("cargo_otro", null, [
                                                "class" => "form-control",
                                                "id" => "cargo_otro",
                                                "placeholder" => "Digite el cargo",
                                                "autofocus"
                                            ])!!}
                                        </div>
                                    @endif

                                    @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" )
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label>
                                                Nombre @if(route('home') != "https://gpc.t3rsc.co") jefe : <span> * </span> @else supervisor :@endif
                                            </label>

                                            {!!Form::text("nombres_jefe", null, [
                                                "class" => "form-control",
                                                "id" => "nombres_jefe",
                                                "placeholder" => "Nombre Jefe Inmediato"
                                            ])!!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Cargo @if(route('home') != "https://gpc.t3rsc.co") jefe @else supervisor @endif <span> *</span> :</label>

                                            {!!Form::text("cargo_jefe",null,["class"=>"form-control","id"=>"cargo_jefe", "placeholder"=>"Cargo Jefe Inmediato"])!!}
                                        </div>

                                        @if (route('home') == "https://gpc.t3rsc.co")
                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                <label> Le reportan:  </label>
                                                {!!Form::text("le_reportan",null,["class"=>"form-control","id"=>"le_reportan", "placeholder"=>"Cargo le reportan"])!!}
                                            </div>
                                        @endif
                        
                                        @if(route('home') != "https://gpc.t3rsc.co")
                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                <label> Teléfono móvil jefe: </label>

                                                {!! Form::text("movil_jefe",null,["class"=>"form-control solo-numero","id"=>"movil_jefe", "placeholder"=>"Movil Jefe" ]) !!}
                                            </div>

                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                <label>Teléfono fijo jefe: </label>
                                                <div class="col-md-8"> 
                                                    {!!Form::text("fijo_jefe",null,["class"=>"form-control solo-numero","id"=>"fijo_jefe", "placeholder"=>"Fijo Jefe"])!!}
                                                </div>

                                                <div class="col-md-4"> 
                                                    {!! Form::text("ext_jefe",null,["class"=>"form-control", "id"=>"ext_jefe", "placeholder"=>"Extension Fijo"]) !!}
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                         
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        @if(route('home') == "https://gpc.t3rsc.co")
                                            Fecha ingreso
                                        @else
                                            Fecha inicio
                                        @endif

                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Start Date @endif :<span>*</span>
                                    </label>
                                    
                                    {!! Form::text("fecha_inicio",null,["class"=>"form-control", "id"=>"fecha_inicio" ,"placeholder"=>"Fecha Inicio"]) !!}
                                </div>

                                {{-- Trabajo Actual --}}
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        Trabajo actual
                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            /Current Work
                                        @endif : <span> </span>
                                    </label>

                                    {!!Form::select("empleo_actual",[''=>"Seleccione", '1' => "Si", '2' => "No"], null, ["class" => "form-control empleo_actual", "id" => "empleo_actual"])!!}
                                </div>

                                <div class="ocultar">
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label>
                                            @if(route('home') == "https://gpc.t3rsc.co")
                                                Fecha salida
                                            @else
                                                Fecha terminación
                                            @endif

                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                /Finished Date
                                            @endif : <span></span>
                                        </label>
                                        
                                        {!!Form::text("fecha_final",null,["class"=>"form-control", "id"=>"fecha_final" ,"placeholder"=>"Fecha Terminación"]) !!}
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-xs-12" id="arned_salary">
                                    <label>
                                      @if(route('home') == "https://gpc.t3rsc.co") Último salario @else Salario devengado @endif
                                        
                                      @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                        /Earned Salary
                                      @endif: <span>*</span>
                                    </label>

                                    @if(route('home') == "http://localhost:8000" || route('home') == "https://demo.t3rsc.co" ||
                                        route('home') == "https://soluciones.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                                        {!! Form::text("salario_devengado", null, [
                                            "class" => "form-control input-number",
                                            "id" => "salario_devengado",
                                            "min" => "1",
                                            "placeholder" => ""
                                        ])!!}
                                    @else
                                        {!! Form::select("salario_devengado",$aspiracionSalarial, null, ["class"=>"form-control" ,"id"=>"salario_devengado"]) !!}
                                    @endif
                                </div>

                                <div class="ocultar form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>
                                        @if(route('home') == "https://gpc.t3rsc.co")
                                            Motivo de salida de la empresa
                                        @else
                                            Motivo retiro
                                        @endif

                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                            /Reason for retirement
                                        @endif :

                                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ||
                                            route('home') == "https://gpc.t3rsc.co")
                                            <span>*</span>
                                        @endif
                                    </label>
                              
                                    {!! Form::select("motivo_retiro",$motivos,null,["class"=>"form-control","id"=>"motivo_retiro"]) !!}
                                </div>

                                <br>

                                @if(route('home') == "https://gpc.t3rsc.co")
                                    <div id="actual_show">
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Sueldo fijo bruto <span>*</span>: </label>
                                            {!! Form::number("sueldo_fijo_bruto", null, ["class" => "form-control", "id" => "sueldo_fijo_bruto", "autofocus"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Ingreso variable mensual (comisiones/bonos): </label>
                                            {!! Form::number("ingreso_varial_mensual", null, ["class" => "form-control", "id" => "ingreso_varial_mensual"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Otros bonos (monto y periodicidad): </label>
                                            {!! Form::text("otros_bonos", null, ["class" => "form-control", "id" => "otros_bonos"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Total ingreso anual: </label>
                                            {!! Form::number("total_ingreso_anual", null, ["class" => "form-control", "id" => "total_ingreso_anual"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Total ingreso mensualizado: </label>
                                            {!! Form::number("total_ingreso_mensual", null, ["class" => "form-control", "id" => "total_ingreso_mensual"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Utilidades (individual y carga): </label>
                                            {!! Form::number("utilidades", null, ["class" => "form-control", "id" => "utilidades"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Valor actual fondos de reserva: </label>
                                            {!! Form::number("valor_actual_fondos", null, ["class" => "form-control", "id" => "valor_actual_fondos"]) !!}
                                        </div>

                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label> Beneficios no monetarios: </label>
                                            {!! Form::text("beneficios_monetario", null, ["class" => "form-control", "id" => "beneficios_monetario"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                      <label> Linea negocio: </label>
                                      {!!Form::text("linea_negocio",null,["class"=>"form-control","id"=>"linea_negocio"])!!}
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label> Tipo compañia: </label>
                                        {!!Form::select("tipo_compania",['' => "Seleccione",'nacional' => "Nacional",'transnacional' => "Transnacional",'multinacional' => "Multinacional"], null, ["class" => "form-control" ,"id" => "tipo_compania"]) !!}
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                      <label> Ventas anuales de la empresa: </label>
                                       {!!Form::text("ventas_empresa",null,["class"=>"form-control","id"=>"ventas_empresa"])!!}
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                      <label> Numero colaboradores de la empresa: </label>
                                       {!!Form::number("num_colaboradores",null,["class"=>"form-control","id"=>"num_colaboradores"])!!}
                                    </div>

                                   @if(route('home') == "http://localhost:8000")
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                     <label> Otros cargos desempeñados: </label>
                                     {!!Form::text("otro_cargo",null,["class"=>"form-control","id"=>"otro_cargo"])!!}
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                     <label> Especificar tiempos: </label>
                                      {!!Form::text("tiempo_cargo",null,["class"=>"form-control","id"=>"tiempo_cargo"])!!}
                                    </div>
                                    @endif
                                    <br>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                      <label> Funciones (al menos 5 funciones específicas): <span>*</span> </label>
                                       {!! Form::textarea("funciones_logros",null,["maxlength"=>"550","class"=>"form-control","rows"=> 3, "placeholder"=>"Escribe acá tu funciones.  Máximo 550 caracteres", "id"=>"funciones_logros"])!!}

                                        <p class="error text-danger direction-botones-center">
                                         {!! FuncionesGlobales::getErrorData("direccion",$errors) !!}
                                        </p>
                                    </div>

                                    <br>

                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label> Logros: <span>*</span></label>
                                        {!! Form::textarea("logros",null,["maxlength"=>"550","class"=>"form-control","rows"=> 3, "placeholder"=>"Escribe acá tus logros. Máximo 550 caracteres","id"=>"logros"])!!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("direccion",$errors) !!}
                                        </p>
                                    </div>
                                @endif

                                <br>

                                @if(route('home') != "https://gpc.t3rsc.co")
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           
                                    <label>Funciones y logros: <span>*</span></label>
                                    
                                    {!! Form::textarea("funciones_logros", null, [
                                        "maxlength" => "550",
                                        "class" => "form-control",
                                        "rows" => 3,
                                        "placeholder" => "Escribe acá tu funciones y logros.  Máximo 550 caracteres",
                                        "name" => "funciones_logros",
                                        "id" => "funciones_logros"])!!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("direccion",$errors) !!}
                                        </p>
                                    </div>
                                @endif

                                {!!Form::hidden("autoriza_solicitar_referencias", 1, null, [
                                    "class" => "checkbox-preferencias" ,
                                    "data-state" => "false",
                                    "id" => "autorizo_referencia"
                                ])!!}

                                <p class="direction-botones-center set-margin-top">
                                    <button class="btn btn-warning pull-right" id="cancelar_experiencia" style="display:none; margin: auto 10px auto;" type="button">
                                        <i class="fa fa-pencil"></i>
                                        Cancelar
                                    </button>

                                    <button class="btn btn-success pull-right" id="actualizar_experiencia" style="display:none; margin: auto 10px auto;" type="button">
                                        <i class="fa fa-floppy-o"></i>
                                        Actualizar
                                    </button>
                                    
                                    <button class="btn btn-success pull-right" id="guardar_experiencias" type="button">
                                        <i class="fa fa-floppy-o"></i>
                                        Guardar @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")  y Siguiente @endif
                                    </button>
                                </p>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    
                    <hr>

                    <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                        <strong id="error"></strong>
                    </div>

                    {{-- Lista de Empleos --}}
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(["id"=>"grilla"]) !!}
                                <div class="grid-container table-responsive">
                                    <table class="table table-striped" id="tbl_experiencias">
                                        <thead>
                                            <tr>
                                              <th> Empresa
                                                @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                 /Company Name
                                                @endif
                                              </th>

                                                @if(route('home') != "https://gpc.t3rsc.co")
                                                  <th>Teléfono empresa
                                                   @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                    /Company Phone
                                                   @endif
                                                  </th>
                                                @endif

                                                @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" &&
                                                    route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" )
                                                    <th>Nombres @if(route('home') != "https://gpc.t3rsc.co") jefe inmediato @else supervisor @endif </th>
                                          
                                                    @if(route('home') != "https://gpc.t3rsc.co")
                                                      <th>Teléfono fijo</th>
                                                      <th>Teléfono móvil</th>
                                                    @endif
                                                    <th>Cargo @if(route('home') == "https://gpc.t3rsc.co") supervisor @endif </th>
                                                @endif

                                                <th>
                                                    Fecha ingreso
                                                    @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                        /Start Date
                                                    @endif
                                                </th>
                                                
                                                <th>
                                                    Fecha salida
                                                    @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                                        /Finished Date
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if($experiencias->count() == 0)
                                              <tr id="registro_nulo">
                                               <td colspan="6">No hay registros</td>
                                              </tr>
                                            @endif
                                            
                                            @foreach($experiencias as $experiencia)
                                                <tr id="tr_{{$experiencia->id}}">
                                                    <td>{{$experiencia->nombre_empresa}}</td>

                                                    @if(route('home') != "https://gpc.t3rsc.co")
                                                      <td>{{$experiencia->telefono_temporal}}</td>
                                                    @endif

                                                    @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" && route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" )

                                                      <td>{{$experiencia->nombres_jefe}}</td>
                                                        
                                                        @if(route('home') != "https://gpc.t3rsc.co")
                                                          <td> {{$experiencia->fijo_jefe}} </td>
                                                          <td> {{$experiencia->movil_jefe}} </td>
                                                        @endif

                                                      <td> {{$experiencia->cargo_jefe}} </td>
                                                    
                                                    @endif

                                                    <td> {{$experiencia->fecha_inicio}} </td>
                                                    
                                                    @if ($experiencia->empleo_actual == 1)
                                                        <td> Empleo actual </td>
                                                    @else
                                                        <td> {{$experiencia->fecha_final}} </td>                                                        
                                                    @endif
                                                    
                                                    <td>
                                                        {!! Form::hidden("id",$experiencia->id, ["id"=>$experiencia->id]) !!}
                                                        <button class="btn btn-info btn-peq certificados" type="button" title="Certificados">
                                                            <i class="fa fa-file-text-o"></i>
                                                        </button>

                                                        <button class="btn btn-primary btn-peq editar_experiencia disabled_experiencia" type="button">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>

                                                        <button class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia" type="button">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $('.ocultar').show();

            @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
              $('#actual_show').hide();
            @endif

            $('.empleo_actual').change(function(){
                if($(this).val() == 1){
                    $('.ocultar').hide();
                    $('#actual_show').show();

                    @if (route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                        $('#arned_salary').hide();
                    @endif
                }else{
                    $('.ocultar').show();
                    $('#actual_show').hide();

                    @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                     $('#arned_salary').show();
                    @endif
                }
            });

            @if (route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                $('#cargo_desempenado').change(function(){
                    if($(this).val() == 39){
                        $('#cargoOtro').show();
                    }else{
                        $('#cargoOtro').hide();
                    }
                });
            @endif
          
            @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                $('#funciones_logros').parent('div').hide();

                $('#nivel_cargo').change(function(){
                    var valor = $(this).val();
               
                    if(valor == "Operativo"){
                        $('#funciones_logros').parent('div').hide();
                    }else{
                        $('#funciones_logros').parent('div').show();
                    }
                })

                $('#funciones_logros').parent('div').hide();
            @endif
        });

        $(function () {
            var inputs = "textarea[maxlength]";
         
            $(document).on('keyup', "[maxlength]", function (e) {
                var este = $(this),
                maxlength = este.attr('maxlength'),
                maxlengthint = parseInt(maxlength),
                textoActual = este.val(),
                currentCharacters = este.val().length;
                remainingCharacters = maxlengthint - currentCharacters,
                espan = este.prev('label').find('span');

                // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
                if (document.addEventListener && !window.requestAnimationFrame) {
                    if (remainingCharacters <= -1) {
                        remainingCharacters = 0;            
                    }
                }

                espan.html(remainingCharacters);
                
                if (!!maxlength) {
                    var texto = este.val(); 
                    if (texto.length >= maxlength) {
                        este.addClass("borderojo");
                        este.val(text.substring(0, maxlength));
                        e.preventDefault();
                    }
                    else if (texto.length < maxlength) {
                        este.addClass("bordegris");
                    }
                }   
            });

            @if( isset($datos_basicos->tiene_experiencia) && $datos_basicos->tiene_experiencia == "0" )

                 $(".form-group").fadeOut()
                 
            @endif

            $("#tiene_experiencia").on("click", function() {
                
                if( $( this ).is( ':checked' ) ){

                    $(".form-group").fadeOut()
                }else{

                    $(".form-group").fadeIn()
                }
            })

            $("#guardar_experiencias").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: $("#fr_experiencias").serialize(),
                    url: "{{route('guardar_experiencia')}}",
                    success: function (response) {
                        var campos = response.rs;
                        if(campos){
                            var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                            tr.append($("<td></td>", {text: campos.nombre_empresa}));
                            @if(route('home') != "https://gpc.t3rsc.co")
                             tr.append($("<td></td>", {text: campos.telefono_temporal}));
                            @endif

                            @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" &&
                                route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                                tr.append($("<td></td>", {text: campos.nombres_jefe}));
                               @if(route('home') != "https://gpc.t3rsc.co")
                                tr.append($("<td></td>", {text: campos.movil_jefe}));
                                tr.append($("<td></td>", {text: campos.fijo_jefe}));
                               @endif
                                tr.append($("<td></td>", {text: campos.cargo_jefe}));
                            @endif

                            tr.append($("<td></td>", {text: campos.fecha_inicio}));

                            if(campos.empleo_actual == 1) {
                              tr.append($("<td>Empleo actual</td>"));
                            }else{
                              tr.append($("<td></td>", {text: campos.fecha_final}));
                            }

                            tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button class="btn btn-info btn-peq certificados" type="button" title="Certificados"><i class="fa fa-file-text-o"></i></button><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i></button>'}));

                            $("#tbl_experiencias tbody").append(tr);
                            $("#registro_nulo").remove();

                            $('.ocultar').hide();
                            $('.ocultar').show();
                            
                            //Busca todos los input y lo pone a su color original
                            $("#mensaje-error").hide();
                            
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});
                                $("textarea").css({"border": "1px solid #ccc"});
                                $(".text").remove();
                            });

                            //Limpiar campos del formulario
                            $("#fr_experiencias")[0].reset();
                            $("#tiene_experiencia").prop('checked', false);
                        
                            //mensaje_success("Se guardaron sus datos satisfactoriamente.");
                            //swal("Datos Guardados", " Desea Continuar O quieres continuar modificando tus DATOS BASICOS?", "info");
                            swal("Experiencia Guardada", " ¿Desea agregar una nueva experiencia?", "info", {
                               buttons: {
                                cancelar: { text: "Agregar Nueva Experiencia",className:'btn btn-success'},
                                agregar: {text: "Siguiente Sección",className:'btn btn-warning'},
                               },
                            }).then((value) => {
                                switch (value) {
                                  case "cancelar":
                                  break;
                                  case "agregar":
                                   window.location.href = '{{route('estudios').'#fr_estudios'}}';
                                     //AQUI CODIGO DONDE AGREGAS
                                  break;
                                }
                            });

                        }else{

                            mensaje_success("Se ha guardado sin experiencia.");
                            window.location.href = '{{route('estudios').'#fr_estudios'}}';
                        }
                    },
                    error:function(data){ 
                        $(document).ready(function(){
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            $("textarea").css({"border": "1px solid #ccc"});
                            $(".text").remove();
                        });

                        $.each(data.responseJSON.errors, function(index, val){

                            $('input[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                            $('textarea[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                            $('select[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                            document.getElementById(index).style.border = 'solid red';
                        });

                        $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                        
                        $("#mensaje-error").fadeIn();
                    }
                });
            });
            
            @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
            
                var confDatepicker = {closeText: 'Seleccionar',
                    startView: "months", 
                    minViewMode: "months",
                    prevText: '<Ant',
                    nextText: 'Sig>',
                    currentText: 'Hoy',
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'mm-yy',
                    altFormat: "yy-mm-dd",
                    yearRange: "1930:2019",
                    onClose: function(dateText, inst) { 
                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                    }
                }
            @else
                var confDatepicker = {
                    altFormat: "yy-mm-dd",
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    //buttonImageOnly: true,
                    autoSize: true,
                    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    maxDate: '+0d',
                    yearRange: "1930:2050"
                };
            @endif
           
           @if(route("home") != "https://gpc.t3rsc.co")
            $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);
           @endif
            /* auto complete cargo desempeñado */
            $('#cargo_desempenado_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cargo_desempenado").val(suggestion.id);
                }
            });

            /* fin auto complete cargo desempeñado */
            $(document).on("click", "input[name=id]", function () {
                $("#tbl_experiencias tbody tr").removeClass("oferta_aplicada");
                if ($(this).prop("checked")) {
                    $(this).parents("tr").addClass("oferta_aplicada");
                }
            });

            $('#ciudad_autocomplete').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad").show();
                $("#select_expedicion_id").val("no");            
            });
            
            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion){
                    $("#error_ciudad").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            //Editar Experiencia
            $(document).on("click",".editar_experiencia", function() {
                //Mostar Botones Cancelar Guardar.
                document.getElementById('cancelar_experiencia').style.display = 'block';
                document.getElementById('actualizar_experiencia').style.display = 'block';
                
                //Ocultar Boton Guardar
                document.getElementById('guardar_experiencias').style.display = 'none';
                
                //Desactivar botones Editar + Eliminar
                $(".disabled_experiencia").prop("disabled", true);
                $("#no_tengo").hide();

                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('editar_experiencia')}}",
                        success: function (response) {
                            if(response.data.id){
                                if(response.data.empleo_actual === 1){
                                    $('.ocultar').hide();
                                }

                                $("#nombre_empresa").val(response.data.nombre_empresa);
                                $("#telefono_temporal").val(response.data.telefono_temporal);
                                $("#cargo_desempenado").val(response.data.cargo_desempenado);
                                $("#cargo_especifico").val(response.data.cargo_especifico);
                                
                                @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" )
                                    $("#nombres_jefe").val(response.data.nombres_jefe);
                                    $("#cargo_jefe").val(response.data.cargo_jefe);
                                    $("#movil_jefe").val(response.data.movil_jefe);
                                    $("#fijo_jefe").val(response.data.fijo_jefe);
                                    $("#ext_jefe").val(response.data.ext_jefe);
                                @endif

                                $("#fecha_final").val(response.data.fecha_final);
                                
                                if (response.data.empleo_actual == 1) {
                                    $("#fecha_inicio").val(response.data.fecha_inicio);
                                }else{

                                }

                                $("#salario_devengado").val(response.data.salario_devengado);
                                $("#motivo_retiro").val(response.data.motivo_retiro);
                                $("#funciones_logros").val(response.data.funciones_logros);
                                $(".id_modificar_experiencia").val(response.data.id);

                                @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                                    $("#linea_negocio").val(response.data.linea_negocio);
                                    $("#tipo_compania").val(response.data.tipo_compania);
                                    $("#ventas_empresa").val(response.data.ventas_empresa);
                                    $("#num_colaboradores").val(response.data.num_colaboradores);
                                    $("#otro_cargo").val(response.data.otro_cargo);
                                    $("#logros").val(response.data.logros);

                                    if(response.data.empleo_actual == 1){
                                        $("#sueldo_fijo_bruto").val(response.data.sueldo_fijo_bruto);
                                        $("#ingreso_varial_mensual").val(response.data.ingreso_varial_mensual);
                                        $("#otros_bonos").val(response.data.otros_bonos);
                                        $("#total_ingreso_anual").val(response.data.total_ingreso_anual);
                                        $("#total_ingreso_mensual").val(response.data.total_ingreso_mensual);
                                        $("#utilidades").val(response.data.utilidades);
                                        $("#valor_actual_fondos").val(response.data.valor_actual_fondos);
                                        $("#beneficios_monetario").val(response.data.beneficios_monetario);

                                        $('#actual_show').show();
                                    }

                                    if (response.data.cargo_desempenado == 39) {
                                        $('#cargoOtro').show();
                                        $("#cargo_otro").val(response.data.cargo_otro);
                                    }
                                @endif

                                if(response.data.empleo_actual == 1){
                                    //$("#empleo_actual").prop("checked", true)
                                    //$("#empleo_actual select").val("1");
                                    $("#empleo_actual > option[value=1]").attr("selected", true)
                                }else{
                                    //$("#empleo_actual").prop("checked", false);
                                    //$("#empleo_actual select").val("2");
                                    $("#empleo_actual > option[value=2]").attr("selected", true)
                                }

                                //Ciudad-Residencia
                                $("#ciudad_autocomplete").val(response.ciudad);
                                $("#pais_id").val(response.data.pais_id);
                                $("#departamento_id").val(response.data.departamento_id);
                                $("#ciudad_id").val(response.data.ciudad_id);

                                //Cargo Desepeño
                                $("#cargo_desempenado_autocomplete").val(response.cargo);
                                
                                $("#no_tengo").show();
                            }
                        }
                    });
                }else{
                   $("#no_tengo").show();
                   mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });

            //Eliminar Experiencia
            $(document).on("click",".eliminar_experiencia", function() {
                var objButton = $(this);
                id = objButton.parent().find("input").val();
                if (id) {
                    if (confirm("Desea eliminar este registro?")){
                        $(".disabled_experiencia").prop("disabled", true);
                        $.ajax({
                            type: "POST",
                            data: {"id":id},
                            url: "{{route('eliminar_experiencia')}}",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                $(".disabled_experiencia").prop("disabled", false);
                                mensaje_success("Registro eliminado.");
                            }
                        });
                    }
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });

            //Cancelar Evento a realizar
            $("#cancelar_experiencia").on("click", function () {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_experiencia').style.display = 'none';
                document.getElementById('actualizar_experiencia').style.display = 'none';
                //MOstrar Boton Guardar
                document.getElementById('guardar_experiencias').style.display = 'block';
                //Activar botones Editar + Eliminar
                $(".disabled_experiencia").prop("disabled", false);

                var objButton = $(this);
                    id = objButton.parents("form").find(".id_modificar_experiencia").val();
                    if(id) {
                        $("#fr_experiencias")[0].reset();
                    }else{
                        mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
                    }
                });
            });

            //Actualizar Experiencia
            $(document).on("click","#actualizar_experiencia", function() {
                $("#actualizar_experiencia").prop('disabled','disabled');

                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_experiencia").val();
                if (id) {
                	$.ajax({
                        type: "POST",
                        data: $("#fr_experiencias").serialize(),
                        url: "{{route('actualizar_experiencia')}}",
                        success: function (response) {
                            $("#actualizar_experiencia").prop('disabled',false);

                            $("#fr_experiencias")[0].reset();
                            $(".disabled_experiencia").prop("disabled", false);
                            mensaje_success("Registro actualizado.");

                            var campos = response.rs;
                            $("#tr_" + campos.id).html(tr);
                            var tr = $("#tr_" + campos.id + "").find("td");
                            tr.eq(0).html(campos.nombre_empresa);
                            tr.eq(1).html(campos.telefono_temporal);

                            @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" )
                                tr.eq(2).html(campos.nombres_jefe);
                                tr.eq(3).html(campos.movil_jefe);
                                tr.eq(4).html(campos.fijo_jefe);
                                tr.eq(5).html(campos.cargo_jefe);
                            @endif

                            tr.eq(6).html(campos.fecha_inicio);
                            if (campos.empleo_actual == 1) {
                                tr.eq(7).html('Empleo actual');
                            }else{
                                tr.eq(7).html(campos.fecha_final);
                            }
                            tr.eq(8).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i></button>'}));

                            $("#mensaje-error").hide();
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});

                            //Ocultar Botones Cancelar Guardar.
                            document.getElementById('cancelar_experiencia').style.display = 'none';
                            document.getElementById('actualizar_experiencia').style.display = 'none';
                            //MOstrar Boton Guardar
                            document.getElementById('guardar_experiencias').style.display = 'block';
                        },
                        error:function(data){
                            $("#actualizar_experiencia").prop('disabled',false);
                            
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});
                                $("textarea").css({"border": "1px solid #ccc"});
                                $(".text").remove();
                            });

                            $.each(data.responseJSON.errors, function(index, val){
                              $('input[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                              $('textarea[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                              $('select[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                               document.getElementById(index).style.border = 'solid red';
                           });

                            $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                          $("#mensaje-error").fadeIn();
                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                    $(".disabled_experiencia").prop("disabled", false);
                }
            });

            $(".certificados").on("click", function () {
                var objButton = $(this);
                id = objButton.parent().find("input").val();

                if(id) {
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{ route('certificados_experiencias') }}",
                        success: function (response) {
                            $("#modal2").find(".modal-content").html(response);
                            $("#modal2").modal("show");
                        }
                    });
                }else{
                    mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
                }
            });
    </script>
@stop