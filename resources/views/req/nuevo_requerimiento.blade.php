@extends("req.layout.master")
@section("contenedor")
    <style>
        #multiciudad_collapse{
            display: none;
        }

        .well-verde{
          background-color: #66c5556b !important;
        }
    </style>

    @if(session()->has('errors'))
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(["route" => "req.guardar_requerimiento", "files"=>true, "id" => "nuevoRequerimiento"]) !!}
       {!! Form::hidden("negocio_id",$negocio->id) !!}
       {!! Form::hidden("cliente_id", $cliente->id, ["id"=>"cliente_id"]) !!}

        @if(route('home') == 'https://gpc.t3rsc.co')
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

                                 <div class="col-md-6 form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label"> Confidencial </label>
                                 <div class="col-sm-8">
                                   {!! Form::select("confidencial",['0'=>"No",'1'=>"Si"], null,[ "class" => "form-control", "id" => "confidencial"]);!!}
                                 </div>
                                </div>
                        </div>
                                        
                        <h4 class="box-header with-border">ESPECIFICACIONES DEL REQUERIMIENTO</h4>
                        
                        <div class="row">
                            {{-- Cargo cliente --}}
                            <div class="col-md-6 form-group">
                                <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                
                                <div class="col-sm-8">
                                    {!! Form::select("cargo_especifico_id", $cargo_especifico, null,[
                                        "class" => "form-control",
                                        "id" => "cargo_especifico_id",
                                        "required" => "required"
                                    ]); !!}
                                </div>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">
                                    {{(route("home") == "https://soluciones.t3rsc.co") ? 'Requisicion de Servicio' : 'Adjunto solicitud'}} <span></span>
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
                            <div class="container">
                                {!! session()->get('partial_html') !!}
                            </div>
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
                          <h3 class="box-title"> NUEVO REQUERIMIENTO </h3>
                        </div>

                        <h4 class="box-header with-border">
                            INFORMACIÓN GENERAL DE LA SOLICITUD
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="col-sm-4 control-label" for="inputEmail3">
                                    Tipo de Solicitud <span>*</span>
                                </label>
                          
                                <div class="col-sm-8">
                                    {!! Form::select("tipo_proceso_id",$tipoProceso,null,["class"=>"form-control", "id" => "tipo_proceso_id", "required" => "required"]);!!}
                                </div>
                            </div>
                            
                            {{-- <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Empresa Contrata <span>*</span></label>

                                <div class="col-sm-8">
                                    {!! Form::select("empresa_contrata",$empresa_logo,null,["class"=>"form-control", "id" => "empresa_contrata"]); !!}
                                </div>
                            </div> --}}

                            <div class="col-md-6 form-group">
                                <label class="col-sm-4 control-label" for="inputEmail3">
                                    Ciudad Trabajo <span>*</span>
                                </label>

                                <div class="col-sm-8">
                                 {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                                    
                                 {!! Form::text("ciudad_id",null,["style" => "display: none;", "class" => "form-control", "id" => "ciudad_id", "required" => "required"]) !!}

                                 {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}

                                 {!! Form::text("sitio_trabajo",null,["placeholder" => "Seleccionar una opción de la lista obligatorio", "class" => "form-control", "id"=>"sitio_trabajo_autocomplete", "required" => "required"]); !!}
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
                        </div>

                        @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "http://demo.t3rsc.co")
                         
                         <h4 class="box-header with-border">PERSONALIZACIÓN DE LA SOLICITUD</h4>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3">Nombre Solicitante</label>
                                    
                                    <div class="col-sm-8">
                                        {!! Form::hidden("solicitado_por",$user->id,["id"=>"solicitado_por"]); !!}
                                        {!! Form::text("solicitado_por_txt",strtoupper($user->name),["class"=>"form-control","placeholder"=>"Solicitante","id"=>"solicitado_por_txt"]); !!}
                                    </div>
                                </div>
                              
                                <div class="col-md-6 form-group">
                                 <label class="col-sm-4 control-label" for="inputEmail3"> Num. Requi Cliente </label>
                                  <div class="col-sm-8">
                                   {!!Form::text("num_req_cliente",'',["class"=>"form-control","placeholder"=>"# Requi Cliente"]); !!}
                                  </div>
                                </div>

                                <div class="col-md-6 form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label"> Confidencial </label>
                                 <div class="col-sm-8">
                                   {!! Form::select("confidencial",['0'=>"No",'1'=>"Si"], null,[ "class" => "form-control", "id" => "confidencial"]);!!}
                                 </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3"> Teléfono </label>
                                    
                                    <div class="col-sm-8">
                                        {!! Form::text("telefono_solicitante",$user->telefono,["class"=>"form-control","placeholder"=>"Teléfono Solicitante"]); !!}
                                    </div>
                                </div>

                                @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" ||
                                    route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co" ||
                                    route('home') == "http://localhost:8000" || route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co")
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
                        @endif

                        <h4 class="box-header with-border"> ESPECIFICACIONES DEL REQUERIMIENTO </h4>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @if(route('home') != "http://vym.t3rsc.co")
                                    <label for="inputEmail3" class="col-sm-4 control-label">Cargo Cliente <span>*</span></label>
                                @else
                                    <label for="inputEmail3" class="col-sm-4 control-label">Cargo Solicitado <span>*</span></label>
                                @endif

                                <div class="col-sm-8">
                                    {!! Form::select("cargo_especifico_id",$cargo_especifico,null,["class" => "form-control", "id" => "cargo_especifico_id", "required" => "required"]); !!}
                                </div>
                            </div>

                            @if(route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co" ||
                                route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" ||
                                route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
                                route('home') == "http://localhost:8000")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Enterprise</label>

                                    <div class="col-sm-8">
                                        <input type="text" name="enterprise" value="" class="form-control" id="enterprise">
                                    </div>
                                </div>
                            @endif
                            
                            <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">
                                    {{(route("home") == "https://soluciones.t3rsc.co")?'Requisicion de Servicio' : 'Adjunto solicitud'}}<span>*</span>
                                </label>
                                <div class="col-sm-8">
                                    {!!Form::file("perfil",["class"=>"form-control-file", "id"=>"perfil", "name"=>"perfil"]) !!}
                                </div>

                                <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("perfil",$errors) !!} </p>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="col-sm-4 control-label" for="inputEmail3"></label>
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

                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home')=="https://tiempos.t3rsc.co" ||
                            route('home') == "http://localhost:8000" )
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Limite Envio Candidatos <span>*</span></label>
                                    <div class="col-sm-8">
                                        {!! Form::text("fecha_presentacion_candidatos","$fecha_pre_c",["class"=>"form-control","placeholder"=>"AAAA-MM-DD","id"=>"fecha_presentacion_candidatos","readonly"=>true]); !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row" id="fecha_no">
                            @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Tentativa de contratación <span>*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="fecha_ingreso" class="form-control" id="fecha_ingreso" value="{{$fecha_tentativa}}" readonly  required >
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3">
                                        @if(route("home") == "http://localhost:8000" || route("home") == "https://vym.t3rsc.co")
                                            Fecha contrato
                                        @else
                                            Fecha Tentativa de ingreso 
                                        @endif
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("fecha_ingreso","$fecha_tentativa",["class"=>"form-control","placeholder"=>"AAAA-MM-DD","id"=>"fecha_ingreso"]); !!}
                                    </div>
                                </div>
                            @endif 

                            <div class="col-md-6 form-group">
                                <label class="col-sm-4 control-label" for="inputEmail3">
                                    @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co") Fecha Retiro @else Fecha Tentativa de Retiro @endif <span>*</span>
                                </label>

                                <div class="col-sm-8">
                                    {!! Form::text("fecha_retiro","$fecha_r_tentativa",["class" => "form-control", "placeholder" => "AAAA-MM-DD", "id" => "fecha_retiro", "required" => "required"]); !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
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

                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Contenido Email Soporte <span>*</span></label>
                            
                                    <div class="col-sm-8">
                                        {!!Form::textarea("contenido_email_soporte","$contenido_email_soporte",["class"=>"form-control","id"=>"contenido_email_soporte", "required" => "required"]);!!}
                                    </div>
                                </div>                        
                            @endif

                            @if(route("home") != "https://gpc.t3rsc.co")
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6 form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">¿ Requerimiento Multiciudad ?</label>

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
                        
                    </div>
                </div>
            </div>

            <div id="contratacion-directa" class="row well well-verde">
                <h4 class="with-border"> DATOS PARA CONTRATACION</h4>

                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>

                    <div class="col-sm-8">
                        <input type="date" name="fecha_ingreso_contra" value="" class="form-control fechas_ingresos" id="fecha_ingreso_contra">
                    </div>
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
                            {!! Form::select('ciudad_trabajo_multi[]', $ciudadesSelect, null, ['id'=>'ciudad_trabajo_multi','class'=>'form-control']) !!}
                           </div>
                        </div>

                            <div class="col-md-3 form-group">
                                <div class="col-sm-12">
                                    <label>Salario *</label>

                                    <input type="number" class="form-control" placeholder="SALARIO" name="salario_multi[]" id="salario_multi">
                                </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <div class="col-sm-12">
                                    <label>Número Vacantes *</label>

                                    <input type="number" class="form-control" placeholder="VACANTES" name="num_vacantes_multi[]" min="1" id="num_vacantes_multi">
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

        <div id="formPostularCandidatos" class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h4 class="box-header with-border">POSTULAR CANDIDATOS(opcional)</h4>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <div class="container" id="postulados">
                        <div class="row">

                            <div class="col-md-2 form-group">
                                <div class="col-sm-12">
                                    @if (route('home') == 'https://gpc.t3rsc.co')
                                        <label>CI *</label>
                                    @else
                                        <label>Cédula *</label>
                                    @endif
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

                            @if (route('home') == 'https://gpc.t3rsc.co')
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Hora Ingreso </label>
                                    <div class="col-sm-8">
                                        <input type="time" min="09:00" max="18:00" name="hora_ingreso" class="form-control" id="hora_ingreso">
                                    </div>
                                </div>
                            @endif
                            
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

                            @if (route('home') == 'https://gpc.t3rsc.co')
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Lugar y Persona de Contacto</label>
                                    <div class="col-sm-8">
                                        <textarea name="lugar_contacto" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            @endif

                            @if(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://localhost:8000')
                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                    <label>Fecha fin ultimo contrato</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control form_cam" name="fecha_ultimo_contrato">
                                    </div>
                                </div>
                            @endif

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
        
        {!! FuncionesGlobales::valida_boton_req("req.guardar_requerimiento","Enviar Requerimiento","submit","btn btn-success btnEnviarRequirimiento","","enviar_requerimiento_btn") !!}
    {!! Form::close()!!}
    <br/>

    <script>
        $("#postulados").delegate('.can_cedula', 'blur', function(){
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
        
        function validarEmail(object) {

              if (/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(object.val())){
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
            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca una ciudad'
            });

            $(".btnEnviarRequirimiento").prop("disabled","disabled");

            $('#contratacion-directa').hide();

            @if(route("home") != "https://gpc.t3rsc.co")
                $(document).on('change', '#select_multi_reque', function () {
                  if($(this).val() == 1){
                    $('#multiciudad_collapse').show('slow');
                    $('#ciudad_trabajo_multi').prop("required", true);
                    $('#salario_multi').prop("required", true);
                    $('#num_vacantes_multi').prop("required", true);
                  }else{
                    $('#multiciudad_collapse').hide('slow');
                    $('#ciudad_trabajo_multi').removeAttr('required');
                    $('#salario_multi').removeAttr('required');
                    $('#num_vacantes_multi').removeAttr('required');
                  }
                });
            @endif

            /*$('#ciudad_id').on('change invalid', function() {
                var campotexto = $(this).get(0);
                
                mensaje_danger('Seleccione una opcíon  de la ciudad de trabajo ');
                
                campotexto.setCustomValidity('');

                if (!campotexto.validity.valid) {
                    campotexto.setCustomValidity('Tiene que seleccionar una opción de la lista de la ciudad de trabajo');  
                }
            });*/

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


            $('#sitio_trabajo_autocomplete').autocomplete({
                serviceUrl: '{{route("autocomplete_cuidades")}}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    console.log(suggestion);
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

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
                }
            });
        @endif

            // handle the onchange event of the cargo_especifico_id selectlist
            $('#cargo_especifico_id').on("change", function (e) {
                var id = $(this).val();
                var negocio_id = '{{ $negocio->id }}';
                id_cliente = $("#cliente_id").val();

                $.ajax({
                    url: "{{ route('req.ajaxgetcargoespecificodependientes') }}",
                    type: 'POST',
                    data: {
                        cargo_especifico_id: id,
                        negocio_id: negocio_id,
                        cliente_id: id_cliente
                    }
                }).done(function (response) {
                    $('.here-put-fields-from-ajax').html(response);
                    $(".btnEnviarRequirimiento").prop("disabled","");

                    if($("#tipo_proceso_id").val() == 6){
                        $('.no_contra').hide('slow');
                    }else{
                        $('.no_contra').show('slow');
                    }
                })

                $.ajax({
                    url: "{{ route('listar_clausulas_cargo_post') }}",
                    type: 'POST',
                    data: {
                        cargo_id: id
                    }
                })
                .done(function (response) {
                    $('#adicionalesBox').html(response);
                })
            });

            @if(route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" || route('home') == "http://localhost:8000" || route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co" || route("home")=="http://temporizar.t3rsc.co" || route("home")=="https://temporizar.t3rsc.co" || route("home")=="https://vym.t3rsc.co")

                $(document).on('change', '#tipo_proceso_id', function () {

                    if($(this).val() == 6 || $(this).val() == 4){
                        $('#contratacion-directa').show('slow');
                        $('#fecha_no').hide('slow');
                        $('#formPostularCandidatos').removeClass('collapsed-box');
                        $('.can_nombres').prop("required", true);
                        $('.can_apellido').prop("required", true);
                        $('.can_cedula').prop("required", true);
                        $('.can_email').prop("required", true);
                    }else{
                        $('#contratacion-directa').hide('slow');
                        $('#contratacion-directa :input').val('');
                        $('#fecha_no').show('slow');
                        $('#formPostularCandidatos').addClass('collapsed-box');
                        $('.can_nombres').removeAttr("required");
                        $('.can_apellido').removeAttr("required");
                        $('.can_cedula').removeAttr("required");
                        $('.can_email').removeAttr("required");
                    }
                });
            @endif

            $(document).on('click', '#enviar_requerimiento_btn', function() {

              @if(route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" || route('home') == "http://localhost:8000" || route('home') == "http://desarrollo.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co" || route("home")=="http://temporizar.t3rsc.co" || route("home")=="https://temporizar.t3rsc.co")

                    if($('#tipo_proceso_id').val() == 6){
                        var mal =0;

                        $(".form_cam").each(function() {  // first pass, create name mappin
                            var name = $(this).val();
                            if(name == ""){
                                mal = mal+1;
                                $(this).css('border', 'solid 1px red');
                                $(this).focus();
                            }
                        });

                        if(mal !== 0){
                           return false;
                          mensaje_success('Debes Cargar Candidatos a Contratar');
                          $('.btn-box-tool').click();
                        }
                    }

                @endif

              //  if(('#select_multi_reque').val() == '1'){
              //  }
            
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

                @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" ||
                    route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co" ||
                    route('home') == "http://localhost:8000" || route('home') == "https://desarrollo.t3rsc.co")

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

                    return false;
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
                else if($('#fecha_recepcion').val() == ''){
                    
                    $('#fecha_recepcion').css('border', 'solid 1px red');
                    $('#fecha_recepcion').focus();

                    setTimeout(function(){ 
                        $('#fecha_recepcion').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }else if($('#contenido_email_soporte').val() == ''){
                    
                    $('#contenido_email_soporte').css('border', 'solid 1px red');
                    $('#contenido_email_soporte').focus();

                    setTimeout(function(){ 
                        $('#contenido_email_soporte').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }
                else if($('#ctra_x_clt_codigo').val() == ''){
                    
                    $('#ctra_x_clt_codigo').css('border', 'solid 1px red');
                    $('#ctra_x_clt_codigo').focus();

                    setTimeout(function(){ 
                        $('#ctra_x_clt_codigo').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                 return false;

                }else if($('#tipo_jornadas_id').val() == ''){

                    $('#tipo_jornadas_id').css('border', 'solid 1px red');
                    $('#tipo_jornadas_id').focus();

                    setTimeout(function(){ 
                        $('#tipo_jornadas_id').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }

             @if(route('home') != "https://vym.t3rsc.co" && route('home') != "http://vym.t3rsc.co" && route('home') != "https://listos.t3rsc.co" && route('home') != "http://listos.t3rsc.co")

                else if($('#tipo_liquidacion').val() == ''){

                    $('#tipo_liquidacion').css('border', 'solid 1px red');
                    $('#tipo_liquidacion').focus();

                    setTimeout(function(){
                        $('#tipo_liquidacion').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }

             @endif

                else if($('#tipo_salario').val() == ''){

                    $('#tipo_salario').css('border', 'solid 1px red');
                    $('#tipo_salario').focus();

                    setTimeout(function(){ 
                        $('#tipo_salario').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                 return false;

                }else if($('#tipo_nomina').val() == ''){
                    
                    $('#tipo_nomina').css('border', 'solid 1px red');
                    $('#tipo_nomina').focus();

                    setTimeout(function(){ 
                        $('#tipo_nomina').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }else if($('#concepto_pago_id').val() == ''){
                    
                    $('#concepto_pago_id').css('border', 'solid 1px red');
                    $('#concepto_pago_id').focus();

                    setTimeout(function(){ 
                        $('#concepto_pago_id').css('border', 'solid 1px #d2d6de');
                    }, 4000);

                }

                @if(route('home') != "http://komatsu.t3rsc.co")
                
                    else if($('#salario').val() == '' || $('#salario').val() == 0){

                        $('#salario').css('border', 'solid 1px red');
                        $('#salario').focus();

                        setTimeout(function(){ 
                            $('#salario').css('border', 'solid 1px #00a65a');
                        }, 4000);

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

                   return false;
                
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

                }else{
                    $("#frm_crearReq").submit();
                }
            });
        });
    </script>
@stop
