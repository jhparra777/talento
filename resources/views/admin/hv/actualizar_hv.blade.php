@extends("admin.layout.master")
@section("contenedor")
    <style type="text/css">
        .py-0 {
            padding-left: 2px;
            padding-right: 2px;
        }

        .py-1 {
            padding-left: 4px;
            padding-right: 4px;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
    {{-- DATOS BÁSICOS --}}
    @if($req != "")
     <a href="{{route("admin.gestion_requerimiento",["req_id"=>$req])}}" class="btn btn-info pull-right"> Volver al req {{$req}}</a>
    @endif
    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif
    <div class="col-right-item-container">
      <div class="container-fluid">
        {!!Form::model($datos_basicos,["class" => "form-horizontal form-datos-basicos", "id" => "fr_datos_basicos", "role" => "form", "route" => "admin.hv_actualizada", "method" => "POST", "files" => true])!!}
            {!! Form::hidden("user_id", null, ['id' => 'userId']) !!}

                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                    <div class="row">
                      <h3 class="header-section-form">
                       Información Personal <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span>
                      </h3>
                            
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="numero_id" class="col-md-5 control-label">Imagen Personal :</label>
                                
                                <div class="col-md-7">
                                    {!! Form::file("foto", ["class" => "form-control", "id" => "foto" ,"name" => "foto", "accept" => ".jpg,.jpeg,.png"]) !!}
                                </div>
                            </div>
                        </div>
           
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("foto",$errors) !!}</p>
                
                        {{--<div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                             <label for="nombres" class="col-md-5 control-label">Nombres:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                 {!! Form::text("nombres",null,["class"=>"form-control", "id"=>"nombres", "placeholder"=>"Nombres" ]) !!}
                                </div>
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
                        </div>--}}
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="nombres" class="col-md-5 control-label">Primer Nombre:<span class='text-danger sm-text-label'>*</span></label>
                            <div class="col-md-7">
                                {!! Form::text("primer_nombre",null,["class"=>"form-control", "id"=>"primer_nombre", "placeholder"=>"Primer Nombre" ]) !!}  
                            </div>
                        </div> 
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
                    </div>

                 <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="nombres" class="col-md-5 control-label">Segundo Nombre:<span class='text-danger sm-text-label'></span></label>
                        <div class="col-md-7">
                            {!! Form::text("segundo_nombre",null,["class"=>"form-control", "id"=>"segundo_nombre", "placeholder"=>"Segundo Nombre" ]) !!}  
                        </div>
                    </div> 
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="primer_apellido" class="col-md-5 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                    {!! Form::text("primer_apellido",null,["class"=>"form-control", "name"=>"primer_apellido" ,"id"=>"primer_apellido", "placeholder"=>"Primer Apellido"]) !!}
                                </div>
                            </div>
                
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="segundo_apellido" class="col-md-5 control-label">Segundo Apellido:  
                                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif
                                </label>

                                <div class="col-md-7">
                                    {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"id"=>"segundo_apellido", "placeholder"=>"Segundo Apellido" ]) !!}
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="tipo_id" class="col-md-5 control-label">Tipo de Identificación:<span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                    {!! Form::select("tipo_id",$tipos_documentos,null,["class"=>"form-control","id"=>"tipo_id"]) !!}
                                </div>                  
                            </div>
                
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_id",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="numero_id" class="col-md-5 control-label">@if(route('home') == "https://gpc.t3rsc.co") Cédula de identidad @else Número de Identificación @endif: <span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                    {!! Form::number("numero_id",null,["class"=>"form-control solo-numero", "id"=>"numero_id" ,"maxlength"=>"7","min"=>"1", "max"=>"9999999","pattern"=>".{1,7}", "placeholder"=>"Identificación"]) !!}
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="ciudad_id" class="col-md-5 control-label">
                                    Ciudad de Expedición de la Identificación:<span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                <div class="col-md-7">
                                    {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                                    {!! Form::hidden("ciudad_expedicion_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                                    {!! Form::hidden("departamento_expedicion_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                                    {!! Form::text("ciudad_autocomplete",$txtLugarExpedicion,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}
                                </div>
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="fecha_expedicion" class="col-md-5 control-label">Fecha Expedición de la Identificación:<span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                    {!! Form::text("fecha_expedicion",null,["class"=>"form-control", "id"=>"fecha_expedicion" ,"placeholder"=>"Fecha Expedición", "readonly" => "readonly"]) !!}
                                </div>
                            </div>
                
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_expedicion_id",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="pais_nacimiento" class="col-md-5 control-label">Lugar Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                    {!! Form::hidden("pais_nacimiento",null,["id"=>"pais_nacimiento"]) !!}
                                    {!! Form::hidden("departamento_nacimiento",null,["id"=>"departamento_nacimiento"]) !!}
                                    {!! Form::hidden("ciudad_nacimiento",null,["id"=>"ciudad_nacimiento"]) !!}
                                    {!! Form::text("txt_nacimiento",$txtLugarNacimiento,["id"=>"txt_nacimiento","class"=>"form-control","placeholder"=>"Digita cuidad"]) !!}
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_nacimiento",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="fecha_nacimiento" class="col-md-5 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                    {!! Form::text("fecha_nacimiento",null,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento", "readonly" => "readonly"]) !!}
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento",$errors) !!}</p>
                        </div>

                        @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" class="col-md-5 control-label">Grupo Sanguinero:<span class='text-danger sm-text-label'>*</span></label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::select("grupo_sanguineo",[""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],null,["class"=>"form-control", "id"=>"grupo_sanguineo"]) !!}
                                    </div>
                               </div>

                               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="rh" class="col-md-5 control-label">RH:<span class='text-danger sm-text-label'>*</span></label>

                                    <div class="col-md-7">
                                        {!! Form::select("rh",[""=>"Seleccionar","positivo"=>"POSITIVO","negativo"=>"NEGATIVO"],null,["class"=>"form-control", "id"=>"rh"]) !!}
                                    </div>
                               </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                            </div>
                        @endif
                        
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="movil" class="col-md-5 control-label">Número de Célular:</label>
                                <div class="col-md-7">
                                    {!! Form::text("telefono_movil",null,["class"=>"form-control solo-numero" ,"id"=>"telefono_fijo", "placeholder"=>"Móvil"]) !!}
                                </div>
                            </div>
                                
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                        </div>

                        @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="telefono_fijo" class="col-md-5 control-label">Número de Teléfono Fijo:<span class='text-danger sm-text-label'>*</span></label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::text("telefono_fijo",null,["class"=>"form-control solo-numero" ,"id"=>"telefono_fijo" ,"placeholder"=>"Teléfono Fijo"]) !!}
                                    </div>
                                </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="email" class="col-md-5 control-label">Correo Electrónico:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">                      
                                    {!! Form::text("email",null,["class"=>"form-control" ,"id"=>"email" ,"placeholder"=>"Correo Electrónico"]) !!}
                                </div>
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors)!!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="aspiracion_salarial" class="col-md-5 control-label">Aspiración Salarial:<span class='text-danger sm-text-label'>*</span></label>

                                <div class="col-md-7">
                                    @if(route('home') == "http://localhost:8000" || route('home') == "https://demo.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                                     {!! Form::text("aspiracion_salarial",null,["class"=>"form-control input-number" ,"id"=>"aspiracion_salarial", "maxlength"=>"","min"=>"1","pattern"=>"","placeholder"=>""])!!}
                                    @else
                                     {!! Form::select("aspiracion_salarial",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"aspiracion_salarial"]) !!}
                                    @endif
                                </div>
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors) !!}</p>
                        </div>

                        {{-- Tallas --}}
                        @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")

                         @if(route('home') != "https://capillasdelafe.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="zapatos" class="col-md-5 control-label">Talla Zapatos:@if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif</label>
                                    <div class="col-md-7">
                                     {!! Form::select("talla_zapatos",$talla_zapatos,null,["class"=>"form-control", "id"=>"talla_zapatos"]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">
                                     {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                    </p>
                                </div>
                            </div>
                         @endif

                            <div class="col-sm-6 col-lg-6">  
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Talla Camisa @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif </label>
                                    <div class="col-md-7">
                                        {!! Form::select("talla_camisa",$talla_camisa,null,["class"=>"form-control selectcategory", "id"=>"talla_camisa"]) !!}
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Talla Pantalon @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif </label>

                                    <div class="col-md-7">
                                        {!! Form::select("talla_pantalon",$talla_pantalon,null,["class"=>"form-control", "id"=>"talla_pantalon"]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                    </p>
                                </div>
                            </div>
    
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="ciudad_residencia" class="col-md-5 control-label">Ciudad Residencia:<span class='text-danger sm-text-label'>*</span></label>
                                    <div class="col-md-7">
                                        {!! Form::hidden("pais_residencia",null,["id"=>"pais_residencia"]) !!}
                                        {!! Form::hidden("departamento_residencia",null,["id"=>"departamento_residencia"]) !!}
                                        {!! Form::hidden("ciudad_residencia",null,["id"=>"ciudad_residencia"]) !!}

                                        {!! Form::text("txt_residencia",$txtLugarResidencia,["id"=>"txt_residencia","class"=>"form-control","placeholder"=>"Digita cuidad"]) !!}
                                    </div>
                                </div>
                                
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_residencia",$errors) !!}</p>
                            </div>
                        @endif

                        @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="complemento" class="col-md-5 control-label">Barrio @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif:</label>
                                
                                    <div class="col-md-7">
                                        {!! Form::text("barrio",null,["class"=>"form-control","id"=>"barrio","placeholder"=>"" ]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="entidad_eps" class="col-md-5 control-label">Entidad(EPS):
                                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif</label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::select("entidad_eps",$entidadesEps,NULL,["class"=>"form-control","id"=>"entidad_eps"]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="entidad_afp" class="col-md-5 control-label">Entidad(AFP):
                                        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif</label>

                                    <div class="col-md-7">
                                        {!! Form::select("entidad_afp",$entidadesAfp,null,["class"=>"form-control","id"=>"entidad_afp"]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">  
                                <div class="form-group">
                                    <label for="entidad_afp" class="col-md-5 control-label">Entidad de Cesantías:</label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::text("entidad_cesantias",null,["class"=>"form-control", "id"=>"entidad_cesantias","placeholder"=>"Entidad Cesantías"]) !!}

                                        <p class="error text-danger direction-botones-center">
                                            {!! FuncionesGlobales::getErrorData("entidad_cesantias",$errors) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="complemento" class="col-md-5 control-label">¿Tiene hijos?</label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::select("hijos",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"hijos"]) !!}
                                    </div>
                                </div>
                            </div>

                            @if($datos_basicos->numero_hijos && $datos_basicos->hijos == 1)
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="col-md-7">
                                            {!! Form::number('numero_hijos', null, ["class"=>"form-control selectcategory","id"=>"numero_hijos"]) !!}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="col-md-7">
                                            {!! Form::number('numero_hijos', null, ["class"=>"form-control selectcategory","id"=>"numero_hijos","style"=>"display:none;"]) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6 col-lg-6">                     
                                <div class="form-group">
                                    <label for="complemento" class="col-md-5 control-label">¿Tiene disponibilidad para viajar?</label>

                                    <div class="col-md-7">
                                        {!! Form::select("viaje",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"viaje"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co" ||
                            route('home') == "https://tiempos.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="categoria_licencia" class="col-md-5 control-label"> Tiene Licencia <span>*</span></label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::select("tiene_licencia",[""=>"Seleccionar","1"=>"si","0"=>"no"],null,["class"=>"form-control selectcategory","id"=>"tiene_licencia"]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="categoria_licencia" class="col-md-5 control-label">
                                        Categoría Licencia:
                                    </label>
                                    <div class="col-md-7">
                                        {!! Form::select("categoria_licencia",$categoriaLicencias,NULL,["class"=>"form-control","id"=>"categoria_licencia"])  !!}
                                    </div>
                                </div>
                                
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("categoria_licencia",$errors) !!}</p>
                            </div>
                        @endif
                        
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="complemento" class="col-md-5 control-label">¿Tiene conflicto de intereses?</label>
                                
                                <div class="col-md-7">
                                    {!! Form::select("conflicto",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"conflicto"]) !!}
                                    <br>
                                    
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal"> Ver política de conflicto de intereses</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="complemento" class="col-md-5 control-label">¿Trabaja actualmente en Komatsu?</label>
                                <div class="col-md-7">
                                  {!! Form::select("trabaja",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control selectcategory", "id"=>"trabaja"]) !!}
                                </div>
                            </div>
                        </div>

                        @if($datos_basicos->descripcion_conflicto && $datos_basicos->conflicto == 1)
                            <div class="col-sm-6 col-lg-12" id="descripcion_conflicto">
                                <label> ¿Qué parentezco tiene, los nombres y el área del trabajador?  / Caracteres restantes: </label>

                                {!! Form::textarea("descripcion_conflicto",$datos_basicos->descripcion_conflicto,["maxlength"=>"550","class"=>"form-control ",'rows' => 3,"id"=>"descripcion_conflicto" ]) !!}
                                    
                                <p class="error text-danger direction-botones-center">
                                    {!! FuncionesGlobales::getErrorData("barrio",$errors) !!}
                                </p>
                            </div>

                            @else

                            <div class="col-sm-6 col-lg-12" style="display: none;" id="descripcion_conflicto">  
                              <label> ¿Qué parentezco tiene, los nombres y el área del trabajador?  / Caracteres restantes: </label>
                                {!! Form::textarea("descripcion_conflicto",null,["maxlength"=>"550","class"=>"form-control ",'rows' => 3,"id"=>"descripcion_conflicto" ]) !!}
                               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("barrio",$errors) !!}</p>
                            </div>

                            @endif

                        @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co" && route('home') != "http://tiempos.t3rsc.co")

                          <div class="col-sm-6 col-lg-12">
                           <label>Perfil laboral  / Caracteres restantes:</label>
                            {!! Form::textarea("descrip_profesional",null,["class"=>"form-control",'rows' => 3,"id"=>"descrip_profesional","placeholder"=>"Escribe aca tu descripcion profesional . Máximo 550 caracteres" ]) !!}  
                             <p class="error text-danger direction-botones-center">
                              {!!FuncionesGlobales::getErrorData("descrip_profesional",$errors)!!}
                             </p>
                          </div>
                        @endif
                    </div>
                @else
                    <div class="row">
                      <h3 class="header-section-form">Información Personal <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                        
                        <div class="col-sm-6 col-lg-6">

                          <div class="form-group">
                            <label for="numero_id" class="col-md-5 control-label">Foto(formato png, jpg o jpeg):@if($user->foto_perfil!="" && $user->foto_perfil!=null)
                             <a class="" title="Ver" target="_blank" href="{{url("recursos_datosbasicos/".$user->foto_perfil)}}" style="color: green;"> <i class="fa fa-eye"> </i>
                               Ver
                             </a> @endif</label>
                              <div class="col-md-7">

                                {!! Form::file("foto", ["class" => "form-control", "id" => "foto" ,"name" => "foto", "accept" => ".jpg,.jpeg,.png"]) !!}

                              </div>
                          </div>
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("foto",$errors) !!}</p>

                         <div class="col-sm-6 col-lg-6">
                          <div class="form-group">
                            <label for="archivo_documento" class="col-md-5 control-label"> @if(route("home")=="https://humannet.t3rsc.co") Curriculo(.PDF,.DOC o .DOCX): @else Hoja de Vida(.PDF,.DOC o .DOCX):@endif @if($hoja_vida!=null)

                                <a class="" title="Ver" target="_blank" href="{{url("recursos_documentos/".$hoja_vida->nombre_archivo)}}" style="color: green;">
                                                <i class="fa fa-eye">
                                                </i>
                                                Ver
                                    </a>
                                @endif
                                </label>
                               <span class='text-danger sm-text-label'>*</span></label>
                              <div class="col-md-7">
                               {!! Form::file("archivo_documento", ["class"=>"form-control","id"=>"archivo_documento","accept" => ".pdf,.doc,.docx"]) !!}
                              </div>
                          </div>
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento",$errors) !!}</p>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                              <label for="tipo_id" class="col-md-5 control-label">Tipo ID:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                  {!! Form::select("tipo_id",$tipos_documentos,null,["class"=>"form-control","id"=>"tipo_id"]) !!}
                                </div>
                            </div>
						  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_id",$errors) !!}</p>
						</div>
                    
                           
                            <div class="col-sm-6 col-lg-6">
                              <div class="form-group">
                               <label for="numero_id" class="col-md-5 control-label">@if(route('home') == "https://gpc.t3rsc.co") Cédula de identidad @else Número de Identificación @endif: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-7">
                                {!! Form::number("numero_id",null,["class"=>"form-control solo-numero", "id"=>"numero_id" ,"maxlength"=>"16","min"=>"1", "max"=>"9999999999999999","pattern"=>".{1,16}", "placeholder"=>"Identificación"]) !!}
                              </div>
                            </div>
                             <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
                            </div>
                          
                        @if(route("home")!="https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                  <label for="ciudad_id" class="col-md-5 control-label">Ciudad de @if(route("home")=="https://humannet.t3rsc.co") emisión  @else expedición @endif  documento:<span class='text-danger sm-text-label'>*</span></label>
                                    <div class="col-md-7">
                                      {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id_exp"]) !!}
                                      {!! Form::hidden("departamento_expedicion_id",null,["class"=>"form-control","id"=>"departamento_id_exp"]) !!}
                                      {!! Form::hidden("ciudad_expedicion_id",null,["class"=>"form-control","id"=>"ciudad_id_exp"]) !!}
                                      {!! Form::text("ciudad_autocomplete",$txtLugarExpedicion,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}
                                    </div>
                                </div>
                                
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_id",$errors) !!}</p>
                            
                            </div>

                            <div class="col-sm-6 col-lg-6">
                              <div class="form-group">
                                 <label for="fecha_expedicion" class="col-md-5 control-label">Fecha @if(route("home")=="https://humannet.t3rsc.co") Emisión @else Expedición: @endif <span class='text-danger sm-text-label'>*</span></label>   
                                    <div class="col-md-7">
                                     {!! Form::text("fecha_expedicion",null,["class"=>"form-control", "id"=>"fecha_expedicion" ,"placeholder"=>"Fecha Expedición", "readonly" => "readonly"])!!}
                                    </div>
                                </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_expedicion_id",$errors) !!}</p>
                            </div>
                        @endif
                
                            {{--<div class="col-sm-6 col-lg-6">
                                
                              <div class="form-group">
                               <label for="nombres" class="col-md-5 control-label">Nombres:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                 {!! Form::text("nombres",null,["class"=>"form-control", "id"=>"nombres", "placeholder"=>"Nombres" ]) !!}  
                                </div>
                              </div> 
                               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
                            
                            </div>--}}
                             <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="nombres" class="col-md-5 control-label">Primer Nombre:<span class='text-danger sm-text-label'>*</span></label>
                                    <div class="col-md-7">
                                        {!! Form::text("primer_nombre",null,["class"=>"form-control", "id"=>"primer_nombre", "placeholder"=>"Primer Nombre" ]) !!}  
                                    </div>
                                </div> 
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
                            </div>

                         <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="nombres" class="col-md-5 control-label">Segundo Nombre:<span class='text-danger sm-text-label'></span></label>
                                <div class="col-md-7">
                                    {!! Form::text("segundo_nombre",null,["class"=>"form-control", "id"=>"segundo_nombre", "placeholder"=>"Segundo Nombre" ]) !!}  
                                </div>
                            </div> 
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                        </div>
                            <div class="col-sm-6 col-lg-6">
                              <div class="form-group">
                                <label for="primer_apellido" class="col-md-5 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span></label>
                                 <div class="col-md-7">
                                    {!! Form::text("primer_apellido",null,["class"=>"form-control", "name"=>"primer_apellido" ,"id"=>"primer_apellido", "placeholder"=>"Primer Apellido"]) !!}
                                 </div>
                              </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                
                                <div class="form-group">
                                 <label for="segundo_apellido" class="col-md-5 control-label">Segundo Apellido:</label>
                                    <div class="col-md-7">
                                     {!! Form::text("segundo_apellido",null,["class"=>"form-control" ,"id"=>"segundo_apellido", "placeholder"=>"Segundo Apellido" ]) !!}
                                    </div>
                                </div>
                               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                            </div>

                        <div class="col-sm-6 col-lg-6">
                
                            <div class="form-group">
                              <label for="fecha_nacimiento" class="col-md-5 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-7">
                                {!! Form::text("fecha_nacimiento",null,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento", "readonly" => "readonly"]) !!}
                               </div>
                            </div>
                        </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                 <label for="pais_nacimiento" class="col-md-5 control-label">Lugar Nacimiento:<span class='text-danger sm-text-label'>*</span></label>
                                  <div class="col-md-7">
                                   {!! Form::hidden("pais_nacimiento",null,["id"=>"pais_nacimiento"]) !!}
                                   {!! Form::hidden("departamento_nacimiento",null,["id"=>"departamento_nacimiento"]) !!}
                                   {!! Form::hidden("ciudad_nacimiento",null,["id"=>"ciudad_nacimiento"]) !!}
                                   {!! Form::text("txt_nacimiento",$txtLugarNacimiento,["id"=>"txt_nacimiento","class"=>"form-control","placeholder"=>"Digita cuidad"]) !!}
                                  </div>
                                </div>
                               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento",$errors) !!}</p>
                            </div>

                        @if(route('home') != "https://gpc.t3rsc.co")
                            @if(route("home") == "https://tiempos.t3rsc.co")
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                      <label for="grupo_sanguineo" class="col-md-5 control-label">Grupo Sanguinero:<span class='text-danger sm-text-label'>*</span></label>  
                                        <div class="col-md-7">
                                          {!! Form::select("grupo_s",[""=>"Seleccionar","A-positivo"=>"A(+)","B-positivo"=>"B(+)","O-positivo"=>"O(+)","AB-positivo"=>"AB(+)","A-negativo"=>"A(-)","B-negativo"=>"B(-)","O-negativo"=>"O(-)","AB-negativo"=>"AB(-)"],$grupo,["class"=>"form-control selectcategory", "id"=>"grupo_sanguineo"]) !!}
                                        </div>
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                                </div>
                            @else
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento" class="col-md-5 control-label">Grupo Sanguinero:<span class='text-danger sm-text-label'>*</span></label>
                                        
                                        <div class="col-md-7">
                                            {!! Form::select("grupo_sanguineo",[""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],null,["class"=>"form-control", "id"=>"grupo_sanguineo"]) !!}
                                        </div>
                                    </div>
                                    
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                                </div>

                                <div class="col-sm-6 col-lg-6">   
                                    <div class="form-group">
                                        <label for="rh" class="col-md-5 control-label">RH:<span class='text-danger sm-text-label'>*</span></label>
                                        
                                        <div class="col-md-7">
                                            {!! Form::select("rh",[""=>"Seleccionar","positivo"=>"POSITIVO","negativo"=>"NEGATIVO"],null,["class"=>"form-control", "id"=>"rh"]) !!}
                                        </div>
                                    </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rh",$errors) !!}</p>
                                </div>
                            @endif
                          
                            <div class="col-sm-6 col-lg-6">
                    
                                <div class="form-group">
                                    <label for="genero" class="col-md-5 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>
                                    <div class="col-md-7">
                                        {!! Form::select("genero",$genero,null,["id"=>"genero","class"=>"form-control"]) !!}
                                    </div>
                                </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="estado_civil" class="col-md-5 control-label">Estado Civil:<span class='text-danger sm-text-label'>*</span></label>
                                
                                <div class="col-md-7">
                                 {!! Form::select("estado_civil",$estadoCivil,null,["class"=>"form-control" ,"id"=>"estado_civil"]) !!}
                                </div>
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_civil",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                             <label for="movil" class="col-md-5 control-label">Teléfono Móvil:</label>
                              <div class="col-md-7">
                               {!! Form::number("telefono_movil",null,["class"=>"form-control solo-numero" ,"id"=>"telefono_fijo","maxlength"=>"10","min"=>"1", "max"=>"9999999999","pattern"=>".{1,10}", "placeholder"=>"Móvil"]) !!}
                              </div>
                            </div>
                          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                        </div>
            
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                              <label for="telefono_fijo" class="col-md-5 control-label">@if(route("home")=="https://humannet.t3rsc.co") Red fija: @else Teléfono Fijo: @endif <span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                 {!! Form::number("telefono_fijo",null,["class"=>"form-control solo-numero" ,"id"=>"telefono_fijo", "maxlength"=>"7","min"=>"1", "max"=>"9999999","pattern"=>".{1,7}","placeholder"=>"Teléfono Fijo"]) !!}
                                </div>
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                              <label for="email" class="col-md-5 control-label">Correo Electrónico:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">                      
                                 {!! Form::text("email",null,["class"=>"form-control" ,"id"=>"email" ,"placeholder"=>"Correo Electrónico"]) !!}
                                </div>
                            </div>
                          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                        </div>

                        @if( route("home")!="https://gpc.t3rsc.co" )
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="aspiracion_salarial" class="col-md-5 control-label">Aspiración Salarial:<span class='text-danger sm-text-label'>*</span></label>
                                
                                    <div class="col-md-7">
                                        @if(route('home') == "http://localhost:8000" || route('home') == "https://demo.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" || route('home') == "https://desarrollo.t3rsc.co")

                                            {!! Form::text("aspiracion_salarial",null,["class"=>"form-control input-number" ,"id"=>"aspiracion_salarial","min"=>"1","placeholder"=>""])!!}

                                        @else

                                            {!! Form::select("aspiracion_salarial",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"aspiracion_salarial"]) !!}
                                        @endif
                                        
                                    </div>
                                </div>

                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors) !!}</p>
                            </div>
                        @endif

                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="aspiracion_salarial" class="col-md-5 control-label"> Direccion de skype: <span class='text-danger sm-text-label'></span> </label>

                                    <div class="col-md-7">                     
                                        {!!Form::text("direccion_skype",$datos_basicos->direccion_skype,["class"=>"form-control","id"=>"skype","placeholder"=>"skype" ]) !!}
                                    </div>
                                </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("direccion_skype",$errors) !!}</p>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="aspiracion_salarial" class="col-md-5 control-label"> Otro telefono ubicacion: <span class='text-danger sm-text-label'></span> </label>
                                    
                                    <div class="col-md-7">                    
                                        {!!Form::text("otro_telefono",$datos_basicos->otro_telefono,["class"=>"form-control input-number","id"=>"otro_telefono","placeholder"=>""])!!}
                                    </div>
                                </div>
                          
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("otro_telefono",$errors)!!} </p>
                            </div>
                        @endif

                        {{--Tallas--}}
                        @if(route('home') != "https://nases.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                         @if(route('home') != "https://capillasdelafe.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="entidad_eps" class="col-md-5 control-label">Talla Zapatos:</label>
                                    
                                    <div class="col-md-7">
                                        {!! Form::select("talla_zapatos",$talla_zapatos,null,["class"=>"form-control", "id"=>"talla_zapatos"]) !!}
                                    </div>

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                    </p>
                                </div>
                            </div>
                          @endif
                          
                            <div class="col-sm-6 col-lg-6">
                                
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Talla Camisa </label>
                                    <div class="col-md-7">
                                        {!! Form::select("talla_camisa",$talla_camisa,null,["class"=>"form-control selectcategory", "id"=>"talla_camisa"]) !!}
                                    </div>
                                    <p class="error text-danger direction-botones-center">
                                     {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                                
                                <div class="form-group">
                                  <label class="col-md-5 control-label">Talla Pantalon</label>
                                   <div class="col-md-7">
                                    {!! Form::select("talla_pantalon",$talla_pantalon,null,["class"=>"form-control", "id"=>"talla_pantalon"]) !!}
                                   </div>
                                   <p class="error text-danger direction-botones-center">
                                    {!! FuncionesGlobales::getErrorData("talla_zapatos",$errors) !!} </p>
                                </div>
                            </div>
                        @endif

                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">

                                    @if(route("home")=="https://humannet.t3rsc.co")
                                     <label for="entidad_eps" class="col-md-5 control-label">Fondo de salud:</label>
                                    @else
                                     <label for="entidad_eps" class="col-md-5 control-label">Entidad(EPS):</label>
                                    @endif
                                 
                                    
                                    <div class="col-md-7">
                                      {!! Form::select("entidad_eps",$entidadesEps,NULL,["class"=>"form-control","id"=>"entidad_eps"]) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6">   
                                <div class="form-group">
                                 <label for="entidad_afp" class="col-md-5 control-label">Entidad(AFP):</label>
                                    
                                    <div class="col-md-7">
                                     {!! Form::select("entidad_afp",$entidadesAfp,null,["class"=>"form-control","id"=>"entidad_afp"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(route('home') == "https://listos.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="caja_compensaciones" class="col-md-5 control-label">Entidad(CAJA COMPENSACIÓN):</label>
                                    <div class="col-md-7">
                                        {!! Form::select("caja_compensaciones",$caja_compensaciones,NULL,["class"=>"form-control","id"=>"caja_compensaciones"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                              <label for="ciudad_residencia" class="col-md-5 control-label">Ciudad Residencia:<span class='text-danger sm-text-label'>*</span></label>
                                <div class="col-md-7">
                                    {!! Form::hidden("pais_residencia",null,["id"=>"pais_residencia"]) !!}
                                    {!! Form::hidden("departamento_residencia",null,["id"=>"departamento_residencia"]) !!}
                                    {!! Form::hidden("ciudad_residencia",null,["id"=>"ciudad_residencia"]) !!}
                                    {!! Form::text("txt_residencia",$txtLugarResidencia,["id"=>"txt_residencia","class"=>"form-control","placeholder"=>"Digita cuidad"]) !!}
                                </div>
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_residencia",$errors) !!}</p>
                        </div>

                        @if(route("home")!="https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="complemento" class="col-md-5 control-label">@if(route("home")=="https://humannet.t3rsc.co") Comuna: @else Barrio: @endif  @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")<span class='text-danger sm-text-label'>*</span> @endif</label>
                                    <div class="col-md-7">
                                     {!! Form::text("barrio",null,["class"=>"form-control","id"=>"barrio","placeholder"=>"" ]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="direccion" class="col-md-5 control-label">Dirección:</label>

                                <div class="col-md-7">
                                    @if ($sitio->direccion_dian)
                                        <?php
                                            $direccion_dian_candidato = $datos_basicos->getDireccionDian;
                                        ?>
                                        <input class="form-control" type="text" readonly="readonly" placeholder="" id="direccion" name="direccion" value="@if($direccion_dian_candidato != null && $direccion_dian_candidato != '') {{ $datos_basicos->direccion }}@endif"></input>
                                    @else
                                        {!! Form::text("direccion", null, ["class" => "form-control", "id" => "direccion", "placeholder" => ""]) !!}
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="aspiracion_salarial" class="col-md-5 control-label"> Tipo vivienda: <span class='text-danger sm-text-label'></span> </label>
                                    
                                    <div class="col-md-7">                    
                                     {!! Form::select("tipo_vivienda",[''=>"seleccione",'propia'=>"Propia",'alquilada'=>"Alquilada",'0'=>"otro"],$datos_basicos->tipo_vivienda,["class"=>"form-control","id"=>"tipo_vivienda"]) !!}
                                    </div>
                                </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors) !!}</p>
                            </div>
                  
                            <div class="col-sm-6 col-lg-6">  
                             <div class="form-group">
                              <label for="aspiracion_salarial" class="col-md-5 control-label"> Número Hijos: <span class='text-danger sm-text-label'></span> </label>
                                    
                                <div class="col-md-7">
                                 {!! Form::select("numero_hijos",["N/A"=>"N/A","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5 o mas"=>"5 o mas"],$datos_basicos->numero_hijos,["class"=>"form-control selectcategory", "id"=>"numero_hijos"]) !!}
                                </div>
                             </div>
                             <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors) !!}</p>
                            </div>

                        <div class="col-sm-6 col-lg-6">  
                         <div class="form-group">
                          <label for="aspiracion_salarial" class="col-md-5 control-label"> Edad Hijos: <small>Separar por comas(,)</small><span class='text-danger sm-text-label'></span> </label>
                          <div class="col-md-7">                    
                          {!! Form::text("edad_hijos",$datos_basicos->edad_hijos,["class"=>"form-control","id"=>"edad_hijos"]) !!}
                          </div>
                         </div>
                         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspiracion_salarial",$errors)!!}</p>
                        </div>
                    
                    @endif
                        
                    @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")
                    
                    <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label"> Estrato</label>
                            <div class="col-md-7">
                                {!! Form::select("estrato",[""=>"Seleccionar","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5", "6"=>"6"],null,["class"=>"form-control selectcategory", "id"=>"estrato"]) !!}
                            </div>
                        </div>

                        <p class="error text-danger direction-botones-center">
                            {!!FuncionesGlobales::getErrorData("estrato", $errors)!!} 
                        </p>
                    </div>

                    <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label  class="col-md-5 control-label">
                                ¿Pertenece a algún Grupo poblacional?
                            </label>
                            <div class="col-md-7">
                                {!!Form::select("pertenece_grupo_poblacional",["0"=>"No", "1"=>"Si"], (is_null($datos_basicos->grupo_poblacional) || $datos_basicos->grupo_poblacional == "") ? 0 : 1,["class"=>"form-control selectcategory", "id" => "pertenece_grupo_poblacional"])!!}
                            </div>
                        </div>

                        <p class="error text-danger direction-botones-center">
                            {!!FuncionesGlobales::getErrorData("pertenece_grupo_poblacional",$errors) !!}
                        </p>
                    </div>

                    <div id="grupo_poblacional" class="col-md-6 col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label">
                                Grupo Poblacional
                            </label>
                            <div class="col-md-7">
                                {!!Form::select("grupo_poblacional",[
                                    ""                  =>"Seleccionar", 
                                    "Afrodescendiente"  => "Afrodescendiente",
                                    "Indígena"          => "Indígena",
                                    "Población victima" => "Población victima",
                                    "Desmovilizados"    => "Desmovilizados",
                                    "Inclusión laboral" => "Inclusión laboral",
                                    "Otro" => "Otro"], $datos_basicos->grupo_poblacional,["class"=>"form-control selectcategory", "id" => "select_grupo_poblacional"])!!}
                            </div>
                        </div>

                        <p class="error text-danger direction-botones-center">
                            {!!FuncionesGlobales::getErrorData("grupo_poblacional",$errors) !!}
                        </p>
                    </div>

                    <div id="otro_grupo" class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label"> Describa otro grupo poblacional</label>
                            <div class="col-md-7">
                                {!!Form::text("otro_grupo_poblacional",$datos_basicos->otro_grupo_poblacional,["class"=>"form-control", "id" => "otro_grupo_poblacional"])!!}
                            </div>
                        </div>

                        <p class="error text-danger direction-botones-center">
                            {!!FuncionesGlobales::getErrorData("otro_grupo_poblacional",$errors)!!}
                        </p>
                    </div>

                      <div class="col-sm-6 col-lg-6">
                       <div class="form-group">
                        <label class="col-md-5 control-label">Descripción de su perfil Profesional</label>
                         <div class="col-md-7">
                          {!! Form::textarea("descrip_profesional",null,["class"=>"form-control",'rows' => 3,"id"=>"descrip_profesional","placeholder"=>"Escribe aca tu descripcion profesional . Máximo 550 caracteres"])!!}
                         </div>
                       </div>
                       <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("descrip_profesional",$errors)!!} </p>
                     </div>

                    @endif

                   @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                   
                    <div id="situacion_militar">
                      <div class="col-sm-6 col-lg-6">
                       <div class="form-group">
                       <label for="situacion_militar_definida" class="col-md-5 control-label">Situación Militar Definida:</label>
                        <div class="col-md-7">
                         {!! Form::select("situacion_militar_definida",[""=>"Seleccionar","1"=>"si","0"=>"no"],null,["class"=>"form-control militar_situacion selectcategory"]) !!}
                        </div>
                       </div>
                      </div>
                    </div>

                    <div id="libreta_militar">
                     
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                              <label for="complemento" class="col-md-5 control-label">No. Libreta:</label>
                                <div class="col-md-7">
                                 {!! Form::text("numero_libreta",null,["class"=>"form-control", "id"=>"numero_libreta","placeholder"=>"# Libreta Militar"]) !!}
                                </div>
                            </div>
                          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_libreta",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                          <div class="form-group">
                            <label for="tipo_via" class="col-md-5 control-label">Clase Libreta:</label>
                              <div class="col-md-7">
                               {!! Form::select("clase_libreta",$claseLibreta,null,["id"=>"clase_libreta","class"=>"form-control"]) !!}
                              </div>
                          </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("clase_libreta",$errors) !!}</p>
                        </div>
                    
                      @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                        <div class="col-sm-6 col-lg-6">
                          <div class="form-group">
                             <label for="num_distrito_militar" class="col-md-5 control-label"># Distrito Militar:</label>
                              <div class="col-md-7">
                               {!! Form::text("distrito_militar",null,["id"=>"distrito_militar","class"=>"form-control","placeholder"=>"Número Distrito"]) !!}
                              </div>
                          </div>
                          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("distrito_militar",$errors) !!}</p>
                        </div>
                      @endif
                    </div>

                    @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")

                        <div class="col-sm-6 col-lg-6">
                         <div class="form-group">
                            @if(route("home")=="https://humannet.t3rsc.co")
                                 <label for="tiene_vehiculo" class="col-md-5 control-label">Posee auto?:</label>
                            @else  
                                 <label for="tiene_vehiculo" class="col-md-5 control-label">Tiene Vehículo:</label>
                            @endif
                         
                          <div class="col-md-7">
                           {!! Form::select("tiene_vehiculo",[""=>"Seleccionar","1"=>"SI","0"=>"NO"],null,["class"=>"form-control","id"=>"tiene_vehiculo"]) !!}
                           </div>
                         </div>
                        </div>

                        @if(route("home")=="https://humannet.t3rsc.co")

                         <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                             <label for="tiene_vehiculo" class="col-md-5 control-label"> Nivel Estudio:</label>           
                              <div class="col-md-7">
                               {!!Form::select("nivel_estudio",$nivel_academico,null,["class"=>"form-control","id"=>"nivel_estudio"])!!}
                              </div>
                            </div>
                         </div>

                        @endif

                        <div class="col-sm-6 col-lg-6">
                          <div class="form-group">
                           <label for="tipo_vehiculo" class="col-md-5 control-label">Tipo Vehículo:</label>
                            <div class="col-md-7">
                             {!! Form::select("tipo_vehiculo",$tipoVehiculo,null,["id"=>"tipo_vehiculo","class"=>"form-control"]) !!}
                            </div>
                          </div>
                         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vehiculo",$errors) !!}</p>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                         <div class="form-group">
                         <label for="num_licencia" class="col-md-5 control-label"># Licencia:</label>
                          <div class="col-md-7">
                          {!! Form::text("numero_licencia",null,["class"=>"form-control", "id"=>"numero_licencia","placeholder"=>"# Licencia"]) !!}
                          </div>
                         </div>
                         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_licencia",$errors) !!}</p>
                        </div>

                    @endif
                   @endif
                  
                  @if(route('home') == "https://gpc.t3rsc.co")
                        
                    <div class="col-sm-6 col-lg-6">
                     <div class="form-group">
                      <label for="tipo_vehiculo" class="col-md-5 control-label">Tipo Vehículo:</label>
                       <div class="col-md-7">
                        {!!Form::select("tipo_vehiculo_t",[''=>"Seleccione",'propio'=>"Propio",'prendado'=>"Prendado",'0'=>"otro"],null,["id"=>"tipo_vehiculo_t","class"=>"form-control"]) !!}
                       </div>
                     </div>
                     <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_vehiculo",$errors) !!}</p>
                    </div>
                  @endif
                @endif

                @if(route("home") == "https://gpc.t3rsc.co")

                 <div class="row" id="info-adicional">
                  <h3 class="header-section-form col-md-offset-3"> Descripción de sus objetivos </h3>
                    <div class="col-sm-12 col-lg-12">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-2 control-label"> Personales:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-10">
                        {!! Form::textarea("obj_personales",null,["class"=>"form-control" ,"id"=>"obj_personales","placeholder"=>"Objetivos Personales","maxlength"=>"5000"])!!}
                        </div>
                       </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                    </div>

                       <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                         <label for="complemento" class="col-md-2 control-label"> Profesionales: <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                         {!! Form::textarea("obj_profesionales",null,["class"=>"form-control" ,"id"=>"obj_profesionales","placeholder"=>"Objetivos Profesionales","maxlength"=>"5000"])!!}
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Academicos: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("obj_academicos",null,["class"=>"form-control" ,"id"=>"obj_academicos","placeholder"=>"Objetivos Academicos","maxlength"=>"5000"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                      </div>

                    <div class="row" id="info-adicional">
                     <h3 class="header-section-form col-md-offset-3"> Disponibilidad para condiciones de trabajo </h3>
                    
                      <div class="col-sm-12 col-lg-12">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-2 control-label"> Horarios Flexibles: <span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-10">
                          {!!Form::select("horario_flexible",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"horario_flexible"])!!}
                        </div>
                       </div>
                       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                      </div>

                       <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                         <label for="complemento" class="col-md-2 control-label"> Viajes regionales: <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!!Form::select("viaje_regional",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"viajes_regionales"])!!}
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Viajes internacionales : <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!!Form::select("viaje_internacional",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"viaje_internacional"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                        
                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Cambio de ciudad : <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!!Form::select("cambio_ciudad",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"cambio_ciudad"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                         
                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Cambio de pais: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!!Form::select("cambio_pais",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"cambio_pais"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                        
                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Explique su estado de salud actual o cualquier observacion a ser considerada: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("estado_salud",null,["class"=>"form-control" ,"id"=>"estado_salud","placeholder"=>"","maxlength"=>"5000"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Carnet de conadis: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!!Form::select("conadis",[''=>"Seleccione",'Si'=>"Si",'No'=>"No"],null,["class"=>"form-control","id"=>"conadis"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Tipo y grado de discapacidad: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("grado_disca",null,["class"=>"form-control" ,"id"=>"grado_disca","placeholder"=>"","maxlength"=>"5000"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                    </div>

                    <div class="row" id="info-adicional">
                     <h3 class="header-section-form col-md-offset-3"> Aspiración salarial y de beneficios </h3>
                    
                      <div class="col-sm-12 col-lg-6">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-6 control-label"> Sueldo fijo bruto: <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!!Form::text("sueldo_bruto",null,["class"=>"form-control","id"=>"sueldo_bruto"])!!}
                         </div>
                       </div>
                       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                      </div>

                       <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                         <label for="complemento" class="col-md-6 control-label"> Ingreso variable mensual (comisiones/bonos): <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!! Form::text("comision_bonos",null,["class"=>"form-control" ,"id"=>"comision_bonos","placeholder"=>"","maxlength"=>"5000"])!!}
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-6 control-label"> Otros bonos (montos y periodicidad) : <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("otros_bonos",null,["class"=>"form-control" ,"id"=>"otros_bonos","placeholder"=>"","maxlength"=>"5000"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                        
                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-6 control-label"> Total ingreso anual: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("ingreso_anual",null,["class"=>"form-control" ,"id"=>"ingreso_anual","placeholder"=>""])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-6 control-label"> Total ingreso mensual: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("ingreso_mensual",null,["class"=>"form-control input-number","id"=>"ingreso_mensual","placeholder"=>""])!!}
                               </div>
                             </div>
                             <p class="error text-danger direction-botones-center">{!!FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                            
                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-3 control-label"> Otros beneficios : <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!!Form::text("otros_beneficios",null,["class"=>"form-control","id"=>"otros_beneficios"])!!}
                               </div>
                             </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                    </div>

                    <div class="row" id="info-adicional">
                     <h3 class="header-section-form col-md-offset-3"> Descripción de sus intereses personales </h3>
                      <div class="col-sm-12 col-lg-12">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-2 control-label"> ¿Qué lo motiva para un cambio?: <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                         {!! Form::textarea("motivo_cambio",null,["class"=>"form-control" ,"id"=>"motivo_cambio","placeholder"=>"","maxlength"=>"5000"])!!}
                         <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("motivo_cambio",$errors)!!} </p>   
                       </div>
                      </div>
                     </div>

                       <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                         <label for="complemento" class="col-md-2 control-label"> Áreas de mayor interés en ámbito laboral : <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!! Form::textarea("areas_interes",null,["class"=>"form-control" ,"id"=>"areas_interes","placeholder"=>"","maxlength"=>"5000"])!!}
                          <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("areas_interes",$errors)!!} </p>
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> ¿Qué valora en un ambiente laboral?: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("ambiente_laboral",null,["class"=>"form-control" ,"id"=>"ambiente_laboral","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("ambiente_laboral",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
                        
                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Total ingreso anual / Total ingreso mensual: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("areas_interes",null,["class"=>"form-control" ,"id"=>"areas_interes","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("areas_interes",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
                         
                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Actividades de interés en su tiempo libre (hobbies): <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("hobbies",null,["class"=>"form-control" ,"id"=>"hobbies","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("hobbies",$errors)!!} </p>
                               </div>
                             </div>
                            </div>

                            <div class="col-sm-12 col-lg-12">
                             <div class="form-group">
                              <label for="genero" class="col-md-2 control-label"> Membresías colegios profesionales, asociaciones, clubes, etc.: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::textarea("membresias",null,["class"=>"form-control" ,"id"=>"membresias","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("membresias",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
                        </div>

                    <div class="row" id="info-adicional">
                     
                     <h3 class="header-section-form col-md-offset-3"> Descripción de su perfil profesional </h3>
                    
                      <div class="col-sm-12 col-lg-6">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-7 control-label"> Años de experiencia en el cargo de aplicación: <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!! Form::number("tiempo_experiencia",null,["class"=>"form-control" ,"id"=>"tiempo_experiencia","placeholder"=>""])!!}
                          <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("tiempo_experiencia",$errors)!!} </p>
                       </div>
                      </div>
                     </div>

                       <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                         <label for="complemento" class="col-md-6 control-label"> Conocimientos técnicos de mayor dominio : <span class='text-danger sm-text-label'>*</span></label>
                         <div class="col-md-10">
                          {!! Form::text("conoc_tecnico",null,["class"=>"form-control" ,"id"=>"conoc_tecnico","placeholder"=>"","maxlength"=>"5000"])!!}
                           <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("conoc_tecnico",$errors)!!} </p>
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-6 control-label"> Herramientas tecnológicas manejadas: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("herr_tecnologicas",null,["class"=>"form-control" ,"id"=>"herr_tecnologicas","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("herr_tecnologicas",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
                        
                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-8 control-label"> Principales fortalezas que considera tener para el cargo: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("fortalezas_cargo",null,["class"=>"form-control" ,"id"=>"fortalezas_cargo","placeholder"=>"","maxlength"=>"5000"])!!}
                                <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("fortalezas_cargo",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
                         
                            <div class="col-sm-12 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-7 control-label"> Áreas a reforzar para un mayor dominio del cargo: <span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-10">
                                {!! Form::text("areas_reforzar",null,["class"=>"form-control" ,"id"=>"areas_reforzar","placeholder"=>"","maxlength"=>"5000"])!!}
                                 <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("areas_reforzar",$errors)!!} </p>
                               </div>
                             </div>
                            </div>
							</div>
                 @endif

                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")

                    <div class="row" id="info-adicional">

                     <h3 class="header-section-form">Información Adicional(Opcional)</h3>
                    
                      <div class="col-sm-6 col-lg-6">
                       <div class="form-group">
                        <label for="telefono_fijo" class="col-md-5 control-label">Número de Teléfono Fijo:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-7">
                         {!! Form::text("telefono_fijo",null,["class"=>"form-control solo-numero" ,"id"=>"telefono_fijo" ,"placeholder"=>"Teléfono Fijo"]) !!}
                        </div>
                       </div>
                       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                      </div>

                       <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                         <label for="complemento" class="col-md-5 control-label">Dirección:</label>
                         <div class="col-md-7">
                            @if ($sitio->direccion_dian)
                                <?php
                                    $direccion_dian_candidato = $datos_basicos->getDireccionDian;
                                ?>
                                <input class="form-control" type="text" readonly="readonly" placeholder="" id="direccion" name="direccion" value="@if($direccion_dian_candidato != null && $direccion_dian_candidato != '') {{ $datos_basicos->direccion }}@endif"></input>
                            @else
                                {!! Form::text("direccion", null, ["class" => "form-control", "id" => "direccion", "placeholder" => ""]) !!}
                            @endif
                         </div>
                        </div>
                       </div>

                            <div class="col-sm-6 col-lg-6">
                             <div class="form-group">
                              <label for="genero" class="col-md-5 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>
                               <div class="col-md-7">
                                {!!Form::select("genero",$genero,null,["id"=>"genero","class"=>"form-control"])!!}
                                  </div>
                                </div>
                              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>

                            <div class="col-sm-6 col-lg-6">
                             <div class="form-group">
                              <label for="estado_civil" class="col-md-5 control-label">Estado Civil:<span class='text-danger sm-text-label'>*</span></label>
                              <div class="col-md-7">
                               {!! Form::select("estado_civil",$estadoCivil,null,["class"=>"form-control" ,"id"=>"estado_civil"]) !!}
                              </div>
                             </div>

                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_civil",$errors) !!}</p>
                            </div>

                            <div class="col-sm-6 col-lg-12">
                             <label> ¿De donde conoce a Komatsu? / Caracteres restantes: <span></span> </label>
                               {!!Form::textarea("conocenos",null,["maxlength"=>"550","class"=>"form-control",'rows' => 3,"id"=>"conocenos" ])!!}
                                <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("barrio",$errors) !!} </p>
                            </div>

                    </div>
                @endif
          </div>
                <div class="col-md-12 separador"></div>
                <p class="direction-botones-center set-margin-top">
                    <button class="btn btn-success pull-right" type="button" id="guardar_datos_basicos_admin" ><i class="fa fa-floppy-o"></i> Guardar</button>
                </p>
                <div id="container_tab"></div>
            
            {!! Form::close() !!}<!-- /.fin form -->

            {{--MODAL--}}
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
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            @if ($sitio->direccion_dian)
                <div class="modal fade" id="modal_direccion_dian" tabindex="-1" role="dialog" aria-labelledby="modalDireccionDian" aria-hidden="true">
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
                                                        <td style="width: 7%" class="pt-20 text-center">
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
                                                        <td style="width: 8%" class="pt-20 text-center">
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

            {{-- Upload video --}}
            @include('cv.includes.video_perfil._section_subir_video_perfil')

            {{-- Upload video css --}}
            <style>
                .video-upload {
                    background-color: #ffffff;
                    width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }

                @media (max-width: 991px) {
                    .video-upload {
                        width: 354px;
                    }

                    .file-upload-image {
                        width: 354px;
                    }
                }

                @media (max-width: 500px) {
                    .video-upload {
                        width: 300px;
                    }

                    .file-upload-image {
                        width: 354px;
                    }
                }

                @media (max-width: 440px) {
                    .video-upload {
                        width: 280px;
                    }

                    .file-upload-image {
                        width: 354px;
                    }
                }

                @media (max-width: 400px) {
                    .video-upload {
                        width: 255px;
                    }

                    .file-upload-image {
                        width: 354px;
                    }
                }

                @media (max-width: 340px) {
                    .video-upload {
                        width: 205px;
                    }

                    .file-upload-image {
                        width: 200px;
                    }
                }

                .file-upload-input {
                    position: absolute;
                    margin: 0;
                    padding: 0;
                    width: 100% !important;
                    height: 100% !important;
                    outline: none;
                    opacity: 0;
                    cursor: pointer;
                }

                .file-upload-content {
                    display: none;
                    text-align: center;
                }

                /* Drag and drop zone */
                .image-upload-wrap {
                    margin-top: 20px;
                    border: 4px dashed #b3b3b3;
                    position: relative;
                    transition: all 300ms ease;
                }

                .image-dropping, .image-upload-wrap:hover {
                    background-color: #b3b3b3;
                    border: 4px dashed #ffffff;
                }

                .drag-text {
                    font-weight: 500;
                    font-size: 1.5rem;
                    text-transform: uppercase;
                    color: black;
                    padding: 60px 0;
                }
                
                /* Preview video */
                .file-upload-image {
                    max-width: 480px;
                    max-height: 320px;
                    margin: auto;
                    padding: 20px;
                }
            </style>

        </div><!-- /.container -->
    </div><!-- /. container lefti -->
<!-- Script -->

{{-- Upload video js vars --}}
    <script>
        const videoAdmin = true
        const routeVideo = '{{ route("admin.guardar_video_descripcion") }}';
    </script>

    <script src="{{ asset('js/cv/video-perfil/cargar-video-perfil.js') }}"></script>
{{--  --}}

<script>
    $(function () {
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

        $('#hijos').change(function(){
 
            if ($(this).val() == 1){
                $('#numero_hijos').show();
            }else{
              if($(this).val() == 0){
                $('#numero_hijos').hide();
              }
            }
        })

        $('#conflicto').change(function(){
            /*if(!$(this).prop('checked')){
                $('.numero_hijos').hide();
            }else{
                $('.numero_hijos').show();
            }*/
            if($(this).val() == 1){

              $('#descripcion_conflicto').show();
            }else{
              
              if ($(this).val() == 0){
                $('#descripcion_conflicto').hide();
              }
            }
        })

       //$('#libreta_militar').hide();
       //$('.militar_situacion').parent('div').hide();

    //****************para tiempos *******************************////////
        genero();
        licencia();
        situacion_militar();
        vehiculo();
        grupoPoblacional();

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

        $(document).on("change", "#tiene_vehiculo", function () {
          $('#tipo_vehiculo').val('');
            vehiculo();
        });

        $(document).on("change", "[name='tiene_licencia']", function () {
                 licencia();
            $('[name="categoria_licencia"]').val('');
            $('[name="numero_licencia"]').val('');
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
            //alert();
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
            //alert();
          if($('[name="tiene_licencia"]').val() == 1){
         
            $('[name="categoria_licencia"]').parent('div').parent('div').show();
            $('[name="numero_licencia"]').parent('div').parent('div').show();
          }else{
         
            $('[name="categoria_licencia"]').parent('div').parent('div').hide();
            $('[name="numero_licencia"]').parent('div').parent('div').hide();
          }
        }

        function vehiculo(){
            //alert();
          if($('#tiene_vehiculo').val() == 1){
          $('#tipo_vehiculo').parent('div').parent('div').show();
          }else{
          $('#tipo_vehiculo').parent('div').parent('div').hide();
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
            //console.log(value);
            if( value == 1) {
                //alert('seleci');
                //console.log('cambiar');
              $('#libreta_militar').show();
            }else{
             // console.log('no cambiar');
             //alert('no select');
              $('#libreta_militar').hide();
            }
        }

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

        //Formato fecha
        $("#fecha_expedicion, #fecha_nacimiento").datepicker(confDatepicker);


        $('#txt_nacimiento').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_nacimiento").val(suggestion.cod_pais);
                $("#departamento_nacimiento").val(suggestion.cod_departamento);
                $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
            }
        });

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                //console.log($("#departamento_id").html());
                $("#pais_id_exp").val(suggestion.cod_pais);
                $("#departamento_id_exp").val(suggestion.cod_departamento);
                $("#ciudad_id_exp").val(suggestion.cod_ciudad);
            }
        });
        
        $('#txt_residencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_residencia").val(suggestion.cod_pais);
                $("#departamento_residencia").val(suggestion.cod_departamento);
                $("#ciudad_residencia").val(suggestion.cod_ciudad);
            }
        });
        
        $(document).on("change", ".direccion", function () {
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
            $("#direccion").val(txtConcat);
        });

        $(document).on("keyup", ".direccion_txt", function () {
            var txtConcat = "";
            var campos = $(".direccion");
            $("#direccion").val("");
            $.each(campos, function (key, value) {
                var campos = $(value);
                var type = campos.attr("type");
                if (type == "checkbox") {
                    if(campos.prop("checked")) {
                      txtConcat += campos.val() + " ";
                    }
                } else {
                    txtConcat += campos.val() + " ";
                }

            })
            $("#direccion").val(txtConcat);
        });

        
        $("#guardar_datos_basicos_admin").on("click", function () {

          $("#guardar_datos_basicos_admin").prop('disabled','disabled');

          var formData = new FormData(document.getElementById("fr_datos_basicos"));
            $.ajax({

                type: "POST",
                data: formData,
                url: "{{route("admin.ajax_actualizar_datos_basicos",$user_id)}}",
               
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                 $("#guardar_datos_basicos_admin").prop('disabled',false);
                  $("#container_tab").html(response.view);
                  mensaje_success("Datos Basicos Guardados");
                },
                error:function(data){
                  
                  $("#guardar_datos_basicos_admin").prop('disabled',false);
                    $(document).ready(function(){
                        $("#fr_datos_basicos input").css({"border": "1px solid #ccc"});
                        $("#fr_datos_basicos select").css({"border": "1px solid #ccc"});
                        $("#fr_datos_basicos .text").remove();
                    });
                      //  var nombres = $("#nombres").val();
                        $.each(data.responseJSON, function(index, val){
                          // document.getElementById(index).style.border = 'solid red';
                         $('#fr_datos_basicos input[name='+index+']').css({"border": "1px solid red"}).after('<span class="text">'+val+'</span>');
                         $('#fr_datos_basicos select[name='+index+']').css({"border": "1px solid red"}).after('<span class="text">'+val+'</span>');

                            if(index === "ciudad_residencia"){
                             $('#fr_datos_basicos input[name="txt_residencia"]').css({"border": "1px solid red"}).after('<span class="text">'+val+'</span>');
                            }

                            if(index === "ciudad_nacimiento"){
                             $('#fr_datos_basicos input[name="txt_nacimiento"]').css({"border": "1px solid red"}).after('<span class="text">'+val+'</span>');
                            }
                            
                            if(index === "ciudad_expedicion_id"){
                             $('#fr_datos_basicos input[name="ciudad_autocomplete"]').css({"border": "1px solid red"}).after('<span class="text">'+val+'</span>');
                            }
                        
                        });

                        mensaje_danger("Upps, olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                }
            });
        });
    });

</script>

<hr>

{{-- ESTUDIOS --}}
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="container_estudios">
            {!! Form::open(["route"=>"admin.hv_actualizada", "class"=>"form-horizontal form-datos-basicos", "role"=>"form", "id"=>"fr_estudios", "files" => true]) !!}
              {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
              {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
              {!! Form::hidden("id",null,["class"=>"id_modificar_datos", "id"=>"id_modificar_datos"]) !!}

                <div class="row">
                 <h3 class="header-section-form">
                  {{(route('home') == "https://gpc.t3rsc.co")?'Formacion Academica':'Mis Estudios'}} <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span> </h3>
        
                    <div class="col-md-12">
                     <p class="text-primary set-general-font-bold">
                      Por favor relacione todos los estudios realizados, empezando por el más reciente.
                      Para incluir otro estudio; llene los campos y haga clic en el botón "Guardar".
                     </p>
                        <p class="direction-botones-left">
                         <a href="#grilla_datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp; {{(route('home') == "https://gpc.t3rsc.co")?'Formacion Academica':'Mis Estudios'}} </a>
                        </p>
                    </div>

                    <div class="col-md-12">
                        <div id="no_tengo" class="col-md-12 mb-4" style="margin-bottom: 15px;">
                            <label>
                                {!! Form::checkbox("tiene_estudio",0,isset($datos_basicos->tiene_estudio) && $datos_basicos->tiene_estudio == "0" ? 1 : null,["class"=>"tiene_estudio","id"=>"tiene_estudio", "style" => "height:initial;"]) !!}
                                        No tengo estudios certificados</label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="trabajo-empresa-temporal" class="col-md-5  control-label">
                                ¿Estudio actual?
                            </label>
                            <div class="col-md-7">
                                {!! Form::select("estudio_actual",["0" => "No", "1" => "Si"],null,["class"=>"form-control","id"=>"estudio_actual"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="nombre_empresa_temporal" class="col-md-5 control-label">Institución:<span class='text-danger sm-text-label'>*</span> </label>
                            
                            <div class="col-md-7">
                             {!! Form::text("institucion",null,["class"=>"form-control","placeholder"=>"Institución", "id"=>"institucion" ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="titulo_obtenido" class="col-md-5 control-label">Titulo obtenido: <span class='text-danger sm-text-label'> * </span> </label>
                            <div class="col-md-7">
                                {!! Form::text("titulo_obtenido",null,["class"=>"form-control", "id"=>"titulo_obtenido","placeholder"=>"Titulo Obtenido"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                          <label class="col-md-5 control-label"> Ciudad estudio:  <span class="text-danger sm-text-label">*</span> </label>
                          
                            {!! Form::hidden("pais_estudio",null,["class"=>"form-control","id"=>"pais_estudio"]) !!}
                            {!! Form::hidden("ciudad_estudio",null,["class"=>"form-control","id"=>"ciudad_estudio"]) !!}
                            {!! Form::hidden("departamento_estudio",null,["class"=>"form-control","id"=>"departamento_estudio"]) !!}
                            
                            <div class="col-md-7">
                             {!!Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete_estu","placheholder"=>"Digita Cuidad"])!!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="tipo_id" class="col-md-5 control-label">Nivel Estudios: <span class='text-danger sm-text-label'>*</span> </label>
                            
                        <div class="col-md-7">
                         {!!Form::select("nivel_estudio_id",$nivelEstudios,null,["class"=>"form-control", "id"=>"nivel_estudio_id" ]) !!}
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="semestres_cursados" class="col-md-5 control-label"> Períodos cursados:</label>
                                
                            <div class="col-md-7">
                                {!! Form::select("semestres_cursados",[""=>"Seleccionar",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],null,["class"=>"form-control", "id"=>"semestres_cursados" ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label">
                                Períodicidad:   
                            </label>
                            <div class="col-md-7">
                                {!! Form::select("periodicidad",$periodicidad,null,["class"=>"form-control","id"=>"periodicidad"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="fecha_finalizacion" class="col-md-5 control-label">Fecha Inicio:  <span class='text-danger sm-text-label'>*</span> </label>
                            
                            <div class="col-md-7">
                               {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="fecha_finalizacion" class="col-md-5 control-label">Fecha Finalización:  <span class='text-danger sm-text-label'> </span> </label>
                            
                            <div class="col-md-7">
                             @if(route('home') != "https://gpc.t3rsc.co")
                               {!! Form::text("fecha_finalizacion",null,["class"=>"form-control","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion" ]) !!}
                             @else
                               {!! Form::date("fecha_finalizacion",null,["max"=>date('Y-m-d'),"class"=>"form-control","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion" ]) !!} 
                             @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="nombre_empresa_temporal" class="col-md-5 control-label">Acta:<span class='text-danger sm-text-label'></span> </label>
                            
                            <div class="col-md-7">
                             {!! Form::text("acta",null,["class"=>"form-control","placeholder"=>"Acta", "id"=>"acta" ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="nombre_empresa_temporal" class="col-md-5 control-label">Folio:<span class='text-danger sm-text-label'></span> </label>
                            
                            <div class="col-md-7">
                             {!! Form::text("folio",null,["class"=>"form-control","placeholder"=>"Folio", "id"=>"folio" ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 separador"></div>
                
                <p class="direction-botones set-margin-top">
                    <button class="btn btn-warning pull-right" type="button" id="cancelar_estudios" style="display:none; margin: auto 10px auto;"><i class="fa fa-pen"></i>&nbsp;Cancelar</button>
                    
                    <button class="btn btn-success pull-right" type="button" id="actualizar_estudios" style="display:none; margin: auto 10px auto;"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button> 

                    <button class="btn btn-success pull-right" type="button" id="guardar_estudios"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                </p>

                <div class="col-md-12 separador"></div>
            {!! Form::close() !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! Form::open(["id"=>"grilla_datos_estudio"]) !!}
                    <div class="grid-container table-responsive">
                        <table class="table table-striped table-bordered" id="tbl_estudios">
                            <thead>
                                <tr>
                                 <th>Titulo Obtenido</th>
                                 <th>Institución</th>
                                 <th>Nivel Estudio</th>
                                    
                                 @if(route('home') != "https://gpc.t3rsc.co")
                                  <th>Estudio Actual</th>
                                 @endif

                                    <th>Fecha Finalización</th>
                                    
                                    @if(route('home') == "https://gpc.t3rsc.co")
                                        <th>Estatus</th>
                                    @endif
                                    
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @if($estudios->count() == 0)
                                    <tr id="registro_nulo">
                                        <td colspan="6">No  hay registros</td>
                                    </tr>
                                @endif

                                @foreach($estudios as $estudio)
                                    <tr id="tr_{{$estudio->id}}" >
                                      <td>{{ $estudio->titulo_obtenido }}</td>
                                      <td>{{ $estudio->institucion }}</td>
                                      <td>{{ $estudio->descripcion_nivel }}</td>
                                      @if(route('home') != "https://gpc.t3rsc.co")
                                       <td>{{ (($estudio->estudio_actual==1)?"SI":"NO") }}</td>
                                      @endif
                                        <td>{{ $estudio->fecha_finalizacion }}</td>
                                        @if(route('home') == "https://gpc.t3rsc.co")
                                            <td>{{$estudio->estatus_academico}}</td>
                                        @endif
                                        <td>
                                        {!!Form::hidden("id",$estudio->id, ["id"=>$estudio->id])!!}
                                            <button type="button" class="btn btn-info btn-peq certificados_estudios"  title="Certificados"><i class="fa fa-file-text-o"></i>&nbsp;Certificados</button>
                                          <button type="button" class="btn btn-primary btn-peq editar_estudio_p disabled_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                                          <button type="button" class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
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
<!-- Fin contenido principal -->
<script>
    $(function () {

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
            onClose: function(dateText, inst){ 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));

            }
           }
     
        @else

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

        @endif
    
        //Formato fecha
        $("#fecha_inicio, #fecha_finalizacion").datepicker(confDatepicker);

        $('#ciudad_autocomplete_estu').autocomplete({
          serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
          autoSelectFirst: true,
          onSelect: function (suggestion){
           $("#error_ciudad").hide();
           $(this).css("border-color","rgb(210,210,210)");
           $("#pais_estudio").val(suggestion.cod_pais);
           $("#departamento_estudio").val(suggestion.cod_departamento);
           $("#ciudad_estudio").val(suggestion.cod_ciudad);
          }
        });

        //Guardar Estudio Nuevo--------------------------------------------------------------------------
        $(document).on("click","#guardar_estudios", function () {
           $("#guardar_estudios").prop('disabled','disabled');
           var formData = new FormData(document.getElementById("fr_estudios"));
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{route('admin.ajax_guardar_estudios')}}",
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                  $("#guardar_estudios").prop('disabled',false);
                    if (response.success) {

                        if( response.tiene_estudio ){

                          $(document).ready(function(){
                           $("input").css({"border": "1px solid #ccc"});
                           $("select").css({"border": "1px solid #ccc"});
                          });

                            var nivel = response.pr;
                            var campos = response.rs;
                            
                            var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                            tr.append($("<td></td>", {text: campos.titulo_obtenido}));
                            tr.append($("<td></td>", {text: campos.institucion}));
                            tr.append($("<td></td>", {text: nivel.descripcion_nivel }));
                           @if(route('home') != "https://gpc.t3rsc.co")
                            tr.append($("<td></td>", {text: ((campos.estudio_actual == 1) ? "SI" : "NO")}));
                           @endif
                            tr.append($("<td></td>", {text: campos.fecha_finalizacion}));
                           @if(route('home') == "https://gpc.t3rsc.co")
                            tr.append($("<td></td>", {text: campos.estatus_academico}));
                           @endif
                            tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-info btn-peq certificados_estudios"  title="Certificados"><i class="fa fa-file-text-o"></i>&nbsp;Certificados</button><button type="button" class="btn btn-primary btn-peq editar_estudio_p disabled_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                            $("#tbl_estudios tbody").append(tr);
                            $("#registro_nulo").remove();
                            mensaje_success(response.mensaje_success);
                            //Limpiar campos del formulario
                            $("#fr_estudios")[0].reset();
                        }else{
                            $("#tbl_estudios tbody > tr").remove();
                            mensaje_success(response.mensaje_success);
                        }
                    }else{
                      if(response.errors){
                       //Busca todos los input y lo pone a su color original
                       $(document).ready(function(){
                         $("input").css({"border": "1px solid #ccc"});
                         $("select").css({"border": "1px solid #ccc"});
                       });
                        //Recorrer el errors y cambiar de color a los input reqeuridos
                        $.each(response.errors,function(key,value){
                           //Cambiar color del borde a color rojo
                           if(key == 'ciudad_estudio'){
                                document.getElementById("ciudad_autocomplete_estu").style.border = 'solid red';
                           }else{
                                document.getElementById(key).style.border = 'solid red';
                           }
                        });
                      }
                        
                        mensaje_danger(response.mensaje_success);
                    }
                }
            });
        });

        //Editar Estudio--------------------------------------------------------------------------------
        $(document).on("click",".editar_estudio_p", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_estudios').style.display = 'block';
            document.getElementById('actualizar_estudios').style.display = 'block';
            //Ocultar Boton Guardar
            document.getElementById('guardar_estudios').style.display = 'none';
            //Desactivar botones editar + eliminar.
            $(".disabled_estudio").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
                if(id){
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_editar_estudio')}}",
                    success: function (response) {
                        $("#institucion").val(response.data.institucion);
                        $("#nivel_estudio_id").val(response.data.nivel_estudio_id);
                        $("#titulo_obtenido").val(response.data.titulo_obtenido);
                        $("#fecha_inicio").val(response.data.fecha_inicio);
                        $("#fecha_finalizacion").val(response.data.fecha_finalizacion);
                       @if(route('home') != "https://gpc.t3rsc.co")
                        $("#semestres_cursados").val(response.data.semestres_cursados);
                       @else
                        $("#estatus_academico").val(response.data.estatus_academico);
                       @endif
                        $(".id_modificar_datos").val(response.data.id);
                        if(response.data.termino_estudios == true){
                          $("#termino_estudios").prop("checked", true);
                        }else{
                          $("#termino_estudios").prop("checked", false);
                        }

                        if(response.data.estudio_actual == true){
                          $("#estudio_actual").prop("checked", true);
                        }else{
                          $("#estudio_actual").prop("checked", false);
                        }

                        $("#acta").val(response.data.acta);
                        $("#folio").val(response.data.folio);
                    }
                });
            }else{
              mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Eliminar Estudio--------------------------------------------------------------------------------
        $(document).on("click",".eliminar_estudio_p", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            if(id){
             
             if(confirm("Desea eliminar este registro?")){
               $(".disabled_estudio").prop("disabled", true);
               
               $.ajax({
                 type: "POST",
                 data: {"id":id},
                 url: "{{route('admin.ajax_eliminar_estudio')}}",
                success: function (response) {
                  $("#tr_" + response.id).remove();
                  mensaje_success("Registro eliminado.");
                  $(".disabled_estudio").prop("disabled", false);
                }
               });
             }
                
            }else{
              
              mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });
        
        //Cancelar Estudio----------------------------------------------------------------------------------
        $("#cancelar_estudios").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_estudios').style.display = 'none';
            document.getElementById('actualizar_estudios').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_estudios').style.display = 'block';
            //Activar botones editar + eliminar
            $(".disabled_estudio").prop("disabled", false);

            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_datos").val();

            if (id) {
                $("#fr_estudios")[0].reset();
            }else{
                mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
            }
        });

        //Actualizar Estudio---------------------------------------------------------------------------------
        $(document).on("click","#actualizar_estudios", function() {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_estudios').style.display = 'none';
            document.getElementById('actualizar_estudios').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_estudios').style.display = 'block';
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_datos").val();
            if (id) {
                var formData = new FormData(document.getElementById("fr_estudios"));
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{route('admin.ajax_actualizar_estudio')}}",
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            $("#fr_estudios")[0].reset();
                            mensaje_success("Registro actualizado.");
                            $(".disabled_estudio").prop("disabled", false);

                            var campos = response.estudios;
                            $("#tr_" + campos.id + "").removeClass("oferta_aplicada");
                            var tr = $("#tr_" + campos.id + "").find("td");

                            tr.eq(0).html(campos.titulo_obtenido);
                            tr.eq(1).html(campos.institucion);
                            tr.eq(2).html(campos.nivelEstudios.descripcion);
                            tr.eq(3).html(((campos.estudio_actual == 1) ? "SI" : "NO"));
                            tr.eq(4).html(campos.fecha_finalizacion);
                            tr.eq(5).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_estudio_p disabled_estudio"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));
                        }
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                $(".disabled_estudio").prop("disabled", false);

            }
        });

        $(".certificados_estudios").on("click", function () {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('certificados_estudios') }}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
            }
        });

    });
</script>
<!-- Fin Estudios -->
<hr>
<!-- Inicio Experiencia -->
<!-- Inicio contenido principal -->
<div class="col-right-item-container">
  <div class="container-fluid">
    <div id="fr_container_experiencia">
     {!! Form::open(["class"=>"form-horizontal form-datos-basicos", "role"=>"form", "id"=>"fr_datos_experiencia"]) !!}

        {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
        {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}

        {!! Form::hidden("id",null,["class"=>"id_modificar_experiencia", "id"=>"id_modificar_experiencia"]) !!}

            <div class="row">
              <h3 class="header-section-form"> @if(route("home") != "https://gpc.t3rsc.co") Experiencia Laboral @else Empleos Anteriores @endif <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                 <p class="text-primary set-general-font-bold">
                  Por favor relacione todas sus experiencias laborales, empezando por su trabajo más reciente.
                  Para incluir otra experiencia laboral; llene los campos y haga clic en el botón "Guardar".
                 </p>
                 <p class="direction-botones-left">
                  <a href="#grilla" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Experiencias</a>
                 </p>
                </div>

                <div class="col-md-12">
                    <div id="no_tengo" class="col-md-12 mb-4">
                        <label>
                            {!! Form::checkbox("tiene_experiencia",0,isset($datos_basicos->tiene_experiencia) && $datos_basicos->tiene_experiencia == "0" ? 1 : null,["class"=>"tiene_experiencia","id"=>"tiene_experiencia", "style" => "height:initial;"]) !!}
                                    No tengo experiencia</label>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="numero_id" class="col-md-5 control-label">Nombre Empresa:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("nombre_empresa",null,["class"=>"form-control","placeholder"=>"Nombre Empresa", "id"=>"nombre_empresa"]) !!}
                   </div>
                    <p class="error text-danger direction-botones-center"></p>
                 </div>
                </div>

              @if(route('home') != "https://gpc.t3rsc.co")
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="numero_id" class="col-md-5 control-label"> Teléfono empresa: </label>
                    <div class="col-md-7">
                     {!! Form::text("telefono_temporal",null,["class"=>"form-control", "id"=>"telefono_temporal", "placeholder"=>"Teléfono empresa"]) !!}
                    </div>
                  </div>
                </div>
              @endif

              @if(route('home') != "https://gpc.t3rsc.co")
                <div class="col-sm-6 col-lg-6">                  
                  <div class="form-group">
                    <label for="ciudad_residencia" class="col-md-5 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">

                      {!! Form::hidden("pais_id",null,["id"=>"pais_id_res"]) !!}
                      {!! Form::hidden("departamento_id",null,["id"=>"departamento_id_res"]) !!}
                      {!! Form::hidden("ciudad_id",null,["id"=>"ciudad_id_res"]) !!}
                      {!! Form::text("autocompletado_residencia",null,["id"=>"autocompletado_residencia","class"=>"form-control","placeholder"=>"Digita cuidad"]) !!}
                    </div>
                  </div>    
                </div>

              @endif

              {{--@if(route('home') == "https://gpc.t3rsc.co")--}}
               
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="cargo_especifico" class="col-md-5 control-label">Cargo Desempeñado:<span class='text-danger sm-text-label'>*</span></label>
                     <div class="col-md-7">
                      {!! Form::text("cargo_especifico",null,["class"=>"form-control","id"=>"cargo_especifico","placeholder"=>"Cargo Específico"]) !!}
                     </div>
                  </div>
                </div>

              {{--@endif--}}
               
               @if(route('home') != "https://gpc.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label class="col-md-5 control-label">
                    Nivel Cargo @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Lavel Charge @endif :

                    @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span class='text-danger sm-text-label'>*</span> @endif
                 </label>
                 <div class="col-md-7">
                   @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
                    {!! Form::select("nivel_cargo",[""=>"Seleccionar","Operativo"=>"Operativo","Comercial"=>"Comercial","Medio"=>"Medio","Profesional"=>"Profesional","Directivo"=>"Directivo"],null,["class"=>"form-control", "id"=>"nivel_cargo"]) !!}
                   @else

                   {!! Form::select("nivel_cargo",[""=>"Seleccionar","Operativo"=>"Operativo","Directivo"=>"Directivo","Asesor"=>"Asesor","Profesional"=>"Profesional","Técnico"=>"Técnico","Asistencial"=>"Asistencial"],null,["class"=>"form-control", "id"=>"nivel_cargo"]) !!}

                   @endif
                 </div>
                 </div>
                </div>

             @endif

            @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")

              <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                 <label for="tipo_id" class="col-md-5 control-label"> @if(route('home') != "https://gpc.t3rsc.co") Cargo Similar @else Cargo Generico @endif : <span class='text-danger sm-text-label'>*</span></label>
                 <div class="col-md-7">
                  {!! Form::select("cargo_desempenado",$cargoGenerico,null,["class"=>"form-control","id"=>"cargo_desempenado"]) !!}
                 </div>
                </div>
              </div>

            @endif

            @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="nombres_jefe" class="col-md-5 control-label"> @if(route('home') != "https://gpc.t3rsc.co") Nombres Jefe: <span class='text-danger sm-text-label'>*</span> @else Nombre del Supervisor @endif </label>
                   <div class="col-md-7">
                    {!! Form::text("nombres_jefe",null,["class"=>"form-control", "id"=>"nombres_jefe","placeholder"=>"Nombres Jefe Inmediato"]) !!}
                   </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="cargo_jefe" class="col-md-5 control-label"> @if(route('home') != "https://gpc.t3rsc.co") Cargo Jefe: @else Cargo Supervisor : @endif <span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-7">
                     {!! Form::text("cargo_jefe",null,["class"=>"form-control","id"=>"cargo_jefe", "placeholder"=>"Cargo Jefe Inmediato" ]) !!}
                    </div>
                   </div>
                </div>
               
               @if(route('home') == "https://gpc.t3rsc.co")
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="lereportan" class="col-md-5 control-label"> Le reportan:<span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::text("le_reportan",null,["class"=>"form-control", "placeholder"=>"le_reportan","id"=>"le_reportan"]) !!}
                    </div>
                  </div>
                </div>
               @endif
              
              @if(route('home') != "https://gpc.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="telefono_movil_jefe" class="col-md-5 control-label">Teléfono móvil jefe:<span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::text("movil_jefe",null,["class"=>"form-control solo-numero", "placeholder"=>"Movil Jefe Inmediato","id"=>"telefono_movil_jefe"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="telefono_jefe" class="col-md-5 control-label">Teléfono Fijo Jefe:<span class='text-danger sm-text-label'></span> </label>
                    
                    <div class="col-md-4">
                     {!! Form::text("fijo_jefe",null,["class"=>"form-control solo-numero", "id"=>"telefono_jefe", "placeholder"=>"Teléfono Jefe Inmediato"]) !!}
                    </div>
                    <div class="col-md-3">
                      {!! Form::text("ext_jefe",null,["class"=>"form-control solo-numero", "id"=>"ext_jefe", "placeholder"=>"Extension Fijo"]) !!}
                    </div>
                  </div>
                </div>
              @endif
            @endif

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="fecha_inicio" class="col-md-5 control-label"> @if(route('home') == "https://gpc.t3rsc.co") Fecha ingreso @else Fecha Inicio @endif:<span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!! Form::text("fecha_inicio",null,["class"=>"form-control", "id"=>"fecha_inicio" ,"placeholder"=>"Fecha Inicio"]) !!}
                  </div>
                 </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                   <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Trabajo Actual:</label>
                    <div class="col-md-7">
                      {!!Form::select("empleo_actual",[''=>"Seleccione", '1' => "Si", '2' => "No"], null, ["class" => "form-control empleo_actual", "id" => "empleo_actual"])!!}
                   </div>
                 </div>
                </div>

                <div class="ocultar col-sm-6 col-lg-6">
                 <div class="form-group">
                   <label for="fecha_terminacion" class="col-md-5 control-label"> @if(route('home') == "https://gpc.t3rsc.co") Fecha salida @elseif(route("home")=="https://humannet.t3rsc.co") Fecha Culminación @else  Fecha Terminación @endif :<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("fecha_final",null,["class"=>"form-control", "id"=>"fecha_final" ,"placeholder"=>"Fecha Terminación"]) !!}
                   </div>
                 </div>
                </div>

                <div id="arned_salary">
                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="salario_devengado" class="col-md-5 control-label">@if(route('home') == "https://gpc.t3rsc.co") Último salario @elseif(route("home")=="https://humannet.t3rsc.co") Sueldo líquido @else Salario Devengado @endif :<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    @if(route('home') == "http://localhost:8000" || route('home') == "https://demo.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                      {!!Form::text("salario_devengado",null,["class"=>"form-control input-number" ,"id"=>"salario_devengado","min"=>"1","placeholder"=>""])!!}
                     @else
                      {!!Form::select("salario_devengado",$aspiracionSalarial,null,["class"=>"form-control" ,"id"=>"salario_devengado"])!!}
                     @endif
                   </div>
                 </div>
                </div>
                
                <div class="col-sm-6 col-lg-6" id="motivo_r">
                  <div class="form-group">
                    <label for="motivo_retiro" class="col-md-5 control-label"> @if(route('home') == "https://gpc.t3rsc.co") Motivo de salida de la empresa @else Motivo Retiro @endif :<span class='text-danger sm-text-label'>*</span></label>
                     <div class="col-md-7">
                      {!! Form::select("motivo_retiro",$motivos,null,["class"=>"form-control","id"=>"motivo_retiro"]) !!}
                     </div>
                  </div>
                </div>

                </div>

            @if(route('home') == "https://gpc.t3rsc.co")
              
               <div id="actual_show">
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label">Sueldo fijo bruto:<span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("sueldo_fijo_bruto", null, ["class" => "form-control", "id" => "sueldo_fijo_bruto", "autofocus"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Ingreso variable mensual (comisiones/bonos): <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("ingreso_varial_mensual", null, ["class" => "form-control", "id" => "ingreso_varial_mensual"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Otros bonos (monto y periodicidad): <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("otros_bonos", null, ["class" => "form-control", "id" => "otros_bonos"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Total ingreso anual: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("total_ingreso_anual", null, ["class" => "form-control", "id" => "total_ingreso_anual"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Total ingreso mensualizado: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                      {!! Form::number("total_ingreso_mensual", null, ["class" => "form-control", "id" => "total_ingreso_mensual"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Utilidades (individual y carga): <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("utilidades", null, ["class" => "form-control", "id" => "utilidades"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Valor actual fondos de reserva: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!! Form::number("valor_actual_fondos", null, ["class" => "form-control", "id" => "valor_actual_fondos"]) !!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label"> Beneficios no monetarios: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                    {!! Form::text("beneficios_monetario", null, ["class" => "form-control", "id" => "beneficios_monetario"]) !!}
                    </div>
                  </div>
                </div>

              </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="linea_negocio" class="col-md-5 control-label">Linea Negocio:<span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!!Form::text("linea_negocio",null,["class"=>"form-control","id"=>"linea_negocio","placeholder"=>"Linea Negocio"])!!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="tipo_compania" class="col-md-5 control-label"> Tipo Compañia: <span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!! Form::select("tipo_compania",[''=>"seleccione",'nacional'=>"Nacional",'transnacional'=>"Transnacional",'multinacional'=>"Multinacional"],null,["class"=>"form-control","id"=>"tipo_compania"]) !!}
                   </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="ventas_empresa" class="col-md-5 control-label"> Ventas anuales de la empresa: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!!Form::number("ventas_empresa",null,["class"=>"form-control","id"=>"ventas_empresa"])!!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="num_colaboradores" class="col-md-5 control-label"> Numero de colaboradores de la empresa: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!!Form::number("num_colaboradores",null,["class"=>"form-control","id"=>"num_colaboradores"])!!}
                    </div>
                  </div>
                </div>
              @if(route('home') == "http://localhost:8000")
              
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="otro_cargo" class="col-md-5 control-label"> Otro cargo desempeñado: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!!Form::text("otro_cargo",null,["class"=>"form-control","id"=>"otro_cargo"])!!}
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="tiempo_cargo" class="col-md-5 control-label"> Tiempo del cargo: <span class='text-danger sm-text-label'></span> </label>
                    <div class="col-md-7">
                     {!!Form::text("tiempo_cargo",null,["class"=>"form-control","id"=>"tiempo_cargo"])!!}
                    </div>
                  </div>
                </div>

              @endif

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="funciones_logros" class="col-md-5 control-label"> Funciones (al menos 5 funciones específicas): <span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-7">
                     {!! Form::textarea("funciones_logros",null,["maxlength"=>"550","class"=>"form-control","rows"=> 3, "placeholder"=>"Escribe acá tu funciones.  Máximo 550 caracteres", "id"=>"funciones_logros"])!!}
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="logros" class="col-md-5 control-label"> Logros: <span class='text-danger sm-text-label'>*</span></label>
                    <div class="col-md-7">

                     {!! Form::textarea("logros",null,["maxlength"=>"550","class"=>"form-control","rows"=> 3, "placeholder"=>"Escribe acá tus logros. Máximo 550 caracteres","id"=>"logros"])!!}

                    </div>
                  </div>
                </div>

            @endif

            @if(route('home') != "https://gpc.t3rsc.co")

                <div id="funciones" class="col-sm-6 col-lg-12">
                  <div class="form-group">
                   <label for="funciones_logros" class="col-md-3 control-label">Funciones y Logros: <span class='text-danger sm-text-label'></span></label>
                    <div class="col-md-9">
                     {!!Form::textarea("funciones_logros",null,["class"=>"form-control", "rows"=>"3", "name"=>"funciones_logros", "id"=>"funciones_logros"]) !!}
                    </div>
                    
                   <p class="error text-danger direction-botones-center"></p>
                 </div>
                </div>

            @endif

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <div class="col-md-3">
                    {!! Form::hidden("autoriza_solicitar_referencias",1,null,["class"=>"checkbox-preferencias" ,"data-state"=>"false" , "id"=>"autorizo_referencia"]) !!}
                   </div>
                 </div>
                </div>

            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-warning pull-right" type="button" id="cancelar_experiencia" style="display:none; margin: auto 10px auto;"><i class="fa fa-pen"></i>&nbsp;Cancelar</button>
                 <button class="btn btn-success pull-right" type="button" id="actualizar_experiencia" style="display:none; margin: auto 10px auto;"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button> 

                <button class="btn btn-success pull-right" type="button" id="guardar_experiencias" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>
            {!! Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla_datos_experiencia"]) !!}
                
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="tbl_experiencias">
                        <thead>
                          <tr>
                            <th>Empresa</th>
                          @if(route('home') != "https://gpc.t3rsc.co")
                           <th>Teléfono Empresa</th>
                          @endif
                            @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")
                             <th>Nombres @if(route('home') != "https://gpc.t3rsc.co") Jefe Inmediato @else Supervisor @endif </th>
                             <th>Teléfono Fijo</th>
                             <th>Teléfono Móvil</th>
                             <th>Cargo @if(route('home') == "https://gpc.t3rsc.co") Supervisor @endif </th>
                            @endif
                             <th>Fecha Ingreso</th>
                             <th>Fecha Salida</th>
                             <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($experiencias->count() == 0)
                            <tr id="registro_nulo">
                              <td colspan="9">No hay registros</td>
                            </tr>
                            @endif
                            @foreach($experiencias as $experiencia)
                            <tr id="tr_{{$experiencia->id}}">
                             
                             <td> {{$experiencia->nombre_empresa}} </td>
                             @if(route('home') != "https://gpc.t3rsc.co")
                              <td> {{$experiencia->telefono_temporal}} </td>
                             @endif
                              
                              @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

                               <td>{{$experiencia->nombres_jefe}}</td>
                               <td>{{$experiencia->fijo_jefe}}</td>
                               <td>{{$experiencia->movil_jefe}}</td>
                               <td>{{$experiencia->cargo_jefe}}</td>
                              
                              @endif

                                <td>{{$experiencia->fecha_inicio}}</td>
                                <td>{{$experiencia->fecha_final}}</td>
                                <td>
                                 {!!Form::hidden("id",$experiencia->id, ["id"=>$experiencia->id])!!}
                                <button type="button" class="btn btn-info btn-peq certificados_experiencias"  title="Certificados"><i class="fa fa-file-text-o"></i>&nbsp;Certificados</button>
                                 <button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button>

                                 <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>                                
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!-- /.container -->
</div>
<!-- Fin contenido principal -->
<!-- Script -->
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

         @if(route('home') == "https://gpc.t3rsc.co")
          $('#arned_salary').hide();
         @else
          $('#motivo_r').hide();
         @endif

        }else{
         $('.ocultar').show();
         $('#actual_show').hide();
         @if(route('home') == "https://gpc.t3rsc.co")
          $('#arned_salary').show();
         @else
          $('#motivo_r').show();
         @endif
        }
     });

    @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")

        $('#funciones').hide();

        $('#nivel_cargo').change(function(){

          var valor = $(this).val();
           
           if(valor == "Operativo"){
           
            $('#funciones').hide();

           }else{
            $('#funciones').show();
           }
  
        })

     @endif

      @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")
      
          var confDatepicker = {
            closeText: 'Seleccionar',
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
            maxDate: '+0d',
            onClose: function(dateText, inst){ 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));

            }
           }
     
    @else

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
            maxDate: '+0d',
            yearRange: "1930:2050"
        };

    @endif
        //Formato fecha
        $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);
        //Guardar Experiencia-----------------------------------------------------------------------------
        $("#guardar_experiencias").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_datos_experiencia").serialize(),
                url: "{{route('admin.ajax_guardar_experiencia')}}",
                success: function (response) {

                 $('#registro_nulo').remove();

                   if(response.success){
                    if ( response.tiene_experiencia ) {
                        //Busca todos los input y lo pone a su color original
                       $(document).ready(function(){
                         $("input").css({"border": "1px solid #ccc"});
                         $("select").css({"border": "1px solid #ccc"});

                       });

                        var campos = response.rs;
                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                        tr.append($("<td></td>", {text: campos.nombre_empresa}));
                      @if(route('home') != "https://gpc.t3rsc.co")
                       tr.append($("<td></td>", {text: campos.telefono_temporal}));
                      @endif
                      
                      @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

                        tr.append($("<td></td>", {text: campos.nombres_jefe}));
                        tr.append($("<td></td>", {text: campos.movil_jefe}));
                        tr.append($("<td></td>", {text: campos.fijo_jefe}));
                        tr.append($("<td></td>", {text: campos.cargo_jefe}));
                      @endif

                        tr.append($("<td></td>", {text: campos.fecha_inicio}));
                        tr.append($("<td></td>", {text: campos.fecha_final}));
                        tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-info btn-peq certificados_experiencias"  title="Certificados"><i class="fa fa-file-text-o"></i>&nbsp;Certificados</button><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                        $("#tbl_experiencias tbody").append(tr);
                        $("#registro_nulo").remove();
                        
                        //Limpiar campos del formulario
                        $("#fr_datos_experiencia")[0].reset();
                        mensaje_success(response.mensaje_success);
                        
                     }else{
                            $("#tbl_experiencias tbody > tr").remove();
                            mensaje_success(response.mensaje_success);
                     }
                    }else{
                     
                     if(response.errors){
                            //Busca todos los input y lo pone a su color original
                        $(document).ready(function(){
                          $("input").css({"border": "1px solid #ccc"});
                          $("select").css({"border": "1px solid #ccc"});
                        });
                            
                            //Recorrer el errors y cambiar de color a los input requeridos
                        $.each(response.errors,function(key,value){
                         //Cambiar color del borde a color rojo
                          document.getElementById(key).style.border = 'solid red';
                        });

                      }
                     
                     mensaje_danger(response.mensaje_success);
                    }
                   
                }
            });
        });

        //Editar Experiencia--------------------------------------------------------------------------
        $(document).on("click",".editar_experiencia", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_experiencia').style.display = 'block';
            document.getElementById('actualizar_experiencia').style.display = 'block';
            //Ocultar Boton Guardar
            document.getElementById('guardar_experiencias').style.display = 'none';
            //Desactivar botones Editar + Eliminar
            $(".disabled_experiencia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
                if(id){
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_editar_experiencia')}}",
                    success: function (response) {
                      $("#nombre_empresa").val(response.data.nombre_empresa);
                      $("#telefono_temporal").val(response.data.telefono_temporal);
                      $("#cargo_desempenado").val(response.data.cargo_desempenado);
                      $("#cargo_especifico").val(response.data.cargo_especifico);

                    @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

                      $("#nombres_jefe").val(response.data.nombres_jefe);
                      $("#cargo_jefe").val(response.data.cargo_jefe);
                      $("#telefono_movil_jefe").val(response.data.movil_jefe);
                      $("#telefono_jefe").val(response.data.fijo_jefe);
                      $("#ext_jefe").val(response.data.ext_jefe);
                    
                    @endif

                      $("#fecha_final").val(response.data.fecha_final);
                      $("#fecha_inicio").val(response.data.fecha_inicio);
                      $("#salario_devengado").val(response.data.salario_devengado);
                      $("#motivo_retiro").val(response.data.motivo_retiro);
                    
                    @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

                      $("#funciones_logros").val(response.data.funciones_logros);
                    
                    @endif

                        $(".id_modificar_experiencia").val(response.data.id);

                        if (response.data.empleo_actual == true){
                            $("#empleo_actual").prop("checked", true)
                        }else{
                            $("#empleo_actual").prop("checked", false);
                        }

                        //Ciudad-Residencia
                        $("#autocompletado_residencia").val(response.ciudad);
                        $("#pais_id_res").val(response.data.pais_id);
                        $("#departamento_id_res").val(response.data.departamento_id);
                        $("#ciudad_id_res").val(response.data.ciudad_id);
                        //Cargo Desepeño
                        $("#cargo_desempenado_autocomplete").val(response.cargo);

                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Eliminar Experiencia--------------------------------------------------------------------------------
        $(document).on("click",".eliminar_experiencia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            if (id) {
                if (confirm("Desea eliminar este registro?")){
                    $(".disabled_experiencia").prop("disabled", true);
                    $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_eliminar_experiencia')}}",
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

        //Cancelar Experiencia-------------------------------------------------------------------------------
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
            if (id) {
                $("#fr_datos_experiencia")[0].reset();
            }else{
                mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
            }
        });

        //Actualizar Experiencia------------------------------------------------------------------------------
        $(document).on("click","#actualizar_experiencia", function() {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_experiencia').style.display = 'none';
            document.getElementById('actualizar_experiencia').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_experiencias').style.display = 'block';
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_experiencia").val();
            if (id) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_datos_experiencia").serialize(),
                    url: "{{route('admin.ajax_actualizar_experiencia')}}",
                    success: function (response) {
                      
                      if(response.success) {
                            
                        $("#fr_datos_experiencia")[0].reset();
                        $(".disabled_experiencia").prop("disabled", false);
                        
                         mensaje_success("Registro actualizado.");

                            var campos = response.rs;
                            $("#tr_" + campos.id).html(tr);
                            var tr = $("#tr_" + campos.id + "").find("td");

                            tr.eq(0).html(campos.nombre_empresa);
                            tr.eq(1).html(campos.telefono_temporal);
                            @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")
                            tr.eq(2).html(campos.nombres_jefe);
                            tr.eq(3).html(campos.movil_jefe);
                            tr.eq(4).html(campos.fijo_jefe);
                            tr.eq(5).html(campos.cargo_jefe);
                            @endif
                            tr.eq(6).html(campos.fecha_inicio);
                            tr.eq(7).html(campos.fecha_final);
                            tr.eq(8).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_experiencia disabled_experiencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_experiencia disabled_experiencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                        }
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                $(".disabled_experiencia").prop("disabled", false);

            }
        });

        //Autocomplete Ciudad Residencia
        $('#autocompletado_residencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_res").val(suggestion.cod_pais);
                $("#departamento_id_res").val(suggestion.cod_departamento);
                $("#ciudad_id_res").val(suggestion.cod_ciudad);
            }
        });
        //Autocomplete Cargo
        $('#cargo_desempenado_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#cargo_desempenado").val(suggestion.id);
            }
        });

        $(".certificados_experiencias").on("click", function () {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('certificados_experiencias') }}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
            }
        });
    });
</script>
<!-- FIn Script -->
<!-- Fin Experiencia -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<hr>
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

@if(route("home") != "http://listos.t3rsc.co" && route("home") != "https://listos.t3rsc.co" && route("home") != "http://vym.t3rsc.co" && route("home") != "https://vym.t3rsc.co")
<!-- Referencia Personales -->
@if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co")

<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="container_referencia">
            {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_datos_referencia"]) !!}
            {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
            {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
            {!! Form::hidden("id",null,["class"=>"id_modificar_referencia", "id"=>"id_modificar_referencia"]) !!}
            <div class="row">
                <h3 class="header-section-form"> Referencias @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "https://humannet.t3rsc.co") Laborales @else Personales @endif <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                 <p class="text-primary set-general-font-bold">
                  Por favor relacione todas sus referencias personales.
                  Para incluir otra referencia; llene los campos y haga clic en el botón "Guardar".
                 </p>
                  <p class="direction-botones-left">
                   <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Referencias</a>
                  </p>
                </div>

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="ref_nombres" class="col-md-5 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("nombres",null,["class"=>"form-control", "placeholder"=>"Nombres", "id"=>"nombre_referencia"]) !!}
                    </div>
                 </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="ref_apellido1" class="col-md-5 control-label">@if(route('home') == "https://gpc.t3rsc.co") Apellidos @else Primer Apellido @endif :<span class='text-danger sm-text-label'>*</span> </label>
                     <div class="col-md-7">
                      {!! Form::text("primer_apellido",null,["class"=>"form-control", "placeholder"=>"Primer Apellido", "id"=>"primer_apellido_referencia"]) !!}
                      </div>
                  </div>
                </div>

              @if(route('home') == "https://gpc.t3rsc.co")

               <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                 <label for="empresa" class="col-md-5 control-label">Empresa:<span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!! Form::text("empresa",null,["class"=>"form-control", "placeholder"=>"Empresa", "id"=>"empresa"]) !!}
                  </div>
                </div>
               </div>

              @else
                
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                      <label for="ref_apellido2" class="col-md-5 control-label">Segundo Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                          {!! Form::text("segundo_apellido",null,["class"=>"form-control", "placeholder"=>"Segundo Apellido", "id"=>"segundo_apellido_referencia"]) !!}

                        </div>
                    </div>
                </div>

              @endif

                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="tipo_relacion" class="col-md-5 control-label">Tipo relación @if(route('home') == "https://gpc.t3rsc.co") Laboral @endif :<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-7">
                            {!! Form::select("tipo_relacion_id",$tipoRelaciones,null,["class"=>"form-control", "id"=>"tipo_relacion_referencia"]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="telefono_movil" class="col-md-5 control-label">Teléfono Móvil:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">

                            {!! Form::text("telefono_movil",null,["class"=>"form-control solo-numero", "placeholder"=>"Teléfono Móvil", "id"=>"telefono_movil_referencia"]) !!}
                        </div>
                    </div>
                </div>

               @if(route('home') == "https://gpc.t3rsc.co")
                
                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="correo" class="col-md-5 control-label">Correo electronico:<span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!!Form::text("correo",null,["class"=>"form-control", "placeholder"=>"Correo", "id"=>"correo"])!!}
                  </div>
                 </div>
                </div>

              @else

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="telefono_fijo" class="col-md-5 control-label">Teléfono Fijo:<span class='text-danger sm-text-label'>*</span> </label>
                    <div class="col-md-7">
                     {!! Form::text("telefono_fijo",null,["class"=>"form-control solo-numero", "placeholder"=>"Teléfono Fijo", "id"=>"telefono_fijo_referencia" ]) !!}

                    </div>
                  </div>
                </div>

              @endif
                
                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                   <label for="ref_ciudad" class="col-md-5 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!! Form::hidden("codigo_pais",null,["class"=>"form-control","id"=>"pais_id_ref"]) !!}
                   {!! Form::hidden("codigo_ciudad",null,["class"=>"form-control","id"=>"ciudad_id_ref"]) !!}
                   {!! Form::hidden("codigo_departamento",null,["class"=>"form-control","id"=>"departamento_id_ref"]) !!}
                   {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete_referencia","placeholder"=>"Digita cuidad"]) !!}
                  </div>
                 </div>
                </div>

              @if(route('home') == "https://gpc.t3rsc.co")

               <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                 <label for="cargo" class="col-md-5 control-label"> Cargo de la persona: <span class='text-danger sm-text-label'>*</span> </label>
                 <div class="col-md-7">
                   {!!Form::text("cargo",null,["class"=>"form-control", "placeholder"=>"Cargo", "id"=>"cargo" ])!!}
                 </div>
                </div>
               </div>

              @else

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="ocupacion" class="col-md-5 control-label">Ocupación:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::select("ocupacion",[""=>"Seleccionar","empleado"=>"EMPLEADO","desempleado"=>"DESEMPLEADO"],null,["class"=>"form-control", "id"=>"ocupacion_referencia" ])!!}
                   </div>
                  </div>
                </div>

              @endif

            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-warning pull-right" type="button" id="cancelar_referencia" style="display:none; margin: auto 10px auto;"><i class="fa fa-pen"></i>&nbsp;Cancelar</button>
                <button class="btn btn-success pull-right" type="button" id="actualizar_referencia" style="display:none; margin: auto 10px auto;"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button> 

                <button class="btn btn-success pull-right" type="button" id="guardar_referencia_personal" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>
            {!!  Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla_datos_referencia"]) !!}
                
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="table_referencias">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono Móvil</th>
                                <th>Teléfono Fijo</th>
                                <th>Tipo Relación</th>
                                <th>Ciudad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                              @if($referencias->count() == 0)
                              <tr id="registro_nulo">
                                <td colspan="7">No  hay registros</td>
                            </tr>
                            @endif
                            @foreach($referencias as $referencia)
                            <tr id="tr_{{$referencia->id}}">
                                <td>{{$referencia->nombres}}</td>
                                <td>{{ $referencia->primer_apellido." ".$referencia->segundo_apellido }}</td>
                                <td>{{$referencia->telefono_movil}}</td>
                                <td>{{$referencia->telefono_fijo}}</td>
                                <td>{{$referencia->relacion}}</td>
                                <td>{{$referencia->ciudad_seleccionada}}</td>
                                <td>
                                 {!! Form::hidden("id",$referencia->id, ["id"=>$referencia->id]) !!}
                                   <button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                                   <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                                
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!-- /.container -->
</div>
@endif

<script>
    $(function () {
        //Guardar Referencia Personal ------------------------------------------------------------------------
        $("#guardar_referencia_personal").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_datos_referencia").serialize(),
                url: "{{route('admin.ajax_guardar_referencia')}}",
                beforeSend: function(){
                  $("#guardar_referencia_personal").prop('disabled','disabled');
                },
                success: function (response){
                  $("#guardar_referencia_personal").prop('disabled',false);
                    if (response.success) {

                        //Busca todos los input y lo pone a su color original
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});

                            });

                        var data = response.referencia;
                        var relacion = response.relacionTipo;
                        var ciudad = response.ciudad;
                        var fila = $("<tr id='tr_" + data.id + "' ></tr>");
                        fila.append($("<td></td>", {text: data.nombres}));
                        fila.append($("<td></td>", {text: data.primer_apellido + " " + data.segundo_apellido}));
                        fila.append($("<td></td>", {text: data.telefono_movil}));
                        fila.append($("<td></td>", {text: data.telefono_fijo}));
                        fila.append($("<td></td>", {text: relacion.descripcion}));
                        fila.append($("<td></td>", {text: ciudad.ciudad_seleccionada}));
                        fila.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+data.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));

                        $("#table_referencias tbody").append(fila);
                        $("#registro_nulo").remove();
                        mensaje_success(response.mensaje_success);

                        //Limpiar campos del formulario
                        $("#fr_datos_referencia")[0].reset();
                    }else{
                        if (response.error)
                        {
                            //Busca todos los input y lo pone a su color original
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});

                            });

                            //Recorrer el errors y cambiar de color a los input reqeuridos
                            $.each(response.error,function(key,value){
                                //Cambiar color del borde a color rojo
                                document.getElementById(key).style.border = 'solid red';
                            });
                        }
                        mensaje_danger(response.mensaje_success);
                    }
                }
            });
        });

        //Editar Referencia--------------------------------------------------------------------------------
        $(document).on("click",".editar_referencia", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_referencia').style.display = 'block';
            document.getElementById('actualizar_referencia').style.display = 'block';
            //Ocultar Boton Guardar
            document.getElementById('guardar_referencia_personal').style.display = 'none';
            //Desactivar botones Editar + Eliminar
            $(".disabled_referencia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
                if(id){
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_editar_referencia')}}",
                    success: function (response) {
                        $("#nombre_referencia").val(response.data.nombres);
                        $("#primer_apellido_referencia").val(response.data.primer_apellido);
                        $("#segundo_apellido_referencia").val(response.data.segundo_apellido);
                        $("#tipo_relacion_referencia").val(response.data.tipo_relacion_id);
                        $("#telefono_movil_referencia").val(response.data.telefono_movil);
                        $("#telefono_fijo_referencia").val(response.data.telefono_fijo);
                        $("#ocupacion_referencia").val(response.data.ocupacion);
                        $(".id_modificar_referencia").val(response.data.id);

                        $("#ciudad_autocomplete_referencia").val(response.data.ciudad_autocomplete);
                        $("#pais_id_ref").val(response.data.codigo_pais);
                        $("#departamento_id_ref").val(response.data.codigo_departamento);
                        $("#ciudad_id_ref").val(response.data.codigo_ciudad);

                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Eliminar Experiencia--------------------------------------------------------------------------------
        $(document).on("click",".eliminar_referencia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            if (id) {
                if (confirm("Desea eliminar este registro?")){
                    $(".disabled_referencia").prop("disabled", true);
                    $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_eliminar_referencia')}}",
                        success: function (response) {
                            $("#tr_" + response.id).remove();
                            mensaje_success("Registro eliminado.");
                            $(".disabled_referencia").prop("disabled", false);

                        }
                    });
                }
                
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Cancelar Experiencia-------------------------------------------------------------------------------
        $("#cancelar_referencia").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_referencia').style.display = 'none';
            document.getElementById('actualizar_referencia').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_referencia_personal').style.display = 'block';
            //Activar botones Editar + Eliminar
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_referencia").val();
            if (id) {
                $("#fr_datos_referencia")[0].reset();
                $(".disabled_referencia").prop("disabled", false);
            }else{
                mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
            }
        });

        //Actualizar Experiencia------------------------------------------------------------------------------
        $(document).on("click","#actualizar_referencia", function() {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_referencia').style.display = 'none';
            document.getElementById('actualizar_referencia').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_referencia_personal').style.display = 'block';
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_referencia").val();
            if (id) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_datos_referencia").serialize(),
                    url: "{{route('admin.ajax_actualizar_referencia')}}",
                    success: function (response) {
                        if (response.success) {

                        $(".disabled_referencia").prop("disabled", false);
                        $("#fr_datos_referencia")[0].reset();
                        mensaje_success("Registro actualizado.");

                        var data = response.referencia;
                        var relacion = response.relacionTipo;
                        var ciudad = response.ciudad;
                        var fila = $("#tr_" + data.id + " td");
                        fila.eq(0).html(data.nombres);
                        fila.eq(1).html(data.primer_apellido + " " + data.segundo_apellido);
                        fila.eq(2).html(data.telefono_movil);
                        fila.eq(3).html(data.telefono_fijo);
                        fila.eq(4).html(relacion.descripcion);
                        fila.eq(5).html(ciudad.ciudad_seleccionada);
                        fila.eq(6).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));
                    }
                        
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                $(".disabled_referencia").prop("disabled", false);

            }
        });


        //Autocomplete Ciudad Referencia Personal
        $('#ciudad_autocomplete_referencia').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_ref").val(suggestion.cod_pais);
                $("#departamento_id_ref").val(suggestion.cod_departamento);
                $("#ciudad_id_ref").val(suggestion.cod_ciudad);
            }
        });
    });
</script>
<!-- Fin Referencia Personales -->
@endif

<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<hr>
<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

<!-- Grupo Familiar -->
@if(route('home')!= "http://komatsu.t3rsc.co")

<div class="col-right-item-container">
    <div class="container-fluid">
        <div id="grupo_container">
            {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_grupo"]) !!}

            {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
            {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
            {!! Form::hidden("id",null,["class"=>"id_modificar_familiar", "id"=>"id_modificar_familiar"]) !!}

            <div class="row">
                <h3 class="header-section-form"> Grupo Familiar <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                <div class="col-md-12">
                 <p class="text-primary set-general-font-bold">
                   Por favor relacione todas sus beneficiario / <strong>Personas a cargo.</strong>
                   Para incluir otra persona; llene los campos y haga clic en el botón "Guardar".
                 </p>
                 <p class="direction-botones-left">
                  <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Familiares</a>
                 </p>
                </div>

            @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co" && route('home')!= "https://gpc.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="tipo_documento" class="col-md-5 control-label">Tipo Documento: @if(route('home')!= "https://vym.t3rsc.co" && route('home')!= "https://listos.t3rsc.co") <span class='text-danger sm-text-label'>*</span> @endif </label>
                        <div class="col-md-7">
                         {!! Form::select("tipo_documento",$selectores->tipoDocumento,null,["class"=>"form-control", "id"=>"tipo_documento_familiar"]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="documento_identidad" class="col-md-5 control-label"># Documento:<span class='text-danger sm-text-label'>*</span> </label>
                  <div class="col-md-7">
                   {!! Form::text("documento_identidad",null,["class"=>"form-control solo_numeros", "id"=>"documento_identidad_familiar"]) !!}
                  </div>
                 </div>
                </div>

            @endif
                {{-- <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="lugar_expedicion" class="col-md-5 control-label">Lugar Expedición:<span class='text-danger sm-text-label'>*</span> </label>
                        <div class="col-md-7">
                            {!! Form::hidden("codigo_pais_expedicion",null,["class"=>"form-control","id"=>"pais_id_familia_ex"]) !!}
                            {!! Form::hidden("codigo_ciudad_expedicion",null,["class"=>"form-control","id"=>"ciudad_id_familia_ex"]) !!}
                            {!! Form::hidden("codigo_departamento_expedicion",null,["class"=>"form-control","id"=>"departamento_id_familia_ex"]) !!}
                            {!! Form::text("ciudad_autocomplete_familia_expedicion",null,["class"=>"form-control","id"=>"ciudad_autocomplete_familia_expedicion","placeholder"=>"Digita cuidad"]) !!}
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                    <label for="nombres" class="col-md-5 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
                     <div class="col-md-7">
                      {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres", "id"=>"nombres_familiar" ]) !!}
                     </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="ref_apellido1" class="col-md-5 control-label">Primer Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("primer_apellido",null,["class"=>"form-control","placeholder"=>"Primer Apellido", "id"=>"primer_apellido_familiar" ]) !!}
                   </div>
                  </div>
                </div>

              @if(route('home')!= "https://gpc.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                   <label for="ref_apellido2" class="col-md-5 control-label">Segundo Apellido:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("segundo_apellido",null,["class"=>"form-control","placeholder"=>"Segundo Apellido", "id"=>"segundo_apellido_familiar" ]) !!}
                   </div>
                  </div>
                </div>

              @endif

            @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co" && route('home')!= "https://gpc.t3rsc.co")

              <div class="col-sm-6 col-lg-6">
               <div class="form-group">
                <label for="escolaridad" class="col-md-5 control-label">Nivel Estudio:<span class='text-danger sm-text-label'>*</span></label>
                 <div class="col-md-7">
                  {!!Form::select("escolaridad_id",$selectores->escolaridad,null,["class"=>"form-control", "id"=>"escolaridad_id_familiar"])!!}
                 </div>
               </div>
              </div>

            @endif

              <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                 <label for="parentesco" class="col-md-5 control-label">Parentesco:<span class='text-danger sm-text-label'>*</span></label>
                 <div class="col-md-7">
                  {!! Form::select("parentesco_id",$selectores->parentesco,null,["class"=>"form-control", "id"=>"parentesco_id_familiar"]) !!}
                 </div>
                </div>
              </div>

              @if(route('home')!= "https://gpc.t3rsc.co")
              
                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                   <label for="genero" class="col-md-5 control-label">Género:<span class='text-danger sm-text-label'>*</span></label>
                   <div class="col-md-7">
                    {!! Form::select("genero",$selectores->genero,null,["class"=>"form-control", "id"=>"genero_familiar"]) !!}
                   </div>
                  </div>
                </div>

              @endif

             @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co" && route('home')!= "https://gpc.t3rsc.co")

                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="fecha_nacimiento" class="col-md-5 control-label">Fecha Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
                   <div class="col-md-7">
                    {!! Form::text("fecha_nacimiento",null,["class"=>"form-control" ,"id"=>"fecha_nacimiento_familiar", "placeholder"=>"Fecha Nacimiento" ]) !!}
                   </div>
                 </div>
                </div>

                <div class="col-sm-6 col-lg-6">
                  <div class="form-group">
                    <label for="ciudad_nacimiento" class="col-md-5 control-label">Ciudad Nacimiento:<span class='text-danger sm-text-label'>*</span> </label>
                     <div class="col-md-7">
                      {!! Form::hidden("codigo_pais_nacimiento",null,["class"=>"form-control","id"=>"pais_id_familia_nac"]) !!}
                      {!! Form::hidden("codigo_ciudad_nacimiento",null,["class"=>"form-control","id"=>"ciudad_id_familia_nac"]) !!}
                      {!! Form::hidden("codigo_departamento_nacimiento",null,["class"=>"form-control","id"=>"departamento_id_familia_nac"]) !!}
                      {!! Form::text("ciudad_autocomplete_familia_nacimiento",null,["class"=>"form-control","id"=>"ciudad_autocomplete_familia_nacimiento","placeholder"=>"Digita cuidad"]) !!}
                     </div>
                  </div>
                </div>

                {{-- <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label for="profesion" class="col-md-5 control-label">Profesión:<span class='text-danger sm-text-label'>*</span></label>
                        <div class="col-md-7">
                            {!! Form::hidden("profesion_id",null,["class"=>"form-control","id"=>"profesion_id"]) !!}
                            {!! Form::text("cargo_profesion_autocomplete",null,["class"=>"form-control","id"=>"cargo_profesion_autocomplete"]) !!}
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-6 col-lg-6">
                 <div class="form-group">
                  <label for="profesion" class="col-md-5 control-label">Profesión:<span class='text-danger sm-text-label'>*</span></label>
                   <div class="col-md-7">
                    {!! Form::text("profesion_id",null,["class"=>"form-control", "placeholder"=>"Profesión","id"=>"profesion_id"]) !!}
                   </div>
                 </div>
                </div>

            @else

                 <div id="rangoedad" class="col-sm-6 col-lg-6">
                   <div class="form-group">
                    <label for="escolaridad" class="col-md-5 control-label">Rango Edad: @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif </label>
                    <div class="col-md-7">
                     {!! Form::select("rango_edad",[''=>"Seleccione...",'0-5'=>"0-5",'6-10'=>"6-10",'11-15'=>"11-15",'16-20'=>"16-20",'21-25'=>"21-25",'26-30'=>"26-30",'31-35'=>"31-35",'36-40'=>"36-40",'41-45'=>"41-45",'45-50'=>"45-50",'50-mas'=>"50-mas"],null,["class"=>"form-control","id"=>"rango_edad"]) !!}
                    </div>
                  </div>
                </div>

            @endif

             @if(route('home') == "https://gpc.t3rsc.co")

              <div class="col-sm-6 col-lg-6">
               <div class="form-group">
                <label for="ocupacion" class="col-md-5 control-label">Ocupación:<span class='text-danger sm-text-label'>*</span> </label>
                <div class="col-md-7">
                 {!! Form::text("ocupacion",null,["class"=>"form-control", "id"=>"ocupacion_referencia" ])!!}
                </div>
               </div>
              </div>

             @endif

            </div><!-- fin row -->

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center set-margin-top">
                <button class="btn btn-warning pull-right" type="button" id="cancelar_familiar" style="display:none; margin: auto 10px auto;"><i class="fa fa-pen"></i>&nbsp;Cancelar</button>
                <button class="btn btn-success pull-right" type="button" id="actualizar_familiar" style="display:none; margin: auto 10px auto;"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button> 

                <button class="btn btn-success pull-right" type="button" id="guardar_familia"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>

            </p>
            {!! Form::close() !!}<!-- /.fin form -->
        </div>
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(["id"=>"grilla_datos_familia"]) !!}
                
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="tbl_familia">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                             @if( route('home')!= "https://gpc.t3rsc.co")
                              @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co")

                                <th># Identidad</th>
                              @endif
                                <th>Parentesco</th>
                             @endif
                            
                            @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co" && route('home')!= "https://gpc.t3rsc.co")
                              <th>Fecha Nacimiento</th>
                              <th>Ciudad Nacimiento</th>
                              <th>Escolaridad</th>
                            @endif
                              <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                         @if($familiares->count() == 0)
                            <tr id="no_registros">
                             <td colspan="8"> No registros</td>
                            </tr>
                            @endif
                            @foreach($familiares as $familiar)
                            <tr id="tr_{{$familiar->id}}">
                                <td>{{$familiar->nombres}}</td>
                                <td>{{$familiar->primer_apellido." ".$familiar->segundo_apellido}}</td>
                             @if(route('home')!= "https://gpc.t3rsc.co")
                               @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co")
                                <td>{{$familiar->documento_identidad}}</td>
                               @endif

                                <td>{{$familiar->parentesco}}</td>
                             @endif

                             @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co" && route('home')!= "https://gpc.t3rsc.co")

                                <td>@if ($familiar->fecha_nacimiento != "") {{$familiar->fecha_nacimiento}} @endif</td>
                                <td>@if(!empty($familiar->getLugarNacimiento())) {{$familiar->getLugarNacimiento()->ciudad }} @endif</td>
                                <td>{{$familiar->escolaridad}}</td>

                             @endif

                               <td>
                                {!! Form::hidden("id",$familiar->id, ["id"=>$familiar->id]) !!}
                                <button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familia"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                                <button type="button" class="btn btn-danger btn-peq eliminar_familia disabled_familia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                               </td>
                            </tr>
                            @endforeach

                        </tbody>                                
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div><!-- /.container -->
</div>
@endif

<!-- Fin contenido principal -->
<script>
    $(function () {

        $("#fecha_nacimiento_familiar").datepicker(confDatepicker);
        //Guardar Familia--------------------------------------------------------------------------------------
        $("#guardar_familia").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_grupo").serialize(),
                url: "{{route('admin.ajax_guardar_familia')}}",
                beforeSend: function(){
                  $("#guardar_familia").prop('disabled','disabled');
                },
                success: function (response) {
                  $("#guardar_familia").prop('disabled',false);
                    if(response.success) {
                    //Busca todos los input y lo pone a su color original
                        $(document).ready(function(){
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                        });
                        console.log(response);
                        var campos = response.registro;
                        var ciudad = response.lugarNacimiento;
                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                        tr.append($("<td></td>", {text: campos.nombres}));
                        tr.append($("<td></td>", {text: campos.primer_apellido + " " + campos.segundo_apellido}));

                     @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co")

                        tr.append($("<td></td>", {text: campos.documento_identidad}));
                     @endif

                        tr.append($("<td></td>", {text: campos.genero}));

                     @if(route('home')!= "http://tiempos.t3rsc.co" && route('home')!= "https://tiempos.t3rsc.co")

                        tr.append($("<td></td>", {text: campos.fecha_nacimiento}));
                        tr.append($("<td></td>", {text: ciudad.ciudad}));
                        tr.append($("<td></td>", {text: campos.escolaridad}));
                     @endif

                        tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_familia disabled_familia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));
                        $("#tbl_familia tbody").append(tr);

                        mensaje_success(response.mensaje_success);
                        $("#registro_nulo").remove();
                        //$(document).scrollTop(0);

                        //Limpiar campos del formulario
                        $("#fr_grupo")[0].reset();
                    }else{
                        if (response.errors)
                        {
                            //Busca todos los input y lo pone a su color original
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});
                            });

                            //Recorrer el errors y cambiar de color a los input reqeuridos
                            $.each(response.errors,function(key,value){
                                //Cambiar color del borde a color rojo
                                document.getElementById(key).style.border = 'solid red';
                            });
                        }
                        mensaje_danger(response.mensaje_success);
                    }
                }
            });
        });

        //Editar Familia--------------------------------------------------------------------------------
        $(document).on("click",".editar_familiar", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_familiar').style.display = 'block';
            document.getElementById('actualizar_familiar').style.display = 'block';
            //Ocultar Boton Guardar
            document.getElementById('guardar_familia').style.display = 'none';
            //Desactivar botones Eliminar + Editar
            $(".disabled_familia").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
                if(id){
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_editar_familiar')}}",
                    success: function (response) {
                        $("#tipo_documento_familiar").val(response.data.tipo_documento);
                        $("#documento_identidad_familiar").val(response.data.documento_identidad);
                        $("#nombres_familiar").val(response.data.nombres);
                        $("#primer_apellido_familiar").val(response.data.primer_apellido);
                        $("#segundo_apellido_familiar").val(response.data.segundo_apellido);
                        $("#escolaridad_id_familiar").val(response.data.escolaridad_id);
                        $("#parentesco_id_familiar").val(response.data.parentesco_id);
                        $("#genero_familiar").val(response.data.genero);
                        $("#fecha_nacimiento_familiar").val(response.data.fecha_nacimiento);
                        $(".id_modificar_familiar").val(response.data.id);
                        //Ciudad-Expedicion
                        $("#ciudad_autocomplete_familia_expedicion").val(response.data.ciudad_autocomplete);
                        $("#pais_id_familia_ex").val(response.data.codigo_pais_expedicion);
                        $("#ciudad_id_familia_ex").val(response.data.codigo_ciudad_expedicion);
                        $("#departamento_id_familia_ex").val(response.data.codigo_departamento_expedicion);
                        //Ciudad-Nacimiento
                        $("#ciudad_autocomplete_familia_nacimiento").val(response.data.ciudad_autocomplete2);
                        $("#pais_id_familia_nac").val(response.data.codigo_pais_nacimiento);
                        $("#ciudad_id_familia_nac").val(response.data.codigo_ciudad_nacimiento);
                        $("#departamento_id_familia_nac").val(response.data.codigo_departamento_nacimiento);
                        //Cargo Profesion
                        $("#cargo_profesion_autocomplete").val(response.cargo);
                        $("#profesion_id").val(response.data.profesion_id);
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Eliminar Familia ------------------------------------------------------------------
        $(document).on("click",".eliminar_familia", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();
            if (id) {
                if(confirm("Desea eliminar este registro?")){
                    $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('admin.ajax_eliminar_familia')}}",
                    success: function (response) {
                        $("#tr_" + response.id).remove();
                        mensaje_success("Registro eliminado.");
                    }
                });
                }
                
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        //Cancelar Experiencia-------------------------------------------------------------------------------
        $("#cancelar_familiar").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_familiar').style.display = 'none';
            document.getElementById('actualizar_familiar').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_familia').style.display = 'block';
            //botones desactivados editar eliminar

            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_familiar").val();
            if (id) {
                $("#fr_grupo")[0].reset();
                $(".disabled_familia").prop("disabled", false);
            }else{
                mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
            }
        });

        //Actualizar Experiencia------------------------------------------------------------------------------
        $(document).on("click","#actualizar_familiar", function() {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_familiar').style.display = 'none';
            document.getElementById('actualizar_familiar').style.display = 'none';
            //MOstrar Boton Guardar
            document.getElementById('guardar_familia').style.display = 'block';
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_familiar").val();
            if (id) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_grupo").serialize(),
                    url: "{{route('admin.ajax_actualizar_familia')}}",
                    success: function (response) {
                        if (response.success) {
                        $("#tr_" + response.id).remove();
                        $("#fr_grupo")[0].reset();
                        $(".disabled_familia").prop("disabled", false);
                        mensaje_success("Registro actualizado.");

                        var campos = response.registro;
                        var ciudad = response.lugarNacimiento;
                        var tr = $("#tr_" + campos.id + " td");
                        tr.eq(0).html(campos.nombres);
                        tr.eq(1).html(campos.primer_apellido + " " + campos.segundo_apellido);
                        tr.eq(2).html(campos.documento_identidad);
                        tr.eq(3).html(campos.genero);
                        tr.eq(4).html(campos.fecha_nacimiento);
                        tr.eq(5).html(ciudad);
                        tr.eq(6).html(campos.escolaridad);
                        tr.eq(7).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familia"><i class="fa fa-pen"></i>&nbsp;Editar</button> <button type="button" class="btn btn-danger btn-peq eliminar_familia disabled_familia"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>'}));
                    }
                        
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                $(".disabled_familia").prop("disabled", false);

            }
        });

        //Autocomplete Profesion
        $('#cargo_profesion_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#profesion_id").val(suggestion.id);
            }
        });

        //Autocomplete Ciudad Expedicion
        $('#ciudad_autocomplete_familia_expedicion').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_familia_ex").val(suggestion.cod_pais);
                $("#departamento_id_familia_ex").val(suggestion.cod_departamento);
                $("#ciudad_id_familia_ex").val(suggestion.cod_ciudad);
            }
        });
        $('#ciudad_autocomplete_familia_nacimiento').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id_familia_nac").val(suggestion.cod_pais);
                $("#departamento_id_familia_nac").val(suggestion.cod_departamento);
                $("#ciudad_id_familia_nac").val(suggestion.cod_ciudad);
            }
        });
    });
</script>
<!-- Fin Grupo Familiar -->

<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<hr>
<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

<!-- Perfilamiento -->

<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <h3 class="header-section-form">Perfilamiento</h3>
                <div class="col-md-12">
                    <p class="text-primary set-general-font-bold">
                        Por favor relacione sus estudios finalizados / <strong>Perfilamiento.</strong>
                        Señalar todos sus perfiles y luego dar clic en "Guardar".
                    </p>
                    <p class="direction-botones-left">
                        <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mi Perfilamiento</a>
                    </p>
                </div>
        <div class="col-md-12">
            <div class="row buscador-cargos">
                <label class="col-md-3 control-label">Busca tu perfil :</label>
                <div class="col-md-6">
                    {!! Form::open(["id"=>"fr_busqueda","onsubmit"=>"return false"]) !!}
                    <input type="text" name="txt-buscador-cargos" id="txt-buscador-cargos" class=""/>
                    <button type="button"  class="" name="btn-buscar-perfil" id="btn_buscar_perfil"><i class="fa fa-search"></i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
         {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"guardar_perfil"]) !!}

         {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
        @if(Session::has("mensaje"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje")}}
            </div>
        </div>
        @endif
        <div class="col-md-8">
            <p class="direction-botones-left">
                @foreach($tipo_cargos as $tipo_cargo)
                <a href="#cargos-{{$tipo_cargo->id}}" class="btn btn-defecto btn-peq">{{$tipo_cargo->descripcion}}</a>

                @endforeach
            </p>

            <div id="container_perfilamiento">
                @foreach($tipo_cargos as $tipo_cargo)

                <div class="col-md-12">
                    <h3 class="header-section-form" id="cargos-{{$tipo_cargo->id}}">{{$tipo_cargo->descripcion}}</h3>
                    @foreach($tipo_cargo->cargosActivos() as $cargo)
                    <div class="checkbox-container-cargos">
                        <label>
                            <input {{((in_array($cargo->id,$items_cargos))?"checked":"")}}  value="{{$cargo->id}}" type="checkbox" name="cargos[]" class="seleccionar_cargo" data-cargo_name="{{$tipo_cargo->descripcion}}" data-cargo_id="{{$tipo_cargo->id}}" data-item_name="{{$cargo->descripcion}}" data-id="{{$cargo->id}}"> {{$cargo->descripcion}}
                        </label>
                    </div>
                    @endforeach

                </div>
                @endforeach
            </div>

            <div class="col-md-12 separador"></div>
            <p class="direction-botones-center">
                <button class="btn btn-success pull-right" id="guardar_perfil_seleccionado" type="button"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
            </p>

        </div>
        <div class="col-md-4" id="cargos_seleccionados">
            <p class="set-general-font-bold title-seleccionados">Cargos Seleccionados&nbsp;<i class="fa fa-check-square-o"></i>
            </p>

            @foreach($cargos_seleccionados as $key => $cargo)
            <div id="bloque_{{$key}}">
                <p class="set-general-font-bold title-seleccionados">{{$cargo["name"]}}</p>
                @foreach($cargo["item"] as $item =>$value_item)

                <div id="item_cargo_{{$item}}" class="flex-container-cargo-seleccionado">
                    <div class="flex-item-cargo-seleccionado-texto set-general-font">{{$value_item}}</div>
                    <div class="flex-item-cargo-seleccionado-icon"><i class="fa fa-times"></i></div>
                    <input type="hidden" name="cargo_generico_id[]" value="{{$item}}">
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        {!! Form::close() !!}
    </div><!-- /.container -->
</div>
<!-- Fin contenido principal -->
<script>
    $(function () {

        $("#guardar_perfil_seleccionado").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#guardar_perfil").serialize(),
                url: "{{route('admin.ajax_guardar_perfil')}}",
                beforeSend: function(){
                  $("#guardar_perfil_seleccionado").prop('disabled','disabled');
                },
                success: function (response) {
                 $("#guardar_perfil_seleccionado").prop('disabled',false);
                    mensaje_success("Perfilamiento guardado correctamente.");
                    $("#container_tab").html(response.view);
                }
            });
        });

        $(document).on("click", ".seleccionar_cargo", function () {
            var info = $(this).data();

            if ($(this).prop("checked")) {
                //VERIFICAR SI EL BLOQUE DEL TIPO CATEGORIA EXISTE
                var bloque;
                if ($("#bloque_" + info.cargo_id).length > 0) {//EXISTE EL BLOQUE
                    bloque = $("#bloque_" + info.cargo_id);
                } else {
                    //AGREGAR BLOQUE
                    bloque = $("<div></div>", {id: "bloque_" + info.cargo_id});
                    bloque.append($("<p></p>", {text: info.cargo_name, class: "set-general-font-bold title-seleccionados"}));
                    $("#cargos_seleccionados").append(bloque);
                }
                // agregar item cargo
                //VERIFICAR SI EL CARGO YA SE AGREGO
                if ($("#item_cargo_" + info.id).length <= 0) {
                    var cargo = $("<div></div>", {class: "flex-container-cargo-seleccionado", id: "item_cargo_" + info.id});
                    cargo.append($("<div></div>", {class: "flex-item-cargo-seleccionado-texto set-general-font", text: info.item_name}));
                    cargo.append($("<div></div>", {class: "flex-item-cargo-seleccionado-icon"}).append($("<i></i>", {class: "fa fa-times"})));
                    cargo.append($("<input />", {type: "hidden", name: "cargo_generico_id[]", value: info.id}));
                    bloque.append(cargo);
                }

            } else {
                $("#item_cargo_" + info.id).remove();
                //CALCULAR LA CANTIDAD DE ITEMS POR CATEGORIAS PARA ELIMINAR EL BLOQUE DE LA CATEGORIA
                var cantidad = $("#bloque_" + info.cargo_id + " ").children(".flex-container-cargo-seleccionado").length;

                if (cantidad == 0) {
                    $("#bloque_" + info.cargo_id + " ").remove();

                }
            }
        });

        $(document).on("click", ".flex-item-cargo-seleccionado-icon", function () {
            var padre = $(this).parents("div");
            var inputId = padre.children("input");
            $("#item_cargo_" + inputId.val()).remove();
            $(".seleccionar_cargo[value='" + inputId.val() + "']").prop("checked", false);
        });

        $("#btn_buscar_perfil").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_busqueda").serialize(),
                url: "{{ route('busqueda_pefilamiento') }}",
                success: function (response) {

                    $("#container_perfilamiento").html(response);
                }
            })
        });
    });

</script>
<!-- Fin Perfilamiento-->
<hr/>
<!-- Idiomas -->

<!-- Inicio contenido principal -->
<div class="col-right-item-container">
    <div class="container-fluid">
        <h3 class="header-section-form">Idiomas</h3>

            {!! Form::open(["id"=>"fr_idioma", "role"=>"form"]) !!}

            {!! Form::hidden("id",null,["class"=>"e_idioma_id", "id"=>"e_idioma_id"]) !!}
            {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
        <div class="row">
            <p class="direction-botones-left">
                <a href="#grilla_datos_idiomas" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Idiomas </a>
            </p>
        </div>

        <div class="row">
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label>Idioma:  <span>*</span></label>
                {!! Form::hidden("id_idioma",null,["class"=>"form-control","id"=>"id_idioma"]) !!}
                
                {!! Form::text("idioma",null,["class"=>"form-control","placeholder"=>"Digite Idioma","id"=>"idioma_autocomplete"])!!}
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label>Nivel idioma: <span>*</span></label>
                {!! Form::select("nivel", $niveles, null, ["class"=>"form-control","id"=>"nivel"]) !!}
            </div>
        </div>

        <div class="row">
            <p class="direction-botones set-margin-top">
                <button class="btn btn-warning pull-right" id="cancelar_idioma" style="display:none; margin: auto 10px auto;" type="button">
                    <i class="fa fa-pen"> </i> Cancelar
                </button>
                     
                <button class="btn btn-success pull-right" id="actualizar_idioma" style="display:none; margin: auto 10px auto;" type="button">
                    <i class="fa fa-floppy-o"> </i> Actualizar
                </button>
                    
                <button class="btn btn-success pull-right" id="guardar_idioma" type="button">
                    <i class="fa fa-floppy-o"> </i> Guardar
                </button>
            </p>
            
        </div>
        {!! Form::close() !!}
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                    <strong id="error"></strong>
                </div>
                {!! Form::open(["id"=>"grilla_datos_idiomas"]) !!}
                
                <div class="grid-container table-responsive">
                    <table class="table table-striped" id="table_idiomas">
                        <thead>
                            <tr>
                                <th>Idioma</th>
                                <th>Nivel</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                              @if($idiomas->count() == 0)
                              <tr id="registro_nulo_idioma">
                                <td colspan="3">No  hay registros</td>
                            </tr>
                            @endif
                            @foreach($idiomas as $idioma)
                            <tr id="tr_idioma_{{$idioma->id}}">
                                <td class="text-center">{{ $idioma->nombre_idioma->descripcion}}</td>
                                <td class="text-center">{{$idioma->nivel_idioma->descripcion}}</td>
                                <td class="text-center">
                                 {!! Form::hidden("id_idioma",$idioma->id, ["id"=>$idioma->id]) !!}
                                   <button type="button" class="btn btn-primary btn-peq editar_idioma disabled_idioma" data-id="{{$idioma->id}}"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                                   <button type="button" class="btn btn-danger btn-peq eliminar_idioma disabled_idioma" data-id="{{$idioma->id}}"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
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
<script>
    $(function () {
        $('#idioma_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocompletar_idiomas") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#id_idioma").val(suggestion.id);
                    $("#idioma_autocomplete").val(suggestion.value);
                }
            });
        //Guardar Idioma------------------------------------------------------------------------
        $("#guardar_idioma").on("click", function () {
            $.ajax({
                type: "POST",
                data: $("#fr_idioma").serialize(),
                url: "{{route('admin.ajax_guardar_idioma')}}",
                beforeSend: function(){
                  $("#guardar_idioma").prop('disabled','disabled');

                  window.location.href = '#fr_idioma';
                  
                },
                success: function (response){
                  $("#guardar_idioma").prop('disabled',false);
                  
                    if (response.success) {
                        mensaje_success(response.mensaje_success);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500)
                    }else{
                        if (response.error)
                        {
                            //Busca todos los input y lo pone a su color original
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});

                            });

                            //Recorrer el errors y cambiar de color a los input requeridos
                            $.each(response.error,function(key,value){
                                //Cambiar color del borde a color rojo
                                document.getElementById(key).style.border = '1px solid red';
                                if (key == 'id_idioma') {
                                    $("#idioma_autocomplete").focus();
                                    $("#idioma_autocomplete").css({"border": "1px solid red"});
                                }
                            });


                            mensaje_danger(response.mensaje_danger);
                        }
                    }
                }
            });
        });

        $(document).on("click",".editar_idioma", function() {
                //Mostar Botones Cancelar Guardar.
                document.getElementById('cancelar_idioma').style.display = 'block';
                document.getElementById('actualizar_idioma').style.display = 'block';
                //Ocultar Boton Guardar
                document.getElementById('guardar_idioma').style.display = 'none';
                //Desactivar botones Editar + Eliminar
                $(".disabled_idioma").prop("disabled", true);

                var objButton = $(this);
                id = $(this).data('id');
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('editar_idioma')}}",
                        success: function (response) {
                            $("#id_idioma").val(response.datos.id_idioma);
                            $("#idioma_autocomplete").val(response.datos.nombre_idioma);
                            $("#nivel").val(response.datos.nivel);

                            $("#e_idioma_id").val(response.datos.id);
                            
                        }
                    });
                }else{
                    mensaje_danger("No se pudo editar el registro, favor intentar nuevamente.");
                }
            });

        $("#cancelar_idioma").on("click", function () {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_idioma').style.display = 'none';
                document.getElementById('actualizar_idioma').style.display = 'none';
                //MOstrar Boton Guardar
                document.getElementById('guardar_idioma').style.display = 'block';
                
                //Activar botones Editar + Eliminar
                $(".disabled_idioma").prop("disabled", false);

                var objButton = $(this);
                id = $("#e_idioma_id").val();
                if(id){
                 $("#fr_idioma")[0].reset();
                }else{
                 mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
                }
            });

        $(document).on("click",".eliminar_idioma", function() {
                var objButton = $(this);
                id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('eliminar_idioma')}}",
                    success: function (response) {
                     objButton.parents('td').parents('tr').remove();
                     
                     mensaje_success("Idioma eliminado correctamente!");
                     
                     setTimeout(() => {
                            $("#modal_success").modal("hide");
                        }, 1500)
                     
                    },
                    error: function(response) {
                        mensaje_danger("Ocurrio un error al eliminar el idioma.")
                    }
                });
            });

        $(document).on("click","#actualizar_idioma", function() {
                var objButton = $(this);
                id = objButton.parents("form").find("#e_idioma_id").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_idioma").serialize(),
                        url: "{{route('actualizar_idioma')}}",
                        beforeSend: function(){

                          window.location.href = '#grilla_datos_idiomas';
                          
                        },
                        success: function (response) {
                          mensaje_success("Registro actualizado.");
                           location.reload();
                        },
                        error:function(data){ 
                            $(document).ready(function(){
                              $("input").css({"border": "1px solid #ccc"});
                              $("select").css({"border": "1px solid #ccc"});
                              $("textarea").css({"border": "1px solid #ccc"});
                              $(".text").remove();
                            });

                            $.each(data.responseJSON, function(index, val){
                              $('input[name='+index+']').after('<span class="text">'+val+'</span>');
                              document.getElementById(index).style.border = '1px solid red';
                              if (key == 'id_idioma') {
                                    $("#idioma_autocomplete").focus();
                                    $("#idioma_autocomplete").css({"border": "1px solid red"});
                                }
                            });

                            $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                            $("#mensaje-error").fadeIn();
                        }
                    });
                }else{
                    mensaje_danger("No se actualizo el registro, favor intentar nuevamente.");
                    $(".disabled_idioma").prop("disabled", false);
                }
            });
    });
</script>
<!-- fin de seccion de idiomas -->
@stop