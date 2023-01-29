<style type="text/css">
    .py-0 { padding-bottom: 0px; padding-top: 0px; }

    .scroll-doc { max-height: 300px; overflow: scroll; }

    .mb-2 { margin-bottom: 0.5rem; }

    .mb-0 { margin-bottom: 0px; }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Crear nuevo cargo cliente</h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(["id" => "fr_cargos_especificos", "method" => "POST", "files" => true]) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="descripcion">Nombre del cargo <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::text("descripcion", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nombre del cargo", "required" => "required"]); !!}
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="control-label" for="cargo_generico_id">Cargo Genérico <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select("cargo_generico_id", $cargosGenericos, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required" => "required"]); !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="clt_codigo">Cliente <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::select('clt_codigo', $clientes, null, ['class' => 'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', "id" => "cliente_select", "required" => "required"]) !!}
                    </div>
                </div>

                {{-- Validación de contratación virtual --}}
                @if($sitio->asistente_contratacion == 1)
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="control-label" for="firma_digital">Contratación virtual <span class='text-danger sm-text-label'>*</span></label>
                            {!! Form::select("firma_digital", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "firma_digital", "required" => "required"]); !!}
                        </div>

                        <div class="col-md-6 form-group" id="videos_box">
                            <label class="control-label" for="videos_contratacion">¿Video confirmación? <span class='text-danger sm-text-label'>*</span></label>
                            {!! Form::select("videos_contratacion", [1 => "Si", 0 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "videos_contratacion"]); !!}
                        </div>
                    </div>
                @endif

                @include('admin.cargos_especificos.include._panel_perfil_cargo')

                {{-- Validación de contratación virtual --}}
                @if($sitio->asistente_contratacion == 1)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <h3>Adicionales</h3>

                                <div id="accordion">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <a data-toggle="collapse" data-target="#collapseUno" aria-expanded="true" aria-controls="collapseUno" style="cursor: pointer;">
                                                <h3 class="panel-title text-white">
                                                    Cláusula
                                                </h3>
                                            </a>
                                        </div>
                                        <div id="collapseUno" class="collapse in" aria-labelledby="headingUno" data-parent="#accordion">
                                            <div class="panel-body py-0">
                                                <div class="checkbox">
                                                    <label>
                                                        {!! Form::checkbox("seleccionar_todos", null, true, ["id" => "seleccionar_todos_clausulas"]) !!} Seleccionar todos
                                                    </label>
                                                </div>

                                                {{-- @foreach($adicionales as $ad)
                                                    <div class="col-md-12">
                                                        <label style="font-size: 13px;">
                                                            <input type="checkbox" class="contratacion-clausulas" name="clausulas[]" value="{{$ad->id}}" {{ ($ad->default) ? 'checked' : '' }}>
                                                            {{ $ad->descripcion }}
                                                        </label>
                                                    </div>
                                                @endforeach --}}

                                                <div id="adicionales_box">
                                                    @include('admin.cargos_especificos.include._table_lista_adicionales')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <h3>Documentos</h3>

                                <div class="panel-group" id="accordion-documentos" role="tablist" aria-multiselectable="true">
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

                                    {{-- Solo Osya
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox("asume", 1, false, ["id" => "asume"]) !!} {{FuncionesGlobales::sitio()->nombre}} Asume los examenes ?
                                            </label>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Formulario para la instancia VYM, configuración de fechas --}}
                @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co")
                    <br><br>
                    <div class="row">
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
                    </div>
                @endif

                <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn-guardar-cargo">Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

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
            }
        })
    @endif

    $("#seleccionar_todos_c").on("change", function () {
        var obj = $(this);
        $(".contratacion-d").prop("checked", obj.prop("checked"));
    })

    $("#seleccionar_todos_clausulas").on("change", function () {
        var obj = $(this);
        $(".contratacion-clausulas").prop("checked", obj.prop("checked"));
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

    $(document).on("change", "#check_adicionales", function() {
        let campo = $(this).parents('.item_adicional').find('#valor_adicional').eq(0);

        if($(this).prop('checked')) {
            //campo.attr("placeholder", "Ingrese código");
            campo.attr('disabled' ,false);
        }else {
            campo.val("");
            campo.attr("placeholder", "Valor variable");
            campo.attr("disabled", true);
        }
    })

    $(function() {
        
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

        $('#btn-guardar-cargo').click(function() {
            if($('#fr_cargos_especificos').smkValidate()){
                $('#btn-guardar-cargo').hide();
                let formData = new FormData(document.getElementById("fr_cargos_especificos"));
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('admin.cargos_especificos.guardar') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Guardando los datos.',
                            type: 'info'
                        });
                    },
                    error: function(){
                        $.smkAlert({
                            text: 'Ha ocurrido un error guardando los datos. Verifique e intente nuevamente.',
                            type: 'danger'
                        });
                        $('#btn-guardar-cargo').show();
                    },
                    success: function(response){
                        if(response.success) {
                            $("#modalTriLarge").modal("hide");

                            swal("Cargo creado con éxito.", "Puede continuar con el registro del requerimiento", "success");

                            let $option = $('<option />', {
                                text: response.nuevo_cargo.descripcion + ' - 0',
                                value: response.nuevo_cargo.id,
                            });

                            $('#cargo_especifico_id').append($option);
                            $('#cargo_especifico_id').val(response.nuevo_cargo.id);
                            $('#cargo_especifico_id').trigger('change');
                        } else {
                            $.smkAlert({
                                text: response.mensaje_success,
                                type: 'danger'
                            });
                            $('#btn-guardar-cargo').show();
                        }
                    }
                });
            }
        })
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