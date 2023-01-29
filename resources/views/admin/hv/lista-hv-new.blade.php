@extends("admin.layout.master")
@section("contenedor")
    <style>
        .dropdown-menu{ left: -80px !important; padding: 0 !important; }
    </style>

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => (route("home") == "https://humannet.t3rsc.co") ? "Currículos" : "Hojas de vida"])

    <div class="row">
        {{-- <div class="col-md-12 mb-2">
            @if(route("home") == "https://humannet.t3rsc.co")
                <h3>Currículos</h3>
            @else
                <h3>Hojas de Vida</h3>
            @endif
        </div> --}}

        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        {!! Form::model(Request::all(), ["id" => "admin.lista_hv_admin", "method" => "GET"]) !!}
            <div class="col-md-6 col-lg-6 form-group">
                <label for="palabra_clave">Nombre, email:</label>

                {!! Form::text("palabra_clave", null, [
                    "id" => "palabra_clave",
                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "placeholder" => "Escriba nombre o email"
                ]); !!}
            </div>

            <div class="col-md-6 col-lg-6 form-group">
                <label for="inputEmail3">Cédula:</label>

                {!! Form::number("cedula", null, [
                    "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "placeholder" => "Número identificación"
                ]); !!}
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="ciudad_residencia">Ciudad residencia:</label>

                    {!! Form::hidden("pais_residencia", null, ["id" => "pais_residencia"]) !!}
                    {!! Form::hidden("departamento_residencia", null, ["id" => "departamento_residencia"]) !!}
                    {!! Form::hidden("ciudad_residencia", null, ["id" => "ciudad_residencia"]) !!}

                    {!! Form::text("txt_residencia", null, [
                        "id" => "txt_residencia",
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "placeholder" => "Ciudad residencia"
                    ]) !!}
                </div>
            </div>

            <div class="col-sm-6 col-lg-6 form-group">
                <label for="genero_id">Estado:</label>

                {!! Form::select("estado", array(
                        '' => 'Seleccionar',
                        'ACTIVO' => 'ACTIVO',
                        'BAJA VOLUNTARIA' => 'BAJA VOLUNTARIA',
                        'EN PROCESO CONTRATACION' => 'EN PROCESO CONTRATACION',
                        'EN PROCESO SELECCION' => 'EN PROCESO SELECCION',
                        'EVALUACION DEL CLIENTE' => 'EVALUACION DEL CLIENTE',
                        'INACTIVO' => 'INACTIVO',
                        'RECLUTAMIENTO' => 'RECLUTAMIENTO',
                        ), null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "genero_id"
                ]); !!}
            </div>

            <div class="col-md-12 text-right">
                <button class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-success | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green" href="{{ route("datos_basicos_admin") }}">
                    Nueva HV <i aria-hidden="true" class="fas fa-plus"></i>
                </a>

                <a class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{ route("admin.lista_hv_admin") }}">
                    Limpiar
                </a>
            </div>
        {!! Form::close() !!}

        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{-- <div class="table-responsive"> --}}
                        <table class="table table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>% HV</th>
                                    <th>Fecha creación</th>
                                    <th colspan="2">Acción</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @forelse($hojas_de_vida as $count => $lista)
                                    <?php
                                        $dado_baja = false;
                                        if ($lista->estado_reclutamiento === config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                                            $dado_baja = true;
                                        }
                                    ?>
                                    <tr>
                                        <td><b>{{ ++$count }}</b></td>
                                        <td>{{ $lista->numero_id }}</td>
                                        <td>{{ $lista->nombres }}</td>
                                        <td>{{ $lista->primer_apellido." ".$lista->segundo_apellido }}</td>
                                        <td>{{ $lista->email }}</td>
                                        <td>{{ $lista->telefono_fijo }}</td>
                                        <td>{{ $lista->telefono_movil }}</td>
                                        <td>{{ $lista->getUbicacion() }}</td>
                                        <td>{{ $lista->getEstado() }}</td>
                                        <td>
                                            <?php $porcentaje = FuncionesGlobales::porcentaje_hv($lista->user_id); ?>
                                            {{ $porcentaje["total"] }}%
                                        </td>
                                        <td>{{ $lista->created_at }}</td>
                                        <td colspan="2">
                                            <div class="btn-group-vertical">
                                                @if($user_sesion->hasAccess("boton_video_perfil"))
                                                    @if($lista->video != null )
                                                        <a
                                                            type="button"
                                                            class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            href='{{ route("ver_videoperfil", ["candidato" => $lista->user_id]) }}'
                                                            target="_blank" 
                                                            style="border-radius: 1rem 1rem 0rem 0rem;"
                                                        >
                                                            <i class="fas fa-video"></i> VIDEO PERFIL
                                                        </a>
                                                    @endif
                                                @endif

                                                @if(route("home") == "https://gpc.t3rsc.co")
                                                    <a
                                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        target="_blank"
                                                        href="{{ route("hv_pdf_tabla", ["user_id" => $lista->user_id]) }}"

                                                        @if(is_null($lista->video))
                                                            style="border-radius: 1rem 1rem 0rem 0rem;"
                                                        @endif
                                                    >
                                                        HOJA DE VIDA
                                                    </a>
                                                @elseif(route("home") == "https://humannet.t3rsc.co")
                                                    <a
                                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        target="_blank"
                                                        href="{{ route("admin.hv_pdf", ["user_id" => $lista->user_id]) }}"

                                                        @if(is_null($lista->video))
                                                            style="border-radius: 1rem 1rem 0rem 0rem;"
                                                        @endif
                                                    >
                                                        CURRÍCULO
                                                    </a>
                                                @else
                                                    <a
                                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        target="_blank"
                                                        href="{{ route("admin.hv_pdf", ["user_id" => $lista->user_id]) }}"

                                                        @if(is_null($lista->video))
                                                            style="border-radius: 1rem 1rem 0rem 0rem;"
                                                        @endif
                                                    >
                                                        HOJA DE VIDA
                                                    </a>
                                                @endif

                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"

                                                        style="border-radius: 0rem 0rem 1rem 1rem;"
                                                    >
                                                        OPCIONES <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu pd-0">
                                                        <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                            <button
                                                                type="button"
                                                                class="btn btn-default btn-sm btn-block mostrar_traza | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                data-candidato_id ="{{ $lista->user_id }}"
                                                            >
                                                                Trazabilidad
                                                            </button>

                                                            @if(!$dado_baja)
                                                                <a
                                                                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                    href="{{ route("admin.actualizar_hv_admin", ["id" => $lista->user_id]) }}"

                                                                    style="padding: .5rem 10px;" 
                                                                >
                                                                    @if(route("home") == "https://humannet.t3rsc.co")
                                                                        Editar CV
                                                                    @else
                                                                        Editar HV
                                                                    @endif
                                                                </a>
                                                            @endif

                                                            @if($user_sesion->hasAccess("boton_ws") && !$dado_baja)
                                                                <a
                                                                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                    target="_blank"
                                                                    href="https://api.whatsapp.com/send?phone=57{{ $lista->telefono_movil}}&text=Hola!%20{{ $lista->nombres }} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{ $sitio->nombre }},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." 

                                                                    style="padding: .5rem 10px;" 
                                                                >
                                                                    Whatsapp
                                                                </a>
                                                            @endif

                                                            @if(!$dado_baja)
                                                                <a 
                                                                    class='btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none' 
                                                                    href="{{ route('admin.subir_documentos',['user_id' => $lista->user_id]) }}" 
                                                                    style="'padding: .5rem 10px;'">Gestionar Documentos</a>

                                                                {!!
                                                                    FuncionesGlobales::valida_boton_req(
                                                                        "admin.cambiar_estado_candidato",
                                                                        "Cambiar estado",
                                                                        "boton",
                                                                        "btn btn-default btn-sm btn-block inactivar | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none",
                                                                        "",
                                                                        "$lista->id"
                                                                    )
                                                                !!}

                                                                <button
                                                                    type="button"
                                                                    class="btn btn-default btn-sm btn-block btn_observacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                    data-candidato_id="{{ $lista->user_id }}"
                                                                >
                                                                    Observaciones
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">No se encontraron registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $(".btn_observacion").on("click", function(e) {
                var candidato_id = $(this).data("candidato_id");

                $.ajax({
                    type: "POST",
                    data: "candidato_id=" + candidato_id,
                    url: "{{ route('admin.crear_observacion_hv') }}",
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_observacion", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
        
                $(this).prop("disabled",true);
                var btn_id = $(this).prop("id");
                
                setTimeout(function(){
                    $("#"+btn_id).prop("disabled",false);
                }, 5000);

                $.ajax({
                    type: "POST",
                    data: $("#fr_observacion_hv").serialize(),
                    url: "{{ route('admin.guardar_observacion_hv') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modal_peq").modal("hide");
                            mensaje_success("Se ha creado la observación con exito.");
                            $("#modal_gr").modal("hide");
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }
                    }
                });
            });

            $('#txt_cargo_generico').autocomplete({
                serviceUrl: '{{ route("admin.autocompletar_cargo_generico") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cargo_generico_id").val(suggestion.id);
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

            //Modal de estados
            $(document).on("click", ".inactivar", function () {
                var data_id = $(this).attr("id");

                if (data_id){
                    $.ajax({
                        type: "POST",
                        data: {hv_id: data_id},
                        url: "{{ route('admin.cambiar_estado') }} ",
                        success: function (response) {
                            $("#modal_gr ").find(".modal-content").html(response);
                            $("#modal_gr ").modal("show");
                        }
                    });
                }else{
                   mensaje_danger("No se cargo la información, favor intentar nuevamente.");
                }
            });

            $(document).on("click", ".mostrar_traza", function() {
                const candidato_id = $(this).data("candidato_id");

                $.ajax({
                    type: "POST",
                    data: "candidato_id="+ candidato_id,
                    url: "{{ route('admin.trazabilidad_candidato') }}",
                    success: function(response) {
                       $("#modal_gr").find(".modal-content").html(response);
                       $("#modal_gr").modal("show");
                    }
                })
            });

            $(document).on("click", "#guardar_estado", function () {
                if ($('#fr_cambio_estado').smkValidate()) {
                    $(this).prop('disabled', true);
                    $.ajax({
                        type: "POST",
                        data: $("#fr_cambio_estado").serialize(),
                        url: "{{ route('admin.guardar_estado') }}",
                        success: function (response) {
                            if (response.success) {
                                $("#modal_peq ").modal("hide");
                                mensaje_success("Se ha cambiado el estado al usuario.");
                                window.location.href = '{{ route("admin.lista_hv_admin") }}';
                            } else {
                                $(this).prop('disabled', false);
                                $("#modal_peq ").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }
            });

            $(document).on("change", "#estado_id", function () {
                if ($('#estado_id').val() == 13) {
                    $('#div-motivo').show();
                    $('#motivo_rechazo_id').attr('required', 'required');
                } else {
                    $('#div-motivo').hide();
                    $('#motivo_rechazo_id').removeAttr('required');
                }
            });
        });
    </script>
@stop
