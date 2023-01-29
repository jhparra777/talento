@extends("admin.layout.master")
@section("contenedor")
    <style>
        .dropdown-menu{ left: -80px !important; padding: 0 !important; }

        .c-r {
            color: #d9534f;
        }

        .c-b {
            color: blue;
        }

        .c-g {
            color: green;
        }
    </style>

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Solicitudes de adelanto de Nómina"])

    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        {!! Form::model(Request::all(), ["id" => "fr_solicitud_adelanto_nomina", "method" => "GET"]) !!}
            <div class="col-md-6 col-lg-6 form-group">
                <label for="rango_fecha">Rango fecha de solicitud:</label>

                {!! Form::text("rango_fecha", null, [
                    "id" => "rango_fecha",
                    "class" => "form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "autocomplete" => "off"
                ]); !!}
            </div>

            <div class="col-md-6 col-lg-6 form-group">
                <label for="palabra_clave">Nombre, email:</label>

                {!! Form::text("palabra_clave", null, [
                    "id" => "palabra_clave",
                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "placeholder" => "Escriba nombre o email"
                ]); !!}
            </div>

            <div class="col-md-6 col-lg-6 form-group">
                <label for="cedula">Cédula:</label>

                {!! Form::number("cedula", null, [
                    "class" => "form-control input-number | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "placeholder" => "Número identificación",
                    "id" => "cedula"
                ]); !!}
            </div>

            <div class="col-md-12 text-right">
                <button class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-success | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green" href="#" id="export_excel_btn" role="button">
                    Excel <i aria-hidden="true" class="fa fa-file-excel-o"></i>
                </a>

                <a class="btn btn-default | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{ route('admin.lista_solicitudes_adelanto_nomina') }}">
                    Limpiar
                </a>
            </div>
        {!! Form::close() !!}

        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Fecha y valor del<br>último anticipo</th>
                                <th>Valor solicitud</th>
                                <th>Fecha solicitud</th>
                                <th>Estado solicitud</th>
                                <th>Fecha y código transferencia</th>
                                <th>Documento soporte</th>
                                <th colspan="2">Acción</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($solicitudes as $count => $lista)
                                <?php
                                    $bg_important = '';
                                    $borde_superior = false;
                                    $dado_baja = false;
                                    if ($lista->estado_reclutamiento === config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                                        $dado_baja = true;
                                    }
                                    $reque = $lista->requerimiento_id;
                                    $user = $lista->user_id;
                                    $sol = $lista->solicitud_id;
                                    $ruta_solicitud = 'recursos_adelanto_nomina/solicitud_'.$user.'_'.$reque.'/solicitud_adelanto_nomina_'.$user.'_'.$reque.'_'.$sol.'.pdf';

                                    $firmaContrato = $lista->firma_contrato();

                                    $firmaContrato = $lista->firma_contrato();

                                    if ($firmaContrato != null) {
                                        if ($firmaContrato->ip == $lista->ip_solicitud) {
                                            $bg_important = "style='background: #f7fc9b;'";
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>{{ $lista->numero_id }}</td>
                                    <td>{{ $lista->nombres }}</td>
                                    <td>{{ $lista->primer_apellido." ".$lista->segundo_apellido }}</td>
                                    <td>
                                        <?php
                                            $solicitud_anterior = $all_solicitudes->where('user_id', $lista->user_id)->where('fecha_solicitud', '<', $lista->fecha_solicitud)->sortByDesc('id')->first();
                                        ?>
                                        @if (!is_null($solicitud_anterior))
                                            <span title="{{($solicitud_anterior->solicitud_aprobada == 'SI' ? 'Aprobada' : ($solicitud_anterior->solicitud_aprobada == 'NO' ? 'Negada' : 'Pendiente') )}}">
                                                {{ $solicitud_anterior->fecha_solicitud }}<br>
                                                {{ number_format($solicitud_anterior->valor_solicitud, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($lista->valor_solicitud, 0, ',', '.') }}</td>
                                    <td>{{ $lista->fecha_solicitud }}</td>
                                    @if ($lista->solicitud_aprobada == 'SI')
                                        <td align="left" class="c-g">
                                            <i class="fa fa-check-circle-o fa-2x"></i> <br>Aprobada
                                        </td>
                                    @elseif($lista->solicitud_aprobada == 'NO')
                                        <td align="left" class="c-r">
                                            <span title="{{ $lista->motivo_rechazo_desc }}">
                                                <i class="fa fa-exclamation-circle fa-2x"></i> <br>Negada
                                            </span>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        {{ $lista->fecha_transferencia . ' ' . $lista->hora_transferencia }}<br>
                                        <b>{{ $lista->codigo_transferencia }}</b>
                                    </td>
                                    <td {!!$bg_important!!}>
                                        @if($lista->documento_soporte != null && file_exists("recursos_documentos_verificados/$lista->documento_soporte"))
                                            <a href='{{route("view_document_url", encrypt("recursos_documentos_verificados/"."|".$lista->documento_soporte))}}' class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" target="_blank">
                                                Soporte_{{$lista->codigo_transferencia}}
                                            </a><br>
                                        @endif

                                        @if(file_exists($ruta_solicitud))
                                            <a type="button" class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route('view_document_url', encrypt('recursos_adelanto_nomina/solicitud_'.$user.'_'.$reque.'/'.'|solicitud_adelanto_nomina_'.$user.'_'.$reque.'_'.$sol.'.pdf'))}}" target="_blank">
                                                Solicitud_{{$lista->solicitud_id}}
                                            </a>
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        <div class="btn-group-vertical">
                                            @if ($firmaContrato != null)
                                                @if ($firmaContrato->estado == 1 || $firmaContrato->estado === 1)
                                                    @if($firmaContrato->terminado != null && $firmaContrato->terminado == 1 || $firmaContrato->terminado == 3)
                                                        @if($firmaContrato->contrato !== null && $firmaContrato->contrato !== '')
                                                            <?php $borde_superior = true; ?>
                                                            <a type="button" class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('view_document_url', encrypt('contratos/'.'|'.$firmaContrato->contrato))}}" target="_blank" style="border-radius: 1rem 1rem 0rem 0rem;"
                                                            >
                                                                CONTRATO
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif

                                            @if($user_sesion->id == $sitio->id_user_gestiona_cartapp || Sentinel::inRole("God"))
                                                @if($lista->solicitud_aprobada == null)
                                                    <?php $borde_superior = true; ?>
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary btn-sm btn-block btn_gestionar_solicitud | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        data-solicitud_id="{{ $lista->solicitud_id }}"

                                                        @if($firmaContrato == null)
                                                            style="border-radius: 1rem 1rem 0rem 0rem;"
                                                        @endif
                                                    >
                                                        GESTIONAR SOLICITUD
                                                    </button>
                                                @endif
                                            @endif

                                            <div class="btn-group">
                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"

                                                    @if($borde_superior)
                                                        style="border-radius: 0rem 0rem 1rem 1rem;"
                                                    @else
                                                        style="border-radius: 1rem 1rem 1rem 1rem;"
                                                    @endif
                                                >
                                                    OPCIONES <span class="caret"></span>
                                                </button>

                                                <ul class="dropdown-menu pd-0">
                                                    @if($user_sesion->hasAccess("boton_video_perfil"))
                                                        @if($lista->video != null )
                                                            <a
                                                                type="button"
                                                                class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                href='{{ route("view_document_url", encrypt("recursos_videoperfil/|".$lista->video)) }}'
                                                                target="_blank"
                                                            >
                                                                <i class="fas fa-video"></i> VIDEO PERFIL
                                                            </a>
                                                        @endif
                                                    @endif

                                                    <a
                                                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        target="_blank"
                                                        href="{{ route('admin.hv_pdf', ['user_id' => $lista->user_id]) }}"
                                                    >
                                                        HOJA DE VIDA
                                                    </a>

                                                    <a
                                                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        href="{{ route('admin.lista_solicitudes_adelanto_nomina').'?cedula='.$lista->numero_id }}"
                                                    >
                                                        SOLICITUDES REALIZADAS
                                                    </a>

                                                    <a
                                                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        target="_blank"
                                                        href="{{ route('admin.gestion_contratacion', ['candidato' => $lista->user_id, 'req' => $lista->requerimiento_id]) }}"
                                                        style="padding: .5rem 10px;" 
                                                    >
                                                        ASISTENTE CONTRATACIÓN
                                                    </a>
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
                    <div>
                        @if(method_exists($solicitudes, 'appends'))
                            {!! $solicitudes->appends(Request::all())->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $(".btn_gestionar_solicitud").on("click", function(e) {
                var solicitud_id = $(this).data("solicitud_id");

                $.ajax({
                    type: "POST",
                    data: "solicitud_id=" + solicitud_id,
                    url: "{{ route('admin.gestion_solicitud_cartapp_view') }}",
                    success: function(response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            });

            $('#export_excel_btn').click(function(e){
                $rango_fecha = $("#rango_fecha").val();
                $palabra_clave = $("#palabra_clave").val();
                $cedula = $("#cedula").val();

                $(this).prop("href","{{ route('admin.reporte_solicitudes_adelanto_excel') }}?&formato=xlsx&rango_fecha="+$rango_fecha+"&palabra_clave="+$palabra_clave+"&cedula="+$cedula);
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
        });
    </script>
@stop
