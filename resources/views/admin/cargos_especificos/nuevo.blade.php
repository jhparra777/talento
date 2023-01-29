@extends("admin.layout.master")
@section("contenedor")
    <style type="text/css">
        .py-0 {
            padding-bottom: 0px; padding-top: 0px;
        }

        .scroll-doc {
            max-height: 300px; overflow: scroll;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mb-1 {
            margin-bottom: 1rem;
        }

        .help-block.smk-error-msg {
            padding-right: 15px;
        }

        .btn-primary {
            background-color: #337ab7 !important;
            border-color: #2e6da4 !important;
        }

        .font-size-11 {
            font-size: 11pt;
        }

        .py-8 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .error-smg-valor {
            color: #dd4b39;
            padding-right: 15px;
            position: absolute;
            right: 0;
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 0;
            display: none;
        }
    </style>

    @if(Session::has("msg_error"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! Session::get("msg_error") !!}
            </div>
        </div>
    @endif

    <div class="row">
        {!! Form::open(["id" => "fr_cargos_especificos", "route" => "admin.cargos_especificos.guardar", "method" => "POST", "files" => true]) !!}
            {!! Form::hidden("id") !!}

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <label class="control-label" for="descripcion">Nombre del cargo *</label>
                            {!! Form::text("descripcion", null, ["class" => "form-control", "placeholder" => "Nombre del cargo", "required" => "required"]); !!}

                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('descripcion') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}
                            </p>
                        </div>

                        <div class="col-md-6 form-group">
                            @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                                <label class="control-label" for="cargo_generico_id">Área Laboral: *</label>
                            @else
                                <label class="control-label" for="cargo_generico_id">Cargo Genérico: *</label>
                            @endif

                            {!! Form::select("cargo_generico_id", $cargosGenericos, null, ["class" => "form-control", "id" => "cargosGenericoId", "required" => "required"]); !!}

                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('cargo_generico_id') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("cargo_generico_id", $errors) !!}
                            </p>
                        </div>

                        @if(route('home') == "https://komatsu.t3rsc.co")
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="tipo_cargo">Tipo cargo:</label>

                                {!! Form::select("tipo_cargo", [
                                        "" => "Seleccionar",
                                        1 => "DIRECTIVO",
                                        2 => "OPERARIO",
                                        3 => "ADMINISTRATIVO",
                                        4 => "MANDO MEDIO"
                                    ], null, [
                                        "class" => "form-control",
                                        "id" => "tipo_cargo"
                                ]); !!}
                            </div>

                            <div class="col-md-6 form-group">Cliente
                                <label class="control-label" for="plazo_req">Plazo en días</label>
                                
                                {!! Form::number("plazo_req", null, ["class" => "form-control", "id" => "plazo_req"]) !!}
                            </div>
                        @else
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="clt_codigo">Cliente:</label>

                                {!! Form::select('clt_codigo', $clientes, null, ['class' => 'form-control js-select-2-basic', "id" => "cliente_select", "required" => "required"]) !!}

                                <p class="error text-danger direction-botones-center" style="{{ ($errors->has('clt_codigo') ? '' : 'display: none;') }}">
                                    {!! FuncionesGlobales::getErrorData("clt_codigo", $errors) !!}
                                </p>
                            </div>
                        @endif

                        {{-- Validación de contratación virtual --}}
                        @if($sitio->asistente_contratacion == 1)
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="firma_digital">Contratación virtual *</label>
                                {!! Form::select("firma_digital", [1 => "Si", 0 => "No"], null, ["class" => "form-control", "id" => "firma_digital", "required" => "required"]); !!}

                                <p class="error text-danger direction-botones-center" style="{{ ($errors->has('firma_digital') ? '' : 'display: none;') }}">
                                    {!! FuncionesGlobales::getErrorData("firma_digital", $errors) !!}
                                </p>
                            </div>

                            <div class="col-md-6 form-group" id="videos_box">
                                <label class="control-label" for="videos_contratacion">¿Video confirmación? *</label>
                                {!! Form::select("videos_contratacion", [1 => "Si", 0 => "No"], null, ["class" => "form-control", "id" => "videos_contratacion"]); !!}

                                <p class="error text-danger direction-botones-center" style="{{ ($errors->has('videos_contratacion') ? '' : 'display: none;') }}">
                                    {!! FuncionesGlobales::getErrorData("videos_contratacion", $errors) !!}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @include('admin.cargos_especificos.include._panel_perfil_cargo')

            {{-- Checks de documentos --}}
            @if($sitio->asistente_contratacion == 1)
                {{-- Documentos adicionales --}}
                <div class="col-md-12">
                    <h4>Adicionales</h4>

                    <div id="accordion">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-target="#collapseUno" aria-expanded="true" aria-controls="collapseUno" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Cláusula
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseUno" class="collapse" aria-labelledby="headingUno" data-parent="#accordion">
                                <div class="panel-body py-0">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_clausulas"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    <div id="adicionales_box">
                                        {{-- <table class="table">
                                            <tr>
                                                <th></th>
                                                <th>Descripción</th>
                                                <th></th>
                                            </tr>

                                            @foreach($adicionales as $adicional)
                                                <tr class="item_adicional">
                                                    <td>
                                                        <input type="checkbox" class="contratacion-clausulas" name="clausulas[]" id="check_adicionales" value="{{ $adicional->id }}"

                                                        {{ ($adicional->default) ? 'checked' : '' }}>
                                                    </td>
                                                    <td>
                                                        {{ $adicional->descripcion }}
                                                    </td>

                                                    @if(preg_match('/{valor_variable}/', $adicional->contenido_clausula))
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                name="valor_adicional[{{ $adicional->id }}]" 
                                                                class="form-control valor_adicional" 
                                                                id="valor_adicional" 
                                                                placeholder="Valor variable"
                                                                maxlength="100"
                                                                autocomplete="off" 
                                                                disabled

                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                data-container="body"
                                                                title="Debes definir el valor variable para este documento adicional."
                                                            >
                                                        </td>
                                                    @else
                                                        
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Documentos del cargo --}}
                <div class="col-md-12">
                    <h4>Documentos</h4>

                    <div class="panel-group" id="accordion-documentos" role="tablist" aria-multiselectable="true">
                        {{-- Contratación --}}
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapseDos" aria-expanded="true" aria-controls="collapseDos" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Contratación
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseDos" class="collapse" aria-labelledby="headingDos" data-parent="#accordion-documentos">
                                <div class="panel-body py-0 scroll-doc">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_c"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    @foreach($tipos_documento as $tipo)
                                        @if($tipo->categoria == 2)
                                            <div class="col-md-12">
                                                <label style="font-size: 13px;">
                                                    <input type="checkbox" class="contratacion-d" name="documento[]" value="{{$tipo->id}}"
                                                    {{ ($tipo->default) ? 'checked' : '' }}>
                                                    {{ $tipo->descripcion }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Selección --}}
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapseTres" aria-expanded="true" aria-controls="collapseTres" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Selección
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseTres" class="collapse" aria-labelledby="headingTres" data-parent="#accordion-documentos">
                                <div class="panel-body py-0 scroll-doc">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_s"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    @foreach($tipos_documento as $tipo)
                                        @if($tipo->categoria == 1)
                                            <div class="col-md-12">
                                                <label style="font-size: 13px;">
                                                    <input type="checkbox" class="seleccion-d" name="documento[]" value="{{ $tipo->id }}"
                                                    {{ ($tipo->default) ? 'checked' : '' }}>
                                                    {{ $tipo->descripcion }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Post Contratación --}}
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapsePost" aria-expanded="true" aria-controls="collapsePost" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Post contratación
                                    </h3>
                                </a>
                            </div>

                            <div id="collapsePost" class="collapse" aria-labelledby="headingPost" data-parent="#accordion-documentos">
                                <div class="panel-body py-0 scroll-doc">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_p"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    @foreach($tipos_documento as $tipo)
                                        @if($tipo->categoria == 4)
                                            <div class="col-md-12">
                                                <label style="font-size: 13px;">
                                                    <input type="checkbox" class="postcontratacion-d" name="documento[]" value="{{$tipo->id}}"
                                                    {{ ($tipo->default) ? 'checked' : '' }}>
                                                    {{ $tipo->descripcion }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Exámenes --}}
                        <div class="panel panel-primary mb-0">
                            <div class="panel-heading">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapseCuatro" aria-expanded="true" aria-controls="collapseCuatro" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Exámenes
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseCuatro" class="collapse" aria-labelledby="headingCuatro" data-parent="#accordion-documentos">
                                <div class="panel-body py-0 scroll-doc">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_e"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    @foreach($tipos_examenes as $tipo)
                                        <div class="col-md-12">
                                            <label style="font-size: 13px;">
                                                <input type="checkbox" class="examenes_cargo" name="examen[]" value="{{ $tipo->id }}">
                                                {{ $tipo->nombre }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Check asume Solo OSYA
                <div class="col-md-12" style="margin-bottom: 2rem;">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox("asume", 1, false, ["id" => "asume"]) !!} ¿{{FuncionesGlobales::sitio()->nombre}} Asume los examenes ?
                        </label>
                    </div>
                </div>
                --}}
            @endif

            @if($sitio->prueba_bryg == 1 || $sitioModulo->prueba_competencias == 'enabled' || $sitioModulo->prueba_valores1 == 'enabled')
                <div class="col-md-12">
                    <h4>Configuración Pruebas Psicotécnicas</h4>
                </div>
            @endif

            {{-- Botón prueba BRYG modal --}}
            @if($sitio->prueba_bryg == 1)
                <div class="col-md-12 mb-1">
                    <button 
                        type="button" 
                        class="btn btn-primary btn-block" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Configura el perfil que se adapte al cargo."
                        onclick="configurarCargoBRYG(this)" 
                    >
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        Configurar Prueba BRYG-A
                    </button>
                </div>
            @endif

            {{-- Botón prueba Competencias modal --}}
            @if($sitioModulo->prueba_competencias == 'enabled')
                <div class="col-md-12 mb-1">
                    <button 
                        type="button" 
                        class="btn btn-primary btn-block" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Configura la prueba de Personal Skills."
                        onclick="configurarCargoCompetencias(this, '{{ route("admin.configuracion_competencias_cargo") }}')" 
                    >
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        Configurar Prueba Personal Skills
                    </button>
                </div>
            @endif

            {{-- Botón prueba Ethical Values modal --}}
            @if($sitioModulo->prueba_valores1 == 'enabled')
                <div class="col-md-12 mb-1">
                    <button 
                        type="button" 
                        class="btn btn-primary btn-block" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Configura el perfil que se adapte al cargo."
                        onclick="configurarPruebaValores(this)" 
                    >
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        Configurar Prueba Ethical Values
                    </button>
                </div>
            @endif

            @if($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio || $sitioModulo->prueba_digitacion == 'enabled')
                <div class="col-md-12">
                    <h4>Configuración Pruebas Técnicas</h4>
                </div>
            @endif

            {{-- Configuración prueba digitación --}}
            @if($sitioModulo->prueba_digitacion == 'enabled')
                <div class="col-md-12 mb-1">
                    <div id="accordion-digitacion">
                        <div class="panel panel-primary mb-0">
                            <div class="panel-heading py-8">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapseDigitacion" aria-expanded="true" aria-controls="collapseDigitacion" style="cursor: pointer;">
                                    <h3 class="panel-title text-center text-white font-size-11">
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        Configurar Prueba Digitación
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseDigitacion" class="collapse" aria-labelledby="headingUnoDigitacion" data-parent="#accordion-digitacion">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ppmEsperada" class="control-label">Palabras por minuto</label>
                                            <input type="number" class="form-control" name="ppm_esperada" id="ppmEsperada" placeholder="Ingresa las palabras por minuto esperadas">

                                            <small>
                                                <a href="https://es.wikipedia.org/wiki/Palabras_por_minuto" target="_blank">Información adicional (PPM)</a>
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ppmEsperada">Precisión esperada %</label>
                                            <input type="number" class="form-control" name="precision_esperada" id="precisionEsperada" placeholder="Ingresa el porcentaje de precisión esperado">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio)
                <div class="col-md-12">
                    <div id="accordion-excel">
                        @if($sitio->prueba_excel_basico)
                            <div class="panel panel-primary mb-1">
                                <div class="panel-heading py-8">
                                    <a class="collapsed" data-toggle="collapse" data-target="#collapseExcelBasico" aria-expanded="true" aria-controls="collapseExcelBasico" style="cursor: pointer;">
                                        <h3 class="panel-title text-center text-white font-size-11">
                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                            Configurar Prueba Excel Básica
                                        </h3>
                                    </a>
                                </div>
                                <div id="collapseExcelBasico" class="collapse" aria-labelledby="headingUnoExcel" data-parent="#accordion-excel">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox("excel_basico", null, false, ["id" => "excel_basico"]) !!} Incluir prueba excel básica 
                                            </label>
                                        </div>
                                        <div class="row col-md-12 porcentaje-excel-basico" style="display: none;">
                                            <div class="col-md-7 form-group">
                                                <label for="aprobacion_excel_basico" class="control-label">Calificación de aprobación (%)<span>*</span></label>
                                                
                                                {!! Form::number("aprobacion_excel_basico",null,["class" => "form-control", "placeholder" => "", "id" => "aprobacion_excel_basico"]) !!}
                                                <span class="error-smg-valor" id="error-excel-basico">El numero debe ser mayor a 10 y menor a 101</span>
                                            </div>
                                        </div>
                                        <div class="row col-md-12 porcentaje-excel-basico" style="display: none;">
                                            <div class="col-md-7 form-group">
                                                <label for="tiempo_excel_basico" class="control-label">Tiempo máximo para responder (10minutos - 45 minutos)<span>*</span></label>
                                                
                                                {!! Form::number("tiempo_excel_basico", ($configuracion->tiempo_excel_basico != null ? $configuracion->tiempo_excel_basico : 20),["class" => "form-control", "placeholder" => "", "id" => "tiempo_excel_basico"]) !!}
                                                <span class="error-smg-valor" id="error-tiempo-excel-basico">El numero debe ser mayor a 9 y menor a 46</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($sitio->prueba_excel_intermedio)
                            <div class="panel panel-primary">
                                <div class="panel-heading py-8">
                                    <a class="collapsed" data-toggle="collapse" data-target="#collapseExcelIntermedio" aria-expanded="true" aria-controls="collapseExcelIntermedio" style="cursor: pointer;">
                                        <h3 class="panel-title text-center text-white font-size-11">
                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                            Configurar Prueba Excel Intermedio
                                        </h3>
                                    </a>
                                </div>
                                <div id="collapseExcelIntermedio" class="collapse" aria-labelledby="headingDosExcel" data-parent="#accordion-excel">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox("excel_intermedio", null, false, ["id" => "excel_intermedio"]) !!} Incluir prueba excel intermedia 
                                            </label>
                                        </div>
                                        <div class="row col-md-12 porcentaje-excel-intermedio" style="display: none;">
                                            <div class="col-md-7 form-group">
                                                <label for="aprobacion_excel_intermedio" class="control-label">Calificación de aprobación (%)<span>*</span></label>
                                                
                                                {!! Form::number("aprobacion_excel_intermedio",null,["class" => "form-control", "placeholder" => "", "id" => "aprobacion_excel_intermedio"]) !!}
                                                <span class="error-smg-valor" id="error-excel-intermedio">El numero debe ser mayor a 10 y menor a 101</span>
                                            </div>
                                        </div>
                                        <div class="row col-md-12 porcentaje-excel-intermedio" style="display: none;">
                                            <div class="col-md-7 form-group">
                                                <label for="tiempo_excel_intermedio" class="control-label">Tiempo máximo para responder (10minutos - 45 minutos)<span>*</span></label>
                                                
                                                {!! Form::number("tiempo_excel_intermedio", ($configuracion->tiempo_excel_intermedio != null ? $configuracion->tiempo_excel_intermedio : 20),["class" => "form-control", "placeholder" => "", "id" => "tiempo_excel_intermedio"]) !!}
                                                <span class="error-smg-valor" id="error-tiempo-excel-intermedio">El numero debe ser mayor a 9 y menor a 46</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Formulario para la instancia VYM, configuración de fechas --}}
            @if(route('home') == "https://vym.t3rsc.co")
                <div class="col-md-12">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Parametrización tiempo</h3>
                            <br/>
                            <small>Nota: 
                                <cite title="Source Title">
                                    Configurar tiempo segun la cantidad de vacantes a solicitar, con esto al momento de crear un requerimiento se adicionan los días configurados a la fecha de ingreso.
                                </cite>
                            </small>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label>1 a 5 vacantes</label>
                                    <input name="menor5" type="text" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>6 a 10 vacantes</label>
                                    <input name="menor10" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>11 a 20 vacantes</label>
                                    <input name="menor20" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>21 a 30 vacantes</label>
                                    <input name="menor30" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>31 a 40 vacantes</label>
                                    <input name="menor40" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>41 a 50 vacantes</label>
                                    <input name="menor50" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label>51 a 70 vacantes</label>
                                    <input name="menor80" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-3">
                                    <label> Tiempo de evaluación por cliente</label>
                                    <input name="tiempoEvaluacionCliente" type="number" class="form-control" placeholder="Número de días">
                                </div>

                                <div class="col-xs-12">
                                    <br/>
                                    <small>
                                        Nota: 
                                        <cite title="Source Title">
                                            Configuración de validar si los requerimientos tienen "Exámenes médicos - Estudio seguridad". Con el fin de saber si se agregan días de más para la fecha de ingreso.
                                        </cite>
                                    </small>
                                </div>

                                <div class="col-xs-3">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("examesMedicos",1,null,["id"=>"examesMedicos"]) !!} ¿Exámenes médicos?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="examenMedicoOculto">
                                        <label>
                                            Días exámen médico
                                        </label>
                                        <input name="examenMedicoDias" type="number" class="form-control" placeholder="Número de días">
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("estudioSeguridad",1,null,["id"=>"estudioSeguridad"]) !!} ¿Estudio seguridad?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="estudioSeguridadOculto">
                                        <label>
                                            Días estudio seguridad
                                        </label>
                                        <input name="estudioSeguridadDias" type="number" class="form-control" placeholder="Número de días">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 text-right">
                <a class="btn btn-default" href="#" onclick="window.history.back()">Volver</a>
                {!! FuncionesGlobales::valida_boton_req("admin.cargos_especificos.actualizar", "Guardar", "boton", "btn btn-success btn-guardar-cargo") !!}
            </div>

            {{-- Para configuración BRYG --}}
            <input type="hidden" name="bryg_configuracion" id="brygConfiguracionId">

            {{-- Para configuración Prueba  de Valores --}}
            <input type="hidden" name="prueba_valores_1" id="pruebaValoresId">

            <input type="hidden" name="competencias_configuracion" id="competenciasConfiguracionIds">
        {!! Form::close() !!}
    </div>

    @include('admin.bryg._modal_configuracion_cuadrantes')
    @include('admin.prueba_valores_1._modal_configuracion_prueba_valores1')

    {{-- Configuración BRYG --}}
    <script src="{{ asset('js/admin/bryg-scripts/_js_configuracion_cuadrantes.js') }}"></script>

    {{-- Configuración BRYG --}}
    <script src="{{ asset('js/admin/prueba-valores-scripts/_js_configuracion_prueba_valores.js') }}"></script>

    {{-- Guardar configuración BRYG --}}
    <script type="text/javascript">
        //Mostrar modal de configuración BRYG
        const configurarCargoBRYG = (obj, route) => {
            $('#brygConfiguracionCuadrantes').modal('show')
        }

        const guardarConfiguracionCargoBryg = (obj, route) => {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    cargo_modulo: true,
                    radical: valoresGrafico.radical,
                    genuino: valoresGrafico.genuino,
                    garante: valoresGrafico.garante,
                    basico: valoresGrafico.basico,
                    perfil: perfilGlobal
                },
                beforeSend: function() {
                    obj.setAttribute('disabled', true)
                },
                success: function(response) {
                    //Asigna id de la configuración al campo
                    document.querySelector('#brygConfiguracionId').value = response.configuracionId
                    console.log(response.configuracionId)

                    $.smkAlert({text: 'Configuración guardada con éxito. <b>Debes continuar con la creación del cargo.</b>', type: 'success'})
                    obj.removeAttribute('disabled')

                    setTimeout(() => {
                        $('#brygConfiguracionCuadrantes').modal('hide')
                    }, 800)
                }
            })
        }

        //Prueba competencias
        const configurarCargoCompetencias = (obj, route) => {
            let cargosGenericoId = document.querySelector('#cargosGenericoId').value

            $.ajax({
                type: 'POST',
                data: {
                    cargo_generico_id: cargosGenericoId
                },
                url: route,
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        }

        const guardarConfiguracionCargoCompetencias = (obj, route) => {
            $.ajax({
                type: 'POST',
                url: route,
                data: $('#frmConfiguracionCompetencias').serialize(),
                beforeSend: function() {
                    obj.setAttribute('disabled', true)
                },
                success: function(response) {
                    console.log(response)
                    document.querySelector('#competenciasConfiguracionIds').value = response.ids

                    $.smkAlert({text: 'Configuración guardada con éxito. <b>Debes continuar con la creación del cargo.</b>', type: 'success'})
                    obj.removeAttribute('disabled')

                    setTimeout(() => {
                        $('#modal_gr').modal('hide')
                    }, 800)
                }
            })
        }

        const configurarPruebaValores = (obj, route) => {
            $('#pruebaValores1Configuracion').modal('show')
        }

        const guardarConfiguracionPruebaValores = (obj, route) => {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    cargo_modulo: true,
                    valor_verdad: valoresIdealPruebaValores.verdad,
                    valor_rectitud: valoresIdealPruebaValores.rectitud,
                    valor_amor: valoresIdealPruebaValores.amor,
                    valor_paz: valoresIdealPruebaValores.paz,
                    valor_no_violencia: valoresIdealPruebaValores.no_violencia
                },
                beforeSend: function() {
                    obj.setAttribute('disabled', true)
                },
                success: function(response) {
                    //Asigna id de la configuración al campo
                    document.querySelector('#pruebaValoresId').value = response.configuracionId
                    console.log(response.configuracionId)

                    $.smkAlert({text: 'Configuración guardada con éxito. <b>Debes continuar con la creación del cargo.</b>', type: 'success'})
                    obj.removeAttribute('disabled')

                    setTimeout(() => {
                        $('#pruebaValores1Configuracion').modal('hide')
                    }, 800)
                }
            })
        }

        //
        $(document).on("change", ".contratacion-clausulas", function () {
            let campoValor = $(this).parents('.item_adicional').find('.valor_adicional').eq(0);

            if($(this).prop('checked')) {
                campoValor.attr("placeholder", "Valor variable");
                campoValor.attr('disabled', false);
            }else {
                //campoValor.val("");
                campoValor.attr("placeholder", "");
                campoValor.attr("disabled", true);
            }
        });
    </script>

    @if ($sitio->asistente_contratacion == 1)
        <script>
            $("#cliente_select").change((event) => {
                let cliente_id = event.currentTarget.value

                $.ajax({
                    url: "{{ route('admin.listar_adicionales_cliente') }}",
                    type: 'POST',
                    data: {
                        cliente_id : cliente_id
                    },
                    success: (response) => {
                        document.querySelector('#adicionales_box').innerHTML = response.adicionales_tabla
                    }
                })
            })
        </script>
    @endif

    <script type="text/javascript">
        @if($sitio->asistente_contratacion == 1)
            const $firma_digital = document.querySelector('#firma_digital');
            const $videos_box = document.querySelector('#videos_box');
            const $video_con = document.querySelector('#videos_contratacion');

            //$videos_box.style.display = 'none';

            $firma_digital.addEventListener('change', (e) => {
                if (e.target.value == 1) {
                    $videos_box.style.display = 'initial';
                    $video_con.value = 1;
                }

                if (e.target.value == 0) {
                    $videos_box.style.display = 'none';
                    $video_con.value = 0;
                    // console.log($video_con.value);
                }
            })
        @endif

        $(".solo-numero").keydown(function(event) {
            if(event.shiftKey){
                event.preventDefault();
            }
            
            if (event.keyCode == 46 || event.keyCode == 8){
            }
            else{
                if (event.keyCode < 95) {
                    if(event.keyCode < 48 || event.keyCode > 57) {
                     event.preventDefault();
                    }
                } 
                else {
                    if(event.keyCode < 96 || event.keyCode > 105) {
                      event.preventDefault();
                    }
                }
            }
        });

        $("#plazo_req").attr("readonly","true");

        $("#tipo_cargo").change(function(){
            if($(this).val()!=""){
                var valor=$(this).val();
                
                switch (valor) {
                    case "1":
                        $("#plazo_req").val(62);
                    break;

                    case "2":
                        $("#plazo_req").val(36);
                    break;

                    case "3":
                        $("#plazo_req").val(43);
                    break;

                    case "4":
                        $("#plazo_req").val(59);
                    break;
                }
            }
        });

        $("#crear_preg").on("click", function (){
            var req_id = $(this).data("req");
            var cargo_id = $(this).data("cargo_id");

            $.ajax({
                data: {req_id: req_id,cargo_id: cargo_id},
                url: "{{route('admin.crear_pregunta_req')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $("#seleccionar_todos_c").on("change", function () {
            var obj = $(this);
            $(".contratacion-d").prop("checked", obj.prop("checked"));
        })

        $("#seleccionar_todos_clausulas").on("change", function () {
            let obj = $(this);
            let checkAdicionales = $(".contratacion-clausulas")

            $(".contratacion-clausulas").prop("checked", obj.prop("checked"));

            for (let index = 0; index < checkAdicionales.length; index++) {
                let campo = $(`#${checkAdicionales[index]['id']}`).parents('.item_adicional').find('#valor_adicional').eq(0)
                //let campo = checkAdicionales[index].parents('.item_adicional').find('#valor_adicional').eq(0);

                if(checkAdicionales[index]['checked']) {
                    //campo.attr("placeholder", "Ingrese código");
                    campo.attr('disabled' ,false);
                }else {
                    campo.val("");
                    campo.attr("placeholder", "Valor variable");
                    campo.attr("disabled", true);
                }
            }
        })

        $("#seleccionar_todos_s").on("change", function () {
            var obj = $(this);
            $(".seleccion-d").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_p").on("change", function () {
            var obj = $(this);
            $(".postcontratacion-d").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_e").on("change", function () {
            var obj = $(this);
            $(".examenes_cargo").prop("checked", obj.prop("checked"));
        });

        $('#check_adicionales').change(function(){
            let campo = $(this).parents('.item_adicional').find('#valor_adicional').eq(0);

            if($(this).prop('checked')) {
                //campo.attr("placeholder", "Ingrese código");
                campo.attr('disabled' ,false);
            }else {
                campo.val("");
                campo.attr("placeholder", "Valor variable");
                campo.attr("disabled", true);
            }
        });

        $("#excel_basico").on("change", function () {
            var obj = $(this);
            if (obj.prop("checked")) {
                $(".porcentaje-excel-basico").show();
                $("#aprobacion_excel_basico").prop('required', 'required');
                $("#tiempo_excel_basico").prop('required', 'required');
            } else {
                $(".porcentaje-excel-basico").hide();
                $("#aprobacion_excel_basico").removeAttr('required');
                $("#tiempo_excel_basico").removeAttr('required');
            }
        });

        $("#excel_intermedio").on("change", function () {
            var obj = $(this);
            if (obj.prop("checked")) {
                $(".porcentaje-excel-intermedio").show();
                $("#aprobacion_excel_intermedio").prop('required', 'required');
                $("#tiempo_excel_intermedio").prop('required', 'required');
            } else {
                $(".porcentaje-excel-intermedio").hide();
                $("#aprobacion_excel_intermedio").removeAttr('required');
                $("#tiempo_excel_intermedio").removeAttr('required');
            }
        });

        $(document).on("click", "#guardar_preg", function () {
            $(this).prop("disabled", false)

            $.ajax({
                type: "POST",
                data: $("#fr_preg").serialize(),
                url: "{{ route('admin.guardar_pregunta_cargo') }}",
                success: function (data) {
                    $("#modal_gr").modal("hide");
                    mensaje_success("Pregunta creada con éxito!!");
                }
            });
        });

        $(function(){
            $(".estudioSeguridadOculto").hide();
            $(".examenMedicoOculto").hide();

            $('#estudioSeguridad').change(function(){
                if(!$(this).prop('checked')){
                    $('.estudioSeguridadOculto').hide();
                }else{
                    $('.estudioSeguridadOculto').show();
                }
            })

            $('#examesMedicos').change(function(){
                if(!$(this).prop('checked')){
                    $('.examenMedicoOculto').hide();
                }else{
                    $('.examenMedicoOculto').show();
                }
            })

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            $('.btn-guardar-cargo').click(function() {
                $("#error-excel-basico").hide();
                $("#error-excel-intermedio").hide();
                $("#error-tiempo-excel-basico").hide();
                $("#error-tiempo-excel-intermedio").hide();
                if($('#fr_cargos_especificos').smkValidate()) {
                    if($("#excel_basico").prop("checked") && ($("#aprobacion_excel_basico").val() < 10 || $("#aprobacion_excel_basico").val() > 100) ) {
                        $("#error-excel-basico").show();
                        return false;
                    }
                    if($("#excel_intermedio").prop("checked") && ($("#aprobacion_excel_intermedio").val() < 10 || $("#aprobacion_excel_intermedio").val() > 100)) {
                        $("#error-excel-intermedio").show();
                        return false;
                    }
                    if($("#excel_basico").prop("checked") && ($("#tiempo_excel_basico").val() < 10 || $("#tiempo_excel_basico").val() > 45) ) {
                        $("#error-tiempo-excel-basico").show();
                        return false;
                    }
                    if($("#excel_intermedio").prop("checked") && ($("#tiempo_excel_intermedio").val() < 10 || $("#tiempo_excel_intermedio").val() > 45)) {
                        $("#error-tiempo-excel-intermedio").show();
                        return false;
                    }
                    $('.btn-guardar-cargo').hide();
                    $('#fr_cargos_especificos').submit();
                }
            });
        });
    </script>
@stop
