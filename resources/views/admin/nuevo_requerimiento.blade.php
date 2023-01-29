@extends("admin.layout.master")
@section("contenedor")
    <style>
        #multiciudad_collapse{
            display: none;
        }

        .well-verde{
            background-color: #66c5556b !important;
        }

        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            overflow: auto;
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

        .input-group-bt4 select {
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
    </style>

    @if(session()->has('errors'))
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(["route" => "admin.guardar_requerimiento", "files" => true, "id" => "frm_crearReq"]) !!}
        {!!Form::hidden("negocio_id",$negocio->id) !!}
        {!!Form::hidden("cliente_id", $cliente->id, ["id" => "cliente_id"]) !!}
        
        @if (route('home') == 'https://gpc.t3rsc.co')
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">NUEVO REQUERIMIENTO</h3>
                        </div>
                        
                        <h4 class="box-header with-border">INFORMACIÓN GENERAL DE LA SOLICITUD</h4>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Tipo de Solicitud <span>*</span></label>

                                <div class="col-sm-8">
                                 {!! Form::select("tipo_proceso_id",$tipoProceso, null, ["class"=>"form-control", "id" => "tipo_proceso_id", "required" => "required"]); !!}
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Lugar de Trabajo <span>*</span></label>
                                <span style="color:red;display: none;" id="error_ciudad_expedicion">Debe seleccionar de la lista</span>

                                <div class="col-sm-8">
                                    {!! Form::hidden("pais_id", null, ["class" => "form-control", "id" => "pais_id"]) !!}
                                    {!! Form::hidden("departamento_id", null, ["class" => "form-control", "id" => "departamento_id"]) !!}
                                    {!! Form::text("ciudad_id", null, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_id", "required" => "required"]) !!}

                                    {!! Form::text("sitio_trabajo", null, ["placeholder" => "Seleccionar una opción de la lista desplegable", "class" => "form-control", "id" => "sitio_trabajo_autocomplete", "required" => "required"]); !!}
                                </div>
                            </div>
                        </div>

                        {!!Form::hidden("solicitado_por", $user->id, ["id" => "solicitado_por"]); !!}

                        {{-- No aparece en Tiempos --}}
                        <h4 class="box-header with-border">PERSONALIZACIÓN DE LA SOLICITUD</h4>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="solicitado_por_txt" class="col-sm-4 control-label">Nombre Solicitante <span>*</span></label>
                                
                                <div class="col-sm-8">
                                   {!! Form::text("solicitado_por_txt", strtoupper($user->name), [
                                        "class" => "form-control",
                                        "placeholder" => "Solicitante",
                                        "id" => "solicitado_por_txt",
                                        "required"  =>  "required"
                                    ]);!!}
                                </div>
                            </div>
                        </div>
                                        
                        <h4 class="box-header with-border">ESPECIFICACIONES DEL REQUERIMIENTO</h4>
                        
                        <div class="row">
                            {{-- Cargo cliente --}}
                            @if ($user_sesion->hasAccess('admin.cargos_especificos.nuevo'))
                                <div class="col-md-6"> 
                                    <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                    <div class="col-sm-8 input-group-bt4">
                                        {!! Form::select("cargo_especifico_id", $cargo_especifico, null,[
                                            "class" => "form-control",
                                            "id" => "cargo_especifico_id",
                                            "required" => "required"
                                        ]); !!}
                                        <span class="input-group-append">
                                            <button class="btn btn-primary" type="button" title="Crear nuevo cargo del cliente" onclick="crearCargo();"><i class="fa fa-plus"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 form-group">
                                    <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                    <div class="col-sm-8">
                                    {!! Form::select("cargo_especifico_id",$cargo_especifico,null,["class" => "form-control", "id" => "cargo_especifico_id", "required" => "required"]); !!}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="col-md-6 form-group">
                              <label for="inputEmail3" class="col-sm-4 control-label">
                               {{(route("home") == "https://soluciones.t3rsc.co") ? 'Requisicion de Servicio' : 'Archivo PDF cargo'}} <span></span>
                              </label>

                              <div class="col-sm-8">
                                {!! Form::file("perfil", ["class" => "form-control-file", "id" => "perfil", "name" => "perfil"]) !!}
                              </div>
                                <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("perfil", $errors) !!} </p>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"> </label>

                                <div class="col-sm-8">
                                  {!! Form::hidden("cargo_generico_id",'',["id"=>"cargo_generico_id"]); !!}
                                </div>
                            </div>
                        </div>

                        @if( session()->has('return_from_post_req') )
                          <div class="container"> {!!session()->get('partial_html')!!} </div>
                        @else
                            <div class="here-put-fields-from-ajax"></div>
                        @endif

                        
                        <div id="fecha_no" class="row">
                            <div class="col-md-6 form-group">
                              <label for="inputEmail3" class="col-sm-4 control-label">Fecha de ingreso <span>*</span></label>

                                <div class="col-sm-8">
                                  <input type="text" name="fecha_ingreso" class="form-control" id="fecha_ingreso" value="{{$fecha_tentativa}}" required="required" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">NUEVO REQUERIMIENTO</h3>
                        </div>
                        
                        <h4 class="box-header with-border">INFORMACIÓN GENERAL DE LA SOLICITUD</h4>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Tipo de Solicitud <span>*</span></label>

                                <div class="col-sm-8">
                                    {!! Form::select("tipo_proceso_id",$tipoProceso, null, ["class"=>"form-control", "id" => "tipo_proceso_id", "required" => "required"]); !!}
                                </div>
                            </div>

                           

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Empresa Contrata <span>*</span></label>
                                 <div class="col-sm-8">
                                  {!! Form::select("empresa_contrata",$empresa_logo,null,["class"=>"form-control", "id" => "empresa_contrata"]); !!}
                                 </div>
                              </div>
                           

                            <div class="col-md-6 form-group">
                             <label for="inputEmail3" class="col-sm-4 control-label">Ciudad Trabajo <span>*</span></label>
                              <span style="color:red;display: none;" id="error_ciudad_expedicion">Debe seleccionar de la lista</span>

                                <div class="col-sm-8">
                                  {!! Form::hidden("pais_id", null, ["class" => "form-control", "id" => "pais_id"]) !!}
                                  {!! Form::hidden("departamento_id", null, ["class" => "form-control", "id" => "departamento_id"]) !!}
                                  {!! Form::text("ciudad_id", null, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_id", "required" => "required"]) !!}
                                  {!! Form::text("sitio_trabajo", null, ["placeholder" => "Seleccionar una opción de la lista desplegable", "class" => "form-control", "id" => "sitio_trabajo_autocomplete", "required" => "required"]); !!}
                                </div>
                            </div>
                            @if($sitioModulo->visita_domiciliaria == 'enabled')
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Visita domiciliaria? <span>*</span></label>

                                    <div class="col-sm-8">
                                        {!! Form::select("tipo_visita_id",$tipos_visitas,null,["class"=>"form-control", "id" => "tipo_visita_id"]); !!}
                                    </div>
                                </div>
                             @endif

                            @if(route("home") == "http://komatsu.t3rsc.co")
                                @if($user->hasAccess("lista_psicologos"))
                                 <div class="col-md-6 form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Psicólogos <span>*</span></label>

                                   <div class="col-sm-8">
                                    {!! Form::select("psicologo_id", $psicologos, null, ["class" => "form-control", "id" => "psicologo_id", "required" => "required"]); !!}
                                   </div>
                                 </div>
                                @endif 
                            @endif

                            @if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" || route("home") == "http://localhost:8000")

                                <div class="col-md-6 form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Jefe Inmediato </label>

                                  <div class="col-sm-8">
                                   {!! Form::text("jefe_inmediato", strtoupper($user->name), ["class" => "form-control", "placeholder" => "jefe inmediato", "id" => "jefe_inmediato"]); !!}
                                  </div>  
                                  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("jefe_inmediato", $errors) !!}</p>
                                </div>
                            @endif
                        </div>

                        {!!Form::hidden("solicitado_por", $user->id, ["id" => "solicitado_por"]); !!}
                        {{-- No aparece en Tiempos --}}
                        <h4 class="box-header with-border">PERSONALIZACIÓN DE LA SOLICITUD</h4>

                        <div class="row">
                          <div class="col-md-6 form-group">
                            <label for="solicitado_por_txt" class="col-sm-4 control-label">Nombre Solicitante <span>*</span></label>    
                              <div class="col-sm-8">
                               {!! Form::text("solicitado_por_txt", strtoupper($user->name), [ "class" => "form-control","placeholder" => "Solicitante", "id" => "solicitado_por_txt", "required"  =>  "required" ]);!!}
                              </div>
                            </div>

                            <div class="col-md-6 form-group">
                              <label for="inputEmail3" class="col-sm-4 control-label"> Confidencial </label>
                              <div class="col-sm-8">
                               {!! Form::select("confidencial",['0'=>"No",'1'=>"Si"], null,[ "class" => "form-control", "id" => "confidencial"]);!!}
                              </div>
                            </div>

                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="col-md-6 form-group">
                                  <label for="num_req_cliente" class="col-sm-4 control-label">Num. Requi Cliente <span></span></label>
                                    
                                    <div class="col-sm-8">
                                     {!! Form::text("num_req_cliente", '',["class" => "form-control", "placeholder" => "# Requi Cliente"]); !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">
                                        Teléfono @if(route("home") == "http://tiempos.t3rsc.co") <span>*</span> @endif
                                    </label>

                                    <div class="col-sm-8">
                                        {!!Form::text("telefono_solicitante", $user->telefono, ["class" => "form-control solo-numero", "placeholder" => "Teléfono Solicitante"]);!!}
                                    </div>
                                </div>
                            @endif

                            {{-- Solo en VYM --}}
                            @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co" || route("home")=="https://pruebaslistos.t3rsc.co" || route('home') == "http://localhost:8000" || route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co" || route('home') == "https://test.desarrollo.t3rsc.co")

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Centro de Costos <span>*</span></label>
                                    
                                    <div class="col-sm-8">
                                     {!! Form::select("centro_costo_id",$centro_costo,null,["class"=>"form-control","id"=>"centro_costo_id", "required" => "required"]); !!}
                                    </div>
                                </div>

                                @if( (route('home') == "http://localhost:8000" || route('home') == "https://listos.t3rsc.co") && $cliente->id == 168)
                                    <div class="col-md-6 form-group">
                                      <label for="inputEmail3" class="col-sm-4 control-label">Centro Costos Cliente <span>*</span></label>
                                        <div class="col-sm-8">
                                         {!! Form::text("centro_costo_cliente",null,["class" => "form-control", "placeholder" => "Centro Costo Cliente"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                      <label for="inputEmail3" class="col-sm-4 control-label">Unidad de Negocios <span>*</span></label>
                                       <div class="col-sm-8">
                                        {!! Form::text("unidad_negocio",null,["class" => "form-control", "placeholder" => "Unidad de Negocios"]) !!}
                                       </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Turno<span>*</span></label>
                                        <div class="col-sm-8">
                                            {!! Form::text("tipo_turno",null,["class" => "form-control", "placeholder" => "Tipo Turno"]) !!}
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                                        
                        <h4 class="box-header with-border">  ESPECIFICACIONES DEL REQUERIMIENTO</h4>
                        <div class="row">
                            @if ($user_sesion->hasAccess('admin.cargos_especificos.nuevo'))
                                <div class="col-md-6"> 
                                    <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                    <div class="col-sm-8 input-group-bt4">
                                        {!! Form::select("cargo_especifico_id", $cargo_especifico, null,[
                                            "class" => "form-control",
                                            "id" => "cargo_especifico_id",
                                            "required" => "required"
                                        ]); !!}
                                        <span class="input-group-append">
                                            <button class="btn btn-primary" type="button" title="Crear nuevo cargo del cliente" onclick="crearCargo();"><i class="fa fa-plus"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 form-group">
                                    <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                    <div class="col-sm-8">
                                    {!! Form::select("cargo_especifico_id",$cargo_especifico,null,["class" => "form-control", "id" => "cargo_especifico_id", "required" => "required"]); !!}
                                    </div>
                                </div>
                            @endif
                            
                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">
                                        {{(route("home") == "https://soluciones.t3rsc.co")?'Requisicion de Servicio' : 'Adjunto solicitud'}}<span></span>
                                    </label>

                                    <div class="col-sm-8">
                                      {!! Form::file("perfil", ["class" => "form-control-file", "id" => "perfil", "name" => "perfil"]) !!}
                                    </div>
                                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("perfil", $errors) !!} </p>
                                </div>
                            @endif

                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"> </label>

                                <div class="col-sm-8">
                                    {!! Form::hidden("cargo_generico_id",'',["id"=>"cargo_generico_id"]); !!}
                                </div>
                            </div>
                        </div>

                        @if( session()->has('return_from_post_req') )
                            <div class="container">
                                {!! session()->get('partial_html') !!}
                            </div>
                        @else
                            <div class="here-put-fields-from-ajax"></div>
                        @endif

                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Limite Envio Candidatos <span>*</span></label>
                                    
                                    <div class="col-sm-8">
                                        {!! Form::text("fecha_presentacion_candidatos", null, [
                                            "class" => "form-control",
                                            "placeholder" => "AAAA-MM-DD",
                                            "id" => "fecha_presentacion_candidatos",
                                            "readonly" => true]); !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(route('home') == "http://temporizar.t3rsc.co")
                            <div id="fecha_no">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Tentativa de ingreso <span>*</span></label>
                                    
                                    <div class="col-sm-8">
                                        {!! Form::text("fecha_ingreso", "$fecha_tentativa", [
                                            "class" => "form-control",
                                            "placeholder" => "AAAA-MM-DD",
                                            "id" => "fecha_ingreso",
                                            "required" => "required"]); !!}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                 <label for="inputEmail3" class="col-sm-4 control-label">Fecha Retiro <span>*</span></label>
                                    <div class="col-sm-8">
                                      {!! Form::text("fecha_retiro","$fecha_r_tentativa",["class" => "form-control", "placeholder" => "AAAA-MM-DD", "id" => "fecha_retiro", "required" => "required"]); !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div id="fecha_no" class="row">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">
                                        @if(route("home") == "http://localhost:8000" || route("home") == "https://vym.t3rsc.co")
                                            Fecha contrato
                                        @else
                                            Fecha Tentativa de ingreso 
                                        @endif
                                        <span>*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="text" name="fecha_ingreso" class="form-control" id="fecha_ingreso" value="{{$fecha_tentativa}}" required="required" >
                                    </div>
                                </div>

                                @if(route("home") != "https://gpc.t3rsc.co")
                                    <div class="col-md-6 form-group">
                                     <label for="inputEmail3" class="col-sm-4 control-label">Fecha Retiro<span>*</span></label>
                                      <div class="col-sm-8">
                                       {!! Form::text("fecha_retiro", "$fecha_r_tentativa", ["class" => "form-control", "placeholder" => "AAAA-MM-DD", "id" => "fecha_retiro", "required" => "required"]); !!}
                                      </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="row">
                            @if(route("home") == "https://gpc.t3rsc.co")
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <h4 class="box-header with-border"> Misión del Cargo </h4>
                                    </div>
                                    
                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Misión del Cargo <span></span> </label>

                                        <div class="col-sm-12">
                                            {!!Form::textarea("mision_cargo",null,["class"=>"form-control","id"=>"mision_cargo"]);!!}
                                        </div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <h4 class="box-header with-border"> Funciones esenciales del cargo y Conocimientos requeridos </h4>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"> ¿Cuáles son las funciones más importantes de este cargo? <span></span></label>
                                        <div class="col-sm-12">
                                            {!!Form::textarea("funciones_cargo",null,["class"=>"form-control","id"=>"funciones_cargo"]);!!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <h4 class="box-header with-border"> Resultados / Contribuciones del Cargo </h4>
                                    </div>
                                    
                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"> ¿Cuáles son los indicadores o resultados que se consideran para la evaluación del desempeño del puesto: <span></span> </label>
                                        
                                        <div class="col-sm-12">
                                            {!!Form::textarea("indicadores_desempeno",null,["class"=>"form-control","id"=>"indicadores_desempeno"]);!!}
                                        </div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Experiencia Requerida <span></span></label>

                                        <div class="col-sm-12">
                                            {!!Form::textarea("experiencia_requerida",null,["class"=>"form-control","id"=>"experiencia_requerida"]);!!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <h4 class="box-header with-border"> Retos/ Dificultades del Puesto </h4>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"> ¿Cuáles son los Desafíos que posiblemente encontrará el ocupante del cargo en la ejecución de las tareas esenciales y que pueden afectar su desempeño?: <span></span> </label>
                                        
                                        <div class="col-sm-12">
                                            {!!Form::textarea("retos",null,["class"=>"form-control","id"=>"retos"]);!!}
                                        </div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label"> Perfil Profesional y Factores Claves del Perfil: <span></span></label>
                           
                                        <div class="col-sm-12">
                                            {!!Form::textarea("claves_perfil",null,["class"=>"form-control","id"=>"claves_perfil"]);!!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <h4 class="box-header with-border"></h4>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Estrategia de Búsqueda: <span></span> </label>
                                        
                                        <div class="col-sm-12">
                                            {!!Form::textarea("estrategia_busqueda",null,["class"=>"form-control","id"=>"estrategia_busqueda"]);!!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(route("home") != "https://gpc.t3rsc.co" || route("home") != "https://vym.t3rsc.co")
                                <div class="col-md-12 form-group">
                                    <h4 class="box-header with-border"> SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h4>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Recepción Solicitud <span>*</span> </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("fecha_recepcion",$fecha_hoy,["class"=>"form-control","id"=>"fecha_recepcion"]); !!}
                                    </div>
                                </div>
                            @endif

                            @if(route("home") != "https://gpc.t3rsc.co" || route("home") != "https://vym.t3rsc.co")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Contenido Email Soporte <span>*</span></label>
                                    <div class="col-sm-8">
                                        {!!Form::textarea("contenido_email_soporte", "$contenido_email_soporte", [
                                            "class" => "form-control",
                                            "id" => "contenido_email_soporte",
                                            "required" => "required"
                                        ]);!!}
                                    </div>
                                </div>
                            @endif

                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">¿Requerimiento Multiciudad?</label>

                                        <div class="col-sm-8">
                                            <select name="select_multi_reque" id="select_multi_reque" class="form-control" required="required">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            @endif
                        </div>
                  
                        @if(route("home") != "https://gpc.t3rsc.co")
                            <div id="contratacion-directa" class="row well well-verde">
                                <h4 class="with-border"> DATOS PARA CONTRATACION</h4>
     
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>
                                    @if(Route('home') == 'https://vym.t3rsc.co')
                                        <div class="col-sm-8">
                                            <input type="date" name="fecha_ingreso_contra" value="" class="form-control fechas_ingresos" id="fecha_ingreso_contra">
                                        </div>
                                    @else
                                        <div class="col-sm-8">
                                            <input type="date" name="fecha_inicio_contratos" value="" class="form-control fechas_ingresos" id="fecha_inicio_contratos">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Hora Ingreso</label>

                                    <div class="col-sm-8">
                                        <input type="time" name="hora_ingreso" class="form-control" id="hora_ingreso">
                                    </div>
                                </div>
                        
                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3">
                                            Tipo Ingreso *
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="tipo_ingreso" name="tipo_ingreso">
                                            <option selected="">Seleccionar</option>
                                            <option value="1">Nuevo</option>
                                            <option value="2">Reingreso</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>

                                    <div class="col-sm-8">
                                        <textarea name="observacionesContra" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">
                                            Auxilio de Transporte *
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="auxilio_transporte" class="form-control">
                                            <option selected="">Seleccionar</option>
                                            <option value="No se Paga">No se paga</option>
                                            <option value="Total">Total</option>
                                            <option value="Mitad">Mitad</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3">
                                        ARL *
                                    </label>
                                    <div class="col-sm-8">
                                        {!!Form::text("arl","Colpatria",["class"=>"form-control","id"=>"arl","readonly"=>"readonly"])!!}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3">
                                        Fecha Fin Contrato *
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::date("fecha_fin_contrato",null,["class"=>"form-control","id"=>"fecha_fin_contrato"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif

        {{-- Multiciudad --}}
        <div class="box box-info" id="multiciudad_collapse">
            <div class="box-header with-border">
                <h4 class="box-header with-border">CAMPOS MULTICIUDAD</h4>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <div class="container" id="multiciudad_req">
                        <div class="row" style="border-bottom: solid 1px #bfbfbf; padding-top: 1.4rem;">
                            <div class="col-md-3 form-group">
                                <div class="col-md-12">
                                    <label>Ciudad Trabajo *</label> <br>
                                    {!! Form::select('ciudad_trabajo_multi[]', $ciudadesSelect, null, ['id'=>'ciudad_trabajo_multi','class'=>'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <div class="col-sm-12">
                                    <label>Salario *</label>

                                    <input type="number" class="form-control" placeholder="SALARIO" name="salario_multi[]" id="salario_multi" required="required">
                                </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <div class="col-sm-12">
                                    <label>Número Vacantes *</label>

                                    <input type="number" class="form-control" placeholder="VACANTES" name="num_vacantes_multi[]" id="num_vacantes_multi" required="required">
                                </div>
                            </div>

                            <div class="col-md-2 form-group last-child">
                                <button type="button" class="btn btn-success add-reque">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONFIGURAR DOCUMENTOS ADICIONALES --}}
        <div id="adicionalesBox">
            {{-- @include('admin.requerimientos.includes._section_configurar_adicionales') --}}
        </div>

        {{-- Postular candidatos --}}
        <div id="formPostularCandidatos" class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h4 class="box-header with-border">POSTULAR CANDIDATOS(opcional)</h4>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" type="button"> <i class="fa fa-plus"></i> </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <div class="container" id="postulados">
                        <div class="row">

                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    <label>Cédula *</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form_cam can_cedula solo-numero" placeholder="Cédula" name="can_cedula[]">
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    <label>Nombres *</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form_cam can_nombres postular-cand" placeholder="Nombres" name="can_nombres[]" readonly="true">
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    <label>Apellidos *</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form_cam can_apellido postular-cand" placeholder="Apellidos" name="can_apellido[]" readonly="true">
                                </div>
                            </div>
                            
                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    <label>Móvil *</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form_cam can_movil solo-numero postular-cand" placeholder="Móvil" name="can_movil[]" readonly="true">
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    <label>Correo electrónico *</label>
                                </div>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control form_cam can_email email postular-cand" placeholder="email@dominio.com" name="can_email[]" readonly="true">
                                </div>
                            </div>

                            <div class="col-md-2 form-group last-child">
                                <button type="button" class="btn btn-success add-person" title="Agregar">+</button>
                            </div>
                            <div class="col-md-12">
                               <hr/ style="border: 1px solid blue;">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br/>
      
        {!!FuncionesGlobales::valida_boton_req("req.guardar_requerimiento", "Enviar Requerimiento", "boton", "btn btn-success", "", "enviar_requerimiento_btn")!!}
    {!! Form::close() !!}

    <br/>

    <script>
        $("#postulados").delegate('.can_cedula', 'blur', function() {
            var cedula=$(this).val();
            var _this = this;

            if (cedula == '') {
                $(_this).parents('.row').find('.postular-cand').attr('readonly', true)

                $(_this).parents('.row').find('.postular-cand').val('')

                return false;
            }

            $.ajax({
                url: `{{route('ajaxBuscarCandidatoPorCedula')}}`,
                type: 'POST',
                data: {cedula: cedula}
            }).done(function (response) {
                if (response.find) {

                    if (response.se_puede_postular) {
                        $(_this).parents('.row').find('.postular-cand').attr('readonly', false)

                        $(_this).parents('.row').find('.can_nombres').val(response.candidato.nombres)

                        if (response.candidato.segundo_apellido != null && response.candidato.segundo_apellido != '') {
                            $(_this).parents('.row').find('.can_apellido').val(`${response.candidato.primer_apellido} ${response.candidato.segundo_apellido}`)
                        } else {
                            $(_this).parents('.row').find('.can_apellido').val(response.candidato.primer_apellido)
                        }

                        $(_this).parents('.row').find('.can_movil').val(response.candidato.telefono_movil)

                        $(_this).parents('.row').find('.can_email').val(response.candidato.email)
                    } else {
                        $(_this).parents('.row').find('.postular-cand').attr('readonly', true)

                        $(_this).parents('.row').find('.postular-cand').val('')

                        mensaje_danger("El candidato con el número de documento " + cedula +" no se puede postular porque está asociado en otro requerimiento o se encuentra inactivo.")
                    }
                } else {
                    $(_this).parents('.row').find('.postular-cand').attr('readonly', false)

                    $(_this).parents('.row').find('.can_nombres').val('')

                    $(_this).parents('.row').find('.can_apellido').val('')

                    $(_this).parents('.row').find('.can_movil').val('')

                    $(_this).parents('.row').find('.can_email').val('')
                }
            }).error(function(error){
                console.log("error:",error)
            });
        });

        function crearCargo() {
            var cliente_id = $('#cliente_id').val()

            $.ajax({
                data: {
                    cliente_id: cliente_id
                },
                url: "{{ route('admin.crear_cargo_cliente') }}",
                beforeSend: function(){
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
                },
                success: function(response) {
                    $.unblockUI();
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal({ backdrop: 'static', keyboard: false });
                }
            });
        }

        function validarEmail(object) {
            if (/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(object.val())) {
                //alert("La dirección de email " + valor + " es correcta.");
                object.css("background-color", "white");
            } else {
                object.css("background-color", "#fbc2b0");
                alert("La dirección de email '"+object.val()+"' es incorrecta.");
            }
        }

        $(function () {
            $('.email').change(function(){
                validarEmail($(this));
            });

            $('#contratacion-directa').hide();

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca una ciudad'
            });

            $('div.alert').delay(5000).fadeOut('slow');
            
            $(document).on('click', '.add-person', function (e) {
                fila_person = $(this).parents('#postulados').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person">-</button>');

                $('#postulados').append(fila_person);
            });

            $(document).on('click', '.rem-person', function (e) {
                $(this).parents('.row').remove();
            });

            $(document).on('click', '.add-reque', function (e) {
                fila_person = $(this).parents('#multiciudad_req').find('.row').eq(0).clone();
                fila_person.find('select').val();
                fila_person.find('input').val();
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-reque">-</button>');

                $('#multiciudad_req').append(fila_person);
            });

            $(document).on('click', '.rem-reque', function (e) {
                $(this).parents('.row').remove();
            });

            //Busca ciudad
            $('#sitio_trabajo_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#error_ciudad_expedicion").hide();
                     $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            $('#sitio_trabajo_autocomplete').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad_expedicion").show();
                $("#select_expedicion_id").val("no");
            });

            var calendarOption = {
                minDate: 0,
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                onSelect: function (dateText, obj) {
                    //console.log(dateText);
                }
            };

            var calendarOption2 = {
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            var calendarOption3 = {
                dateFormat: "yy-mm-dd",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            $("#fecha_ingreso").datepicker(calendarOption);

            $("#fecha_retiro").datepicker(calendarOption2);

            $('#fecha_recepcion').datepicker(calendarOption2);

            $('.fechas_ingresos').datepicker(calendarOption2);
            $('#fecha_ingreso_contra').datepicker(calendarOption2);

            /* verificar la relacion con tipo contrato */
            $('#empresa_contrata').on("change", function(e) {

                let id = $(this).val();

                let id_tipo_contrato = $('#tipo_contrato_id').val();
                console.log("id:", id)
                console.log("id tipo de contrato:", id_tipo_contrato)

                if (id != undefined && id_tipo_contrato != undefined) {
                  console.log("hace la peticion a verificar")
                }else{
                  console.log("no pasa nada ")
                }
            });

            $('#tipo_contrato_id').on("change", function(e) {

                let id = $(this).val();

                let empresa_contrata = $('#empresa_contrata').val();
                console.log("id:", id)
                console.log("id tipo de empresa contrata:", empresa_contrata)

                if (id != undefined && empresa_contrata != undefined) {
                  console.log("hace la peticion a verificar")
                }else{
                  console.log("no pasa nada ")
                }
            });
            
            {{-- Carga componente del cargo --}}
            $('#cargo_especifico_id').on("change", function (e) {
                var id = $(this).val();
                var negocio_id = '{{$negocio->id }}';

                id_cliente = $("#cliente_id").val();

                $.ajax({
                    url: "{{ route('req.ajaxgetcargoespecificodependientes') }}",
                    type: 'POST',
                    data: {
                        cargo_especifico_id: id,
                        negocio_id: negocio_id,
                        cliente_id: id_cliente
                    }
                })
                .done(function (response) {
                    $('.here-put-fields-from-ajax').html(response);
                    $(".enviar_requerimiento_btn").prop("disabled","");
                    if($("#tipo_proceso_id").val() == 6){
                        $('.no_contra').hide('slow');
                    }else{
                        $('.no_contra').show('slow');
                    }
                });

                $.ajax({
                    url: "{{ route('listar_clausulas_cargo_post') }}",
                    type: 'POST',
                    data: {
                        cargo_id: id
                    }
                })
                .done(function (response) {
                    $('#adicionalesBox').html(response);
                });
            });
        });

        @if(route("home") != "https://gpc.t3rsc.co")
            $(document).on('change', '#select_multi_reque', function () {
                if($(this).val() == 1){
                    $('#multiciudad_collapse').show('slow');
                }else{
                    $('#multiciudad_collapse').hide('slow');
                }
            });
        @endif

        @if(route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" ||
            route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co" ||
            route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" ||
            route('home') == "http://localhost:8000" || route('home') == "https://vym.t3rsc.co")

            $(document).on('change', '#tipo_proceso_id', function () {
                if($(this).val() == 6 || $("#tipo_proceso_id").val() == 4){
                   //$('#contratacion-directa').show('slow');
                    $('#fecha_no').hide('slow');
                    $('.no_contra').hide('slow');
                    $('#formPostularCandidatos').removeClass('collapsed-box');
                    $('.can_nombres').prop("required", true);
                    $('.can_apellido').prop("required", true);
                    $('.can_cedula').prop("required", true);
                    $('.can_email').prop("required", true);
                    $('#tipo_ingreso').val(2);
                    $('.can_cedula').prop("required", true);
                @if(route("home")=="http://localhost:8000" || route("home")=="https://vym.t3rsc.co")

                    $('.fecha_ultimo_contrato').prop("required", true);
                @endif

                }else{
                    $('#contratacion-directa').hide('slow');
                    $('#contratacion-directa :input').val('');
                    $('#fecha_no').show('slow');
                    $('.no_contra').show('slow');
                    $('#formPostularCandidatos').addClass('collapsed-box');
                    $('.can_nombres').removeAttr("required");
                    $('.can_apellido').removeAttr("required");
                    $('.can_cedula').removeAttr("required");
                    $('.can_email').removeAttr("required");

                     @if(route("home")=="http://localhost:8000" || route("home")=="https://vym.t3rsc.co")

                        $('.fecha_ultimo_contrato').removeAttr("required");

                    @endif
                }
            });
        @endif

        $(document).on('click', '#enviar_requerimiento_btn', function() {
                $(this).prop("disabled",true);
            @if(route('home') == "http://demo.t3rsc.co" 
                || route('home') == "https://demo.t3rsc.co" 
                || route('home') == "http://desarrollo.t3rsc.co" 
                || route('home') == "https://desarrollo.t3rsc.co" 
                || route("home") == "http://temporizar.t3rsc.co" 
                || route("home")=="https://temporizar.t3rsc.co" 
                || route('home') == "http://localhost:8000")

                if($('#tipo_proceso_id').val() == 6){
                    var mal =0;
             
                    $(".form_cam").each(function() {
                        var name = $(this).val();
                        if(name == ""){
                            mal = mal+1;
                            $(this).css('border', 'solid 1px red');
                            $(this).focus();
                        }
                    });

                    if(mal !== 0){
                        mensaje_success('Debes Cargar Candidatos a Contratar');
                        $('.btn-box-tool').click();
                        return false;
                    }
                }
            @endif
            
            if($('#tipo_proceso_id').val() == ''){
                $('#tipo_proceso_id').css('border', 'solid 1px red');
                $('#tipo_proceso_id').focus();

                setTimeout(function(){
                    $('#tipo_proceso_id').css('border', 'solid 1px #d2d6de');
                }, 4000);
            }else if($('#sitio_trabajo_autocomplete').val() == ''){
                $('#sitio_trabajo_autocomplete').css('border', 'solid 1px red');
                $('#sitio_trabajo_autocomplete').focus();

                setTimeout(function(){
                 $('#sitio_trabajo_autocomplete').css('border', 'solid 1px #d2d6de');
                }, 4000);
            
            }else if($('#ciudad_id').val() == ''){

              $('#sitio_trabajo_autocomplete').css('border', 'solid 1px red');
              $('#sitio_trabajo_autocomplete').focus();

              setTimeout(function(){
                $('#sitio_trabajo_autocomplete').css('border', 'solid 1px #d2d6de');
              }, 4000);
            }

            @if(route('home') != "http://tiempos.t3rsc.co" || route('home') != "https://tiempos.t3rsc.co")
                else if($('#solicitado_por_txt').val() == ''){
                    $('#solicitado_por_txt').css('border', 'solid 1px red');
                    $('#solicitado_por_txt').focus();

                    setTimeout(function(){ 
                        $('#solicitado_por_txt').css('border', 'solid 1px #d2d6de');
                    }, 4000);
                }
            @endif

            @if(route('home') == "https://vym.t3rsc.co")
                if($('#enterprise').val() == ''){
                    $('#enterprise').css('border', 'solid 1px red');
                    $('#enterprise').focus();
                }

            @endif

            @if(route('home') == "https://vym.t3rsc.co" 
                || route('home') == "http://vym.t3rsc.co" 
                || route('home') == "https://listos.t3rsc.co" 
                || route('home') == "http://listos.t3rsc.co" 
                || route("home")== "https://pruebaslistos.t3rsc.co" 
                || route('home') == "http://localhost:8000"
                || route('home') == "https://desarrollo.t3rsc.co")

                else if($('#centro_costo_id').val() == ''){
                    $('#centro_costo_id').css('border', 'solid 1px red');
                    $('#centro_costo_id').focus();

                    setTimeout(function(){ 
                        $('#centro_costo_id').css('border', 'solid 1px #d2d6de');
                    }, 4000);
                }
            @endif

            else if($('#cargo_especifico_id').val() == ''){

                $('#cargo_especifico_id').css('border', 'solid 1px red');
                $('#cargo_especifico_id').focus();

                setTimeout(function(){ 
                    $('#cargo_especifico_id').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }
            else if($('#fecha_ingreso').val() == ''){

                $('#fecha_ingreso').css('border', 'solid 1px red');
                $('#fecha_ingreso').focus();

                setTimeout(function(){ 
                    $('#fecha_ingreso').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }
            else if($('#fecha_retiro').val() == ''){

                $('#fecha_retiro').css('border', 'solid 1px red');
                $('#fecha_retiro').focus();

                setTimeout(function(){ 
                    $('#fecha_retiro').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }

            @if(route('home') != "https://gpc.t3rsc.co")

                else if($('#fecha_recepcion').val() == ''){

                    $('#fecha_recepcion').css('border', 'solid 1px red');
                    $('#fecha_recepcion').focus();

                    setTimeout(function(){ 
                        $('#fecha_recepcion').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }

            @endif

            @if(route("home") != "https://gpc.t3rsc.co")
                
                else if($('#contenido_email_soporte').val() == ''){

                    $('#contenido_email_soporte').css('border', 'solid 1px red');
                    $('#contenido_email_soporte').focus();

                    setTimeout(function(){ 
                        $('#contenido_email_soporte').css('border', 'solid 1px #d2d6de');
                    }, 4000);
                
                }
          
            @endif
            
            else if($('#ctra_x_clt_codigo').val() == ''){
                
                $('#ctra_x_clt_codigo').css('border', 'solid 1px red');
                $('#ctra_x_clt_codigo').focus();

                setTimeout(function(){ 
                    $('#ctra_x_clt_codigo').css('border', 'solid 1px #d2d6de');
                }, 4000);

               $("#enviar_requerimiento_btn").removeAttr("disabled");
               
                return false;

            }else if($('#tipo_jornadas_id').val() == ''){

                $('#tipo_jornadas_id').css('border', 'solid 1px red');
                $('#tipo_jornadas_id').focus();

                setTimeout(function(){ 
                    $('#tipo_jornadas_id').css('border', 'solid 1px #d2d6de');
                }, 4000);
            }
            @if(route('home') != "https://vym.t3rsc.co" || route('home') != "http://vym.t3rsc.co" ||
                route('home') != "https://listos.t3rsc.co" || route('home') != "http://listos.t3rsc.co" ||
                route("home") != "https://pruebaslistos.t3rsc.co" || route("home") != "https://gpc.t3rsc.co" ||
                route("home") != "http://localhost:8000")

                else if($('#tipo_liquidacion').val() == ''){

                    $('#tipo_liquidacion').css('border', 'solid 1px red');
                    $('#tipo_liquidacion').focus();

                    setTimeout(function(){ 
                        $('#tipo_liquidacion').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }
            
            @endif

            @if (route("home") != "https://gpc.t3rsc.co" || route("home") != "http://localhost:8000")
                else if($('#tipo_salario').val() == ''){

                    $('#tipo_salario').css('border', 'solid 1px red');
                    $('#tipo_salario').focus();

                    setTimeout(function(){ 
                        $('#tipo_salario').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }
            @endif

            @if(route("home") != "https://gpc.t3rsc.co")
                
                else if($('#tipo_nomina').val() == ''){
                
                    $('#tipo_nomina').css('border', 'solid 1px red');
                    $('#tipo_nomina').focus();

                    setTimeout(function(){ 
                        $('#tipo_nomina').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }
            
            @endif

            @if(route("home") != "https://gpc.t3rsc.co")

                else if($('#concepto_pago_id').val() == ''){
                
                    $('#concepto_pago_id').css('border', 'solid 1px red');
                    $('#concepto_pago_id').focus();

                    setTimeout(function(){ 
                        $('#concepto_pago_id').css('border', 'solid 1px #d2d6de');
                    }, 4000);
                }

            @endif

            @if(route('home') != "http://komatsu.t3rsc.co")
                
                else if($('#salario').val() == '' || $('#salario').val() == 0){

                    $('#salario').css('border', 'solid 1px red');
                    $('#salario').focus();

                    setTimeout(function(){
                        $('#salario').css('border', 'solid 1px #00a65a');
                    }, 4000);

                 $("#enviar_requerimiento_btn").removeAttr("disabled");
                  return false;
                }

            @endif
            
            else if($('#tipo_contrato_id').val() == ''){
                
                $('#tipo_contrato_id').css('border', 'solid 1px red');
                $('#tipo_contrato_id').focus();

                setTimeout(function(){ 
                    $('#tipo_contrato_id').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#motivo_requerimiento_id').val() == ''){

                $('#motivo_requerimiento_id').css('border', 'solid 1px red');
                $('#motivo_requerimiento_id').focus();

                setTimeout(function(){ 
                    $('#motivo_requerimiento_id').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#num_vacantes').val() == ''){
                
                $('#num_vacantes').css('border', 'solid 1px red');
                $('#num_vacantes').focus();

                setTimeout(function(){
                    $('#num_vacantes').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#nivel_estudio').val() == ''){
                
                $('#nivel_estudio').css('border', 'solid 1px red');
                $('#nivel_estudio').focus();

                setTimeout(function(){ 
                    $('#nivel_estudio').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#funciones').val() == ''){
                
                $('#funciones').css('border', 'solid 1px red');
                $('#funciones').focus();

                setTimeout(function(){ 
                    $('#funciones').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#edad_minima').val() == ''){
                
                $('#edad_minima').css('border', 'solid 1px red');
                $('#edad_minima').focus();

                setTimeout(function(){ 
                    $('#edad_minima').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#edad_maxima').val() == ''){
                
                $('#edad_maxima').css('border', 'solid 1px red');
                $('#edad_maxima').focus();

                setTimeout(function(){ 
                    $('#edad_maxima').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#genero_id').val() == ''){
                
                $('#genero_id').css('border', 'solid 1px red');
                $('#genero_id').focus();

                setTimeout(function(){ 
                    $('#genero_id').css('border', 'solid 1px #d2d6de');
                }, 4000);

            }else if($('#multiciudad_collapse').is(':visible')){

                if($('#ciudad_trabajo_multi').val() == ''){

                    $('.select2-selection--single').css('border', 'solid 1px red');
                    $('.select2-selection--single').focus();

                    setTimeout(function(){
                        $('.select2-selection--single').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }else if($('#salario_multi').val() == ''){

                    $('#salario_multi').css('border', 'solid 1px red');
                    $('#salario_multi').focus();

                    setTimeout(function(){ 
                        $('#salario_multi').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }else if($('#num_vacantes_multi').val() == ''){

                    $('#num_vacantes_multi').css('border', 'solid 1px red');
                    $('#num_vacantes_multi').focus();

                    setTimeout(function(){ 
                        $('#num_vacantes_multi').css('border', 'solid 1px #d2d6de');
                    }, 4000);
                }else{
                   $("#enviar_requerimiento_btn").removeAttr("disabled");
                    $("#frm_crearReq").submit();
                }
                 $("#enviar_requerimiento_btn").removeAttr("disabled");
            }
            else{
             $("#enviar_requerimiento_btn").removeAttr("disabled");
                $("#frm_crearReq").submit();
            }
             $("#enviar_requerimiento_btn").removeAttr("disabled");
        });
    </script>
@stop