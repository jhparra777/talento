{{-- Estudios --}}
<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-fs-20">
            <span data-toggle="tooltip" data-placement="top" title="Por favor relacione todos los estudios realizados, empezando por el más reciente."><i class="fa fa-info-circle" aria-hidden="true"></i></span> 
            {{ (route('home') == "https://gpc.t3rsc.co") ? 'Formación académica' : 'Mis Estudios' }} 
            <small>Los campos con asterisco (*) son obligatorios.</small>
        </h4>
    </div>
</div>

<div class="row" id="container_estudios">
    <div class="col-md-12" id="info-adicional">
        <div class="panel panel-default">
            <div class="panel-heading | tri-bg--none" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" href="#collapseEstudios" aria-expanded="true" aria-controls="collapseEstudios">
                        Información estudio
                    </a>

                    <a class="pull-right" role="button" data-toggle="collapse" href="#collapseEstudios" aria-expanded="true" aria-controls="collapseEstudios">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                </h4>
            </div>

            <div id="collapseEstudios" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    {{-- Formulario estudios --}}
                    {!! Form::open(["route" => ["admin.hv_actualizada",$datos->basicos->user_id], "class" => "form-datos-basicos", "role" => "form", "id" => "fr_estudios"])!!}
                        {!! Form::hidden("user_id",$datos_basicos->user_id) !!}
                        {!! Form::hidden("numero_id", $datos_basicos->numero_id) !!}
                        {!! Form::hidden("id", null, ["class" => "id_modificar_datos", "id" => "id_modificar_datos"]) !!}

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="tiene_estudio">
                                        {!! Form::checkbox("tiene_estudio", 0, isset($datos_basicos->tiene_estudio) && $datos_basicos->tiene_estudio == "0" ? 1 : null, [
                                            "class" => "tiene_estudio",
                                            "id" => "tiene_estudio",
                                        ]) !!} No tengo estudios certificados
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    ¿Estudio actual?
                                </label>
                            
                                {!! Form::select("estudio_actual", ["0" => "No", "1" => "Si"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "estudio_actual"]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="institucion">Institución: <span class='text-danger sm-text-label'>*</span></label>

                                {!! Form::text("institucion", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                    "placeholder" => "Institución",
                                    "id" => "institucion",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo_obtenido">Titulo obtenido: <span class='text-danger sm-text-label'>*</span></label>
            
                                {!! Form::text("titulo_obtenido", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "id" => "titulo_obtenido", 
                                    "placeholder" => "Titulo obtenido",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    @if(route('home') == "https://gpc.t3rsc.co")
                                        Ciudad estudio: 
                                    @else 
                                        Ciudad: 
                                    @endif
                                    <span class="text-danger">*</span>
                                </label>
                            
                                {!! Form::hidden("pais_estudio", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "pais_estudio"]) !!}
                                {!! Form::hidden("ciudad_estudio", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_estudio"]) !!}
                                {!! Form::hidden("departamento_estudio",null,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id" => "departamento_estudio"]) !!}
            
                                {!! Form::text("ciudad_autocomplete", null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "id" => "ciudad_autocomplete_estu", 
                                    "placeholder" => "Digita ciudad",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nivel_estudio_id">Nivel estudios: <span class='text-danger sm-text-label'>*</span></label>
            
                                {!! Form::select("nivel_estudio_id", $nivelEstudios, null, [
                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                    "id" => "nivel_estudio_id",
                                    "required" => "required"
                                ]) !!}
                            </div>
                        </div>

                        @if(route("home") != "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="semestres_cursados">Períodos cursados:</label>
            
                                    {!! Form::select("semestres_cursados", [0 => "Seleccionar", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15], null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "semestres_cursados"
                                    ]) !!}
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="periodicidad">
                                    Periodicidad:   
                                </label>

                                {!! Form::select("periodicidad", $periodicidad, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "periodicidad"]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_finalizacion">
                                    Fecha finalización:
                                </label>
            
                                @if(route('home') != "https://gpc.t3rsc.co")
                                    {!! Form::text("fecha_finalizacion", null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Fecha finalización",
                                        "id" => "fecha_finalizacion"
                                    ]) !!}
                                @else
                                    {!! Form::date("fecha_finalizacion", null, [
                                        "max" => date('Y-m-d'),
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "placeholder" => "Fecha finalización",
                                        "id" => "fecha_finalizacion"
                                    ]) !!}
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="acta">
                                    Acta:   
                                </label>

                                {!! Form::text("acta", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "acta"]) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="folio">
                                    Folio:   
                                </label>

                                {!! Form::text("folio", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "folio"]) !!}
                            </div>
                        </div>
            
                        @if(route("home") == "https://gpc.t3rsc.co")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="semestres_cursados">Estatus de formación académica: *</label>
            
                                    {!! Form::select("estatus_academico", ["" => "Seleccionar", 'Abandono' => "Abandono", 'Egresado' => "Egresado", 'en curso' => "En Curso", "Graduado" => "Graduado", 'otro' => "otro"], null, [
                                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                        "id" => "estatus_academico",
                                        "required" => "required"
                                    ]) !!}
                                </div>
                            </div>
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="termino_estudios">
                                            {!! Form::checkbox("termino_estudios", 1, null, ["id" => "termino_estudios"]) !!} Terminó estudios
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                        @endif
            
                        @if(route('home') != "https://gpc.t3rsc.co")
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="estudio_actual">
                                            {!! Form::checkbox("estudio_actual", 1, null, ["id" => "estudio_actual"]) !!} ¿Estudia actualmente?
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                        @endif

                        {{-- Botones --}}
                        <div class="col-md-12 text-right">
                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                type="button" 
                                id="actualizar_estudios" 
                                style="display: none;">
                                Actualizar estudios
                            </button>

                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-200 tri-hover-out-red" 
                                type="button" 
                                id="cancelar_estudios" 
                                style="display: none;">
                                Cancelar
                            </button>

                            <button 
                                class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" 
                                type="button" 
                                id="guardar_estudios">
                                Guardar estudios
                            </button>
                        </div>
                    {!! Form::close() !!}

                    {{-- Lista de estudios (Tabla) --}}
                    {!! Form::open(["id" => "grilla_datos_estudio"]) !!}
                        <div class="col-md-12 mt-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center" id="tbl_estudios">
                                    <thead>
                                        <tr>
                                            <th>Titulo obtenido</th>
                                            <th>Institución</th>
                                            <th>Nivel estudio</th>

                                            @if(route('home') != "https://gpc.t3rsc.co")
                                                <th>Estudio actual</th>
                                            @endif

                                            <th>Fecha finalización</th>

                                            @if(route('home') == "https://gpc.t3rsc.co")
                                                <th>Estatus</th>
                                            @endif

                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($estudios as $estudio)
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
                                                    {!! Form::hidden("id", $estudio->id, ["id" => $estudio->id]) !!}
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-default btn-peq certificados_estudios disabled_estudio | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                                        Certificados <i class="fa fa-file-text-o"></i>
                                                    </button>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-default btn-peq editar_estudio_p disabled_estudio | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple">
                                                        Editar <i class="fa fa-pencil"></i>
                                                    </button>

                                                    <button 
                                                        type="button" 
                                                        class="btn btn-danger btn-peq eliminar_estudio_p disabled_estudio | tri-br-2 tri-txt-red tri-bg-white tri-bd-red tri-transition-300 tri-hover-out-red">
                                                        Eliminar <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="registro_nulo">
                                                <td colspan="6">No  hay registros</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>