<style type="text/css">
    .py-0 { padding-bottom: 0px; padding-top: 0px; }

    .scroll-doc { max-height: 300px; overflow: scroll; }

    .mb-2 { margin-bottom: 0.5rem; }

    .mb-0 { margin-bottom: 0px; }
</style>

<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>

    <h4 class="modal-title">
        Editar cargo específico
    </h4>
</div>

<div class="modal-body">
    {!! Form::model($registro, ["id" => "fr_cargos_especificos", "route" => "admin.cargos_especificos.actualizar", "method" => "POST", "files" => true]) !!}
        {!! Form::hidden("id", $registro->id, ["id" => "cargo_id"]) !!}
        
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label for="active">
                            {!! Form::checkbox("active", 1, null, ["id" => "active"]) !!} 
                            <strong>Activo</strong>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">Nombre del cargo: </label>
                        
                        {!! Form::text("descripcion", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "descripcion","required"=>true]); !!}
                        
                    </div>
                
                </div>

                <div class="col-md-6 ">
                    <div class="form-group">
                    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                        <label class="control-label" for="inputEmail3">Área Laboral:</label>
                    @else
                        <label class="control-label" for="inputEmail3">Cargo Genérico:</label>
                    @endif

                    {!! Form::select("cargo_generico_id", $cargosGenericos, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","required"=>true]); !!}
                    </div>
        
                    

                </div>
            </div>

           

            @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                <div class="col-md-12 form-group">
                    <label class="col-sm-2 control-label" for="inputEmail3">Plazo en días</label>

                    <div class="col-sm-10">
                        {!! Form::number("plazo_req", null, ["class" => "form-control", "id" => "plazo_req"]) !!}
                    </div>
                </div>        
            @else
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3"> Cliente</label>

                        
                            {!! Form::select("clt_codigo", $clientes, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cliente_select","required"=>true]); !!}
                        
                    </div>
                    
                </div>
            </div>

            @endif

            {{-- Validación de contratacion virtual --}}
            @if($sitio->asistente_contratacion == 1)
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="firma_digital">Contratación virtual *</label>
                        
                            {!! Form::select("firma_digital", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "firma_digital"]); !!}
                        
                    </div>
     
                </div>

                <div class="col-md-6" id="videos_box">
                    <div class="form-group">
                        <label class="control-label" for="videos_contratacion">¿Video confirmación? *</label>

                            {!! Form::select("videos_contratacion", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "videos_contratacion"]); !!}
                        
                    </div>
                   

                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("videos_contratacion", $errors) !!}
                    </p>
                </div>
            </div>
            @endif

            <!-- Formulario para la instancia VYM, configuración de fechas -->
            @if(route('home') == "https://vym.t3rsc.co/" || route('home') == "http://vym.t3rsc.co/")
                <div class="col-md-12">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Parametrización tiempo</h3>
                            <br/>
                            
                            <small>Nota: 
                                <cite title="Source Title">
                                    Configurar tiempo segun la cantidad de vacantes a solicitar, con esto al momento de crear un requerimiento se adicionan los días configurados a la fecha de ingreso.'
                                </cite>
                            </small>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label>1 a 5 vacantes</label>
                                    {!! Form::text("menor5", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>6 a 10 vacantes</label>
                                    {!! Form::text("menor10", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>11 a 20 vacantes</label>
                                    {!! Form::text("menor20", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>21 a 30 vacantes</label>
                                    {!! Form::text("menor30", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>31 a 40 vacantes</label>
                                    {!! Form::text("menor40", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>41 a 50 vacantes</label>
                                    {!! Form::text("menor50", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label>51 a 70 vacantes</label>
                                    {!! Form::text("menor80", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                </div>

                                <div class="col-xs-3">
                                    <label> Tiempo de evaluación por cliente</label>
                                    {!! Form::text("tiempoEvaluacionCliente", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
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
                                            {!!Form::checkbox("examesMedicos", 1, null, ["id" => "examesMedicos"])!!} Exámenes médicos?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="examenMedicoOculto">
                                        <label>
                                            Días exámen médico
                                        </label>
                                        {!! Form::number("examenMedicoDias", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="checkbox">
                                        <label>
                                            {!!Form::checkbox("estudioSeguridad", 1, null, ["id" => "estudioSeguridad"])!!} Estudio seguridad?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="estudioSeguridadOculto">
                                        <label>
                                            Días estudio seguridad
                                        </label>
                                        {!! Form::number("estudioSeguridadDias", null, ["class" => "form-control", "placeholder" => "Número de días"]); !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12" style="display: none;">
                <h5 class="titulo1">Matriz ANS</h5>

                <table class="table table-bordered" id="tbl_ans">
                    <thead>
                        <tr>
                            <th>
                                @if(route("home")=="https://gpc.t3rsc.co")
                                    N°.Vacantes disponibles
                                @else
                                    Regla Vacantes
                                @endif
                            </th>

                            <th>Num Cand. a Enviar por vacante</th>
                            @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co")
                                <th>Dias de respuesta de Selección.</th>    
                            @else
                                <th>Num Días para presentar cand.</th>
                            @endif

                            <th>#</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($negocio_ans as $ans)
                            <?php $regla =explode('A', $ans->regla);?>

                            <tr>
                                <td class="col-md-4 clonar">
                                    <div class="col-md-4">
                                        <input type="number" min="1" value="{{$regla[0]}}" name="regla_de[]" class="form-control input_c">
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <h4>A</h4>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <input type="number" value="{{$regla[1]}}" min="1" name="regla_a[]" class="form-control input_d">
                                    </div>

                                    <div class="col-md-6 float-right">
                                        <p class="error text-danger direction-botones-center">(Ejemplo: 1A4)</p>
                                    </div>
                                </td>

                                <td class="col-md-4">
                                    <input type="number" value="{{$ans->num_cand_presentar_vac}}" name="num_cand_presentar_vac[]" class="form-control">
                                </td>

                                <td class="col-md-4">
                                    <input type="number" name="dias_presentar_candidatos_antes[]" value="{{$ans->cantidad_dias}}" class="form-control">
                                    <input type="hidden" name="cantidad_dias[]" class="form-control" value="0">
                                </td>

                                <td class="col-md-4"><button class="btn btn-danger eliminar-fila" data-id="{{$ans->id}}" type="button" >Eliminar</button></td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td class="col-md-4 clonar">
                                <div class="col-md-4">
                                    <input type="number" min="1" value="" name="regla_de[]" class="form-control input_c">
                                </div>

                                <div class="col-md-1">
                                    <h4>A</h4>
                                </div>

                                <div class="col-md-4">
                                    <input type="number" value="" min="1" name="regla_a[]" class="form-control input_d">
                                </div>

                                <div class="col-md-6 float-right">
                                    <p class="error text-danger direction-botones-center">(Ejemplo: 1A4)</p>
                                </div>
                            </td>

                            <td class="col-md-4">
                                <input type="number" value="" name="num_cand_presentar_vac[]" class="form-control">
                            </td>

                            <td class="col-md-4">
                                <input type="number" name="dias_presentar_candidatos_antes[]" value="" class="form-control">
                                <input type="hidden" name="cantidad_dias[]" class="form-control" value="0">
                            </td>

                            <td class="col-md-4"><button class="btn btn-info agregar_fila" type="button" >Agregar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if(route("home") == "https://vym.t3rsc.co")
                <div class="col-md-12">
                    <h5 class="titulo1" >Tiempos de entrega de candidatos</h5>

                    <table class="table table-bordered" id="tbl_ans">
                        <thead>
                            <tr>
                                <th>Rango Vacantes</th>
                                <th>Dias para envio</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td class="col-md-4 clonar">
                                    1 A 5
                                </td>
                                
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor5}}" name="menor5" class="form-control">
                                </td>   
                            </tr>
                            
                            <tr>
                                <td class="col-md-4 clonar">
                                    6 A 10
                                </td>
                                
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor10}}" name="menor10" class="form-control">
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="col-md-4 clonar">
                                    11 A 20
                                </td>           
                                
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor20}}" name="menor20" class="form-control">
                                </td>       
                            </tr>

                            <tr>
                                <td class="col-md-4 clonar">
                                    21 A 30
                                </td>
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor30}}" name="menor30" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-4 clonar">
                                    31 A 40
                                </td>
                                
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor40}}" name="menor40" class="form-control">
                                </td>       
                            </tr>

                            <tr>
                                <td class="col-md-4 clonar">
                                    41 A 50      
                                </td>
        
                                <td class="col-md-4">
                                    <input type="number" value="{{$registro->menor50}}" name="menor50" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-4 clonar">
                                    51 A 80
                                </td>        
                                
                                <td class="col-md-4">
                                    <input type="numbeqr" value="{{$registro->menor80}}" name="menor80" class="form-control">
                                </td>       
                            </tr>    
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @include('admin.cargos_especificos.include._panel_perfil_cargo')

        @if($sitio->asistente_contratacion == 1)
            <div>
                <div class="col-md-12">
                    <h4>Documentos</h4>

                    <div class="panel-group" id="accordion-documentos" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="collapsed" data-toggle="collapse" data-target="#collapseAdicionales" aria-expanded="true" aria-controls="collapseAdicionales" style="cursor: pointer;">
                                    <h3 class="panel-title text-white">
                                        Adicionales
                                    </h3>
                                </a>
                            </div>

                            <div id="collapseAdicionales" class="collapse" aria-labelledby="headingAdicional" data-parent="#accordion-documentos">
                                <div class="panel-body py-0 scroll-doc">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos_clausulas"]) !!} Seleccionar todos
                                        </label>
                                    </div>

                                    <div id="adicionales_box">
                                        @include('admin.cargos_especificos.include._table_lista_adicionales_editar')
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            <div class="col-md-6">
                                                <label style="font-size: 13px;">
                                                    <input type="checkbox" class="contratacion-d" name="documento[]" value="{{ $tipo->id }}" id="documento-contratacion" @if(in_array($tipo->id,$registro->tipos_documentos->pluck("id")->toArray())) checked @endif>
                                                    {{ $tipo->descripcion }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

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
                                            <div class="col-md-6">
                                                <label style="font-size: 13px;">
                                                    <input type="checkbox" class="seleccion-d" name="documento[]" value="{{ $tipo->id }}" id="documento-seleccion" @if(in_array($tipo->id,$registro->tipos_documentos->pluck("id")->toArray())) checked @endif >
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
                                                    <input type="checkbox" class="postcontratacion-d" id="documento-post" name="documento[]" value="{{$tipo->id}}" @if(in_array($tipo->id,$registro->tipos_documentos->pluck("id")->toArray())) checked @endif>
                                                    {{ $tipo->descripcion }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

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
                                    @foreach($tipos_examenes as $tipoe)
                                        <div class="col-md-6">
                                            <label style="font-size: 13px;">
                                                <input type="checkbox" class="examenes_cargo" name="examen[]" value="{{ $tipoe->id }}" id="documento-examen" @if(in_array($tipoe->id,$registro->examenes->pluck("id")->toArray())) checked @endif>
                                                {{ $tipoe->nombre }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Solo Osya
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>{!! Form::checkbox("asume", 1,($registro->asume_examenes), ["id" => "asume"]) !!} {{FuncionesGlobales::sitio()->nombre}} Asume los examenes ?</label>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
        @endif

        {{-- Configuración prueba digitación 
        @if($sitioModulo->prueba_digitacion == 'enabled')
            <div class="panel panel-default" style="margin-top: 1rem;">
                <div class="panel-body">
                    <div class="col-md-12" style="margin-bottom: 1rem;">
                        <h4>Configuración para prueba digitación</h4>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ppmEsperada" class="control-label">Palabras por minuto</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                name="ppm_esperada" 
                                id="ppmEsperada" 
                                placeholder="Ingresa las palabras por minuto esperadas"

                                value="{{ $digitacionCargo->ppm_esperada }}" 
                            >

                            <small>
                                <a href="https://es.wikipedia.org/wiki/Palabras_por_minuto" target="_blank">Información adicional (PPM)</a>
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ppmEsperada">Precisión esperada %</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                name="precision_esperada" 
                                id="precisionEsperada" 
                                placeholder="Ingresa el porcentaje de precisión esperado"

                                value="{{ $digitacionCargo->precision_esperada }}" 
                            >
                        </div>
                    </div>
                </div>
            </div>
        @endif--}}
    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close"></i>
        Cerrar
    </button>

    <button class="btn btn-success" form="fr_cargos_especificos" id="btn-actualizar" type="button">
      <i class="fa fa-check"></i>
        Actualizar
    </button>

    {{-- <button class="btn btn-primary crear_preg" data-cargo_id="{{$cargo_id}}" id="crear_preg" style="text-align: left;" type="button">
        Crear Pregunta
    </button> --}}
</div>

<script>

    if(!$("#estudioSeguridad").prop('checked')){
        $('.estudioSeguridadOculto').hide();
    }else{
        $('.estudioSeguridadOculto').show();
    }

    if(!$("#examesMedicos").prop('checked')){
        $('.examenMedicoOculto').hide();
    }else{
        $('.examenMedicoOculto').show();
    }

    $(function(){
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
                    console.log($video_con.value);
                    
                }
            })
        @endif

        $("#seleccionar_todos_c").on("change", function () {
            var obj = $(this);
            $("input[id='documento-contratacion']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_s").on("change", function () {
            var obj = $(this);
            $("input[id='documento-seleccion']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_p").on("change", function () {
            var obj = $(this);
            $("input[id='documento-post']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_e").on("change", function () {
            var obj = $(this);
            $("input[id='documento-examen']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos_clausulas").on("change", function () {
            var obj = $(this);
            $("input[id='check_adicionales']").prop("checked", obj.prop("checked"));
        });
        
        $('.contratacion-clausulas').change(function() {
            let campo = $(this).parents('.item_adicional').find('.valor_adicional').eq(0);

            if($(this).prop('checked')) {
                //campo.attr("placeholder", "Ingrese código");
                campo.attr('disabled' ,false);
            }else {
                campo.val("");
                campo.attr("placeholder", "Valor variable");
                campo.attr("disabled", true);
            }
        });

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

        //Actualizar cargo generico
        $("#btn-actualizar").on('click', function(){
            if($('#fr_cargos_especificos').smkValidate()) {
                $("#btn-actualizar").hide();
                let formData = new FormData(document.getElementById("fr_cargos_especificos"));
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('admin.cargos_especificos.actualizar') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
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
                    success: function(response){
                        $.unblockUI();
                        if (response.success) {
                            $("#modal_gr").modal('toggle');
                            swal("Bien","Cargo especifico actualizado","success");
                            setTimeout('document.location.reload()',4000);
                            location.reload();
                        } else {
                            $("#btn-actualizar").show();
                            $.smkAlert({
                                text: response.mensaje_success,
                                type: 'danger'
                            });
                        }
                    }
                });
            }   
        });

        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" || route('home') == "http://demo.t3rsc.co")
            $(document).on("click", ".agregar_fila", function () {
                $(this).removeClass("btn-info agregar_fila").addClass("btn-danger eliminar-fila").html("Eliminar");
                var tr = $("<tr></tr>");

                c = $('.clonar:last').clone();
                c.children('div').children('.input_c').val('');
                c.children('div').children('.input_d').val('');

                c.appendTo(tr);
                
                $("<td/>").append($("<input/>", {class: "form-control", name: "num_cand_presentar_vac[]"})).appendTo(tr);
                $("<td/>").append($("<input/>", {class: "form-control", name: "dias_presentar_candidatos_antes[]"}))
                .append($("<input/>", {type:"hidden",class: "form-control", name: "cantidad_dias[]", value:0})).appendTo(tr);
            
                $("<td/>").append($("<button/>", {class: "btn btn-info agregar_fila ", text: "Agregar", type: "button"})).appendTo(tr);

                $("#tbl_ans tbody").append(tr);
                console.log(cantidad_final.val());
                console.log(tr);
            });

            $(document).on("click", ".eliminar-fila", function () {
                var data_id = $(this).data("id");
                var objtr = $(this).parents("tr");
                
                if (typeof data_id != "undefined") {
                    $.ajax({
                        type: "POST",
                        data: {"ans_id": data_id},
                        url: "{{ route('admin.eliminar_ans') }}",
                        success: function (success) {
                        alert('ANS removido');
                        }
                    });
                }

                $(this).parents("tr").remove();
            });
        @endif
    })
</script>

@if ($sitio->asistente_contratacion == 1)
    <script>
        $("#cliente_select").change((event) => {
            let cliente_id = event.currentTarget.value
            let cargo_id = document.querySelector('#cargo_id').value

            $.ajax({
                url: "{{ route('admin.listar_adicionales_cliente') }}",
                type: 'POST',
                data: {
                    cliente_id : cliente_id,
                    cargo_id: cargo_id,
                    editar: true
                },
                success: (response) => {
                    document.querySelector('#adicionales_box').innerHTML = response.adicionales_tabla
                }
            })
        })
    </script>
@endif