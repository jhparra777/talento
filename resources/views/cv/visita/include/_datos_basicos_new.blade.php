<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Datos identificación del aspirante</h3>
    </div>
    <div class="panel-body">
            
        <form id="form-1" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            {{--<input name="requerimiento_id" type="hidden" value="{{$req_id}}">
            <input name="candidato_id" type="hidden" value="{{$candidatos->user_id}}">--}}

            <input name="id_visita" type="hidden" value="{{$candidatos->id_visita}}">
            @if(isset($edit))          
                <input name="edit" type="hidden" value="{{$edit}}">      
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Primer nombre <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::text("primer_nombre",
                        $candidatos->primer_nombre,
                        ["required","class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"primer_nombre",
                        "required"=>true,
                        "readonly"=>true]) !!}
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Segundo nombre <span></span> 
                        </label>
                        {!! Form::text("segundo_nombre",
                        $candidatos->segundo_nombre,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"segundo_nombre",
                        "readonly"=>true]) !!}  
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Primer apellido <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::text("primer_apellido",
                        $candidatos->primer_apellido,
                        ["required",
                        "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"primer_apellido",
                        "required"=>true,
                        "readonly"=>true]) !!}                       
                    </div>
                </div>

                <div class="col-md-6">
                    <div class=" form-group">
                        <label class="control-label" for="inputEmail3">
                            Segundo apellido <span></span> 
                        </label>
                        {!! Form::text("segundo_apellido",
                        $candidatos->segundo_apellido,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"segundo_apellido",
                        "readonly"=>true]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Tipo identificación <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("tipo_id",
                        $tipos_documentos,
                        $candidatos->tipo_id,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"tipo_id",
                        "required"=>true]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Identificación <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::text("numero_id",
                        $candidatos->numero_id,
                        ["required",
                        "class"=>"form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"numero_id",
                        "required"=>true,
                        "readonly"=>true]) !!}
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Fecha expedición de documento<span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::text("fecha_expedicion",
                        $candidatos->fecha_expedicion,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id"=>"fecha_expedicion", 
                        "placeholder"=>"Fecha Expedición", 
                        "readonly" => "readonly","required"=>true]) !!}               
                    </div>                
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ciudad expedición de documento <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        <span style="color:red;display: none;" id="error_ciudad_expedicion">Debe seleccionar de la lista</span>

                        {!! Form::hidden("pais_id",$candidatos->pais_id,["class"=>"form-control","id"=>"pais_id"]) !!}
                        {!! Form::hidden("departamento_expedicion_id",$candidatos->departamento_expedicion_id,["class"=>"form-control","id"=>"departamento_expedicion_id"]) !!}
                        {{-- {!! Form::hidden("ciudad_expedicion_id",$candidatos->ciudad_expedicion_id,["class"=>"form-control","id"=>"ciudad_expedicion_id"]) !!} --}}
                        {!! Form::text("ciudad_expedicion_id", $candidatos->ciudad_expedicion_id, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_expedicion_id", "required" => "required"]) !!}

                        {!! Form::text("ciudad_exp_autocomplete",
                        $txt_ciudad_expedicion,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"ciudad_exp_autocomplete",
                        "placheholder"=>"Digita Cuidad",
                        "required"=>true]) !!}
                        {{-- {!! Form::select("ciudad_expedicion_id",
                        $ciudades_expedicion,
                        $candidatos->ciudad_expedicion_id,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "placeholder"=>"",
                        "id"=>"ciudad_expedicion_id",
                        "required"=>true]) !!}                     --}}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Fecha nacimiento<span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::text("fecha_nacimiento",
                        $candidatos->fecha_nacimiento,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"fecha_nacimiento" , 
                        "placeholder"=>"Fecha Nacimiento", 
                        "readonly" => "readonly",
                        "required"=>true]) !!}
                    </div>     
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ciudad de nacimiento <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        <span style="color:red;display: none;" id="error_ciudad_nacimiento">Debe seleccionar de la lista</span>
                        {!! Form::hidden("pais_nacimiento",$candidatos->pais_nacimiento,["class"=>"form-control","id"=>"pais_nacimiento"]) !!}
                        {!! Form::hidden("departamento_nacimiento",$candidatos->departamento_nacimiento,["class"=>"form-control","id"=>"departamento_nacimiento"]) !!}
                        {{-- {!! Form::hidden("ciudad_nacimiento",$candidatos->ciudad_nacimiento,["class"=>"form-control","id"=>"ciudad_nacimiento"]) !!} --}}
                        {!! Form::text("ciudad_nacimiento", $candidatos->ciudad_nacimiento, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_nacimiento", "required" => "required"]) !!}
                        
                        {!! Form::text("ciudad_nac_autocomplete",
                        $txt_ciudad_nac,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"ciudad_nac_autocomplete",
                        "placheholder"=>"Digita Cuidad",
                        "required"=>true]) !!}
                        {{-- {!! Form::select("ciudad_nacimiento_id",
                        $ciudades_nacimiento,
                        $candidatos->ciudad_nacimiento,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "placeholder"=>"",
                        "id"=>"ciudad_nacimiento_id",
                        "required"=>true]) !!}                     --}}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ciudad de residencia <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        <span style="color:red;display: none;" id="error_ciudad_residencia">Debe seleccionar de la lista</span>
                        {!! Form::hidden("pais_residencia",$candidatos->pais_residencia,["class"=>"form-control","id"=>"pais_residencia"]) !!}
                        {!! Form::hidden("departamento_residencia",$candidatos->departamento_residencia,["class"=>"form-control","id"=>"departamento_residencia"]) !!}
                         {{-- {!! Form::hidden("ciudad_residencia",$candidatos->ciudad_residencia,["class"=>"form-control","id"=>"ciudad_residencia"]) !!} --}}
                        {!! Form::text("ciudad_residencia", $candidatos->ciudad_residencia, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_residencia", "required" => "required"]) !!}
                       
                        {!! Form::text("ciudad_res_autocomplete",
                        $txt_ciudad_resd,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"ciudad_res_autocomplete",
                        "placheholder"=>"Digita Cuidad",
                        "required"=>true]) !!}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Estado civil <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("estado_civil",
                        $estadoCivil,
                        $candidatos->estado_civil,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"estado_civil",
                        "required"=>true]) !!}                  
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Teléfono móvil <span class='text-danger sm-text-label'>*</span>  
                        </label>
                        <input 
                            type="tel"
                            name="telefono_movil"
                            value= {{ $candidatos->telefono_movil }}
                            class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                            id="telefono_movil"
                            maxlength="10"
                            placeholder="Teléfono móvil"
                            required
                        >
                    </div>
                </div> 

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Email <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        <input 
                            type="email"
                            name="email"
                            value= {{ $candidatos->email }}
                            class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                            id="email"
                            placeholder="Email"
                            required
                            readonly
                        >
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            ¿Libreta militar?<span></span> 
                        </label>
                        {!! Form::select("tiene_libreta",
                        [""=>"Seleccione","1"=>"Sí","2"=>"No"],
                        ((!empty($candidatos->numero_libreta))?1:2),
                        // $candidatos->situacion_militar_definida,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"tiene_libreta"]) !!} 
                    </div> 
                </div>

               <div id="depend-libreta">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                No. Libreta militar <span class='text-danger sm-text-label'>*</span> 
                            </label>
                            {!! Form::text("numero_libreta",
                            $candidatos->numero_libreta,
                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id"=>"numero_libreta"]) !!}  
                        </div>
                    </div>

                    <div class="col-md-6 depend-libreta">
                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Categoría <span class='text-danger sm-text-label'>*</span> 
                            </label>
                            {!! Form::select("clase_libreta",
                            $claseLibreta,
                            $candidatos->clase_libreta,
                            ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id"=>"clase_libreta"]) !!}          
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Dirección de residencia <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::text("direccion",
                        trim($candidatos->direccion),
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"direccion",
                        "required"=>true]) !!}
                    </div>
                </div>

                <div class="col-md-6 ">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Barrio <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::text("barrio",
                        $candidatos->barrio,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"barrio",
                        "required"=>true]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Estrato <span></span> 
                        </label>
                        {!! Form::select("datos_estrato",[""=>"Seleccionar","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5", "6"=>"6"],
                        $candidatos->datos_estrato,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id"=>"datos_estrato"]) !!}
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Pasaporte <span class='text-danger sm-text-label'></span> 
                        </label>
                        {!! Form::text("pasaporte",
                        $candidatos->pasaporte,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"pasaporte"]) !!}
                    </div>
                    <label id="pasaporte" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Visa <span class='text-danger sm-text-label'></span> 
                        </label>
                        {!! Form::text("visa",
                        $candidatos->visa,
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"visa"]) !!}
                    </div>
                    <label id="visa" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Grupo sanguineo <span class='text-danger sm-text-label'>*</span> 
                        </label>
                        {!! Form::select("grupo_sanguineo",
                        [""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],
                        $candidatos->grupo_sanguineo,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id"=>"grupo_sanguineo",
                        "required"=>true]) !!} 
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            RH <span class='text-danger sm-text-label'>*</span>
                        </label>
                        {!! Form::select("rh",
                        [""=>"Seleccionar","positivo"=>"Positivo","negativo"=>"Negativo"],
                        $candidatos->rh,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                        "id"=>"rh",
                        "required"=>true]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            ¿Tiene licencía de conducción?<span></span> 
                        </label>
                        {!! Form::select("tiene_licencia",
                        [""=>"Seleccione","1"=>"Sí","2"=>"No"],
                        ((!empty($candidatos->categoria_licencia))?1:2),
                        ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"tiene_licencia"]) !!} 
                    </div> 
                </div>

                <div id="depend-licencia">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                Número de licencia <span class='text-danger sm-text-label'>*</span> 
                            </label>
                            {!! Form::text("nro_licencia",
                            $candidatos->nro_licencia,
                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id"=>"nro_licencia"]) !!}  
                        </div>
                    </div>

                    <div class="col-md-6 depend-libreta">
                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Categoría de la licencía <span class='text-danger sm-text-label'>*</span>
                            </label>
                            {!! Form::select("categoria_licencia",
                            $categoriaLicencias,
                            $candidatos->categoria_licencia,
                            ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id"=>"categoria_licencia"]) !!}          
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Administradora de pensiones (AFP)<span></span> 
                        </label>
                        {!!Form::select("entidad_afp",
                        $entidadesAfp,
                        $candidatos->entidad_afp,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"entidad_afp"])!!} 
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Entidad promotora de salud (EPS) <span></span> 
                        </label>
                        {!! Form::select("entidad_eps",
                        $entidadesEps,
                        $candidatos->entidad_eps,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id"=>"entidad_eps"]) !!}
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Hijos <span class='text-danger sm-text-label'></span>
                        </label>
                        <input 
                            type="number"
                            name="hijos"
                            class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                            id="hijos"
                            placeholder="Hijos"
                            value= {{ ((!empty($candidatos->hijos))?$candidatos->hijos:0) }}
                        >
                    </div>
                </div>

            </div>

            {{-- @if(!is_null($candidatos->requerimiento_id))
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Cargo <span></span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("cargo_nombre",$candidatos->cargo,["class"=>"
                            form-control","id"=>"cargo_nombre","disabled"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Cliente <span></span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("cliente_nombre",$candidatos->cliente,["class"=>"
                            form-control","id"=>"cliente_nombre","disabled"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                </div>
            @endif --}}
        </form>
    </div>
</div>

@include("cv.visita.include._js_datos_basicos")