<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><b>Gestionar candidatos</b> <br> <b>Requerimiento</b> {{ $requerimiento->id }}  |  <b>Cargo</b> {{ $requerimiento->cargo_req() }}</h4>
</div>

<div class="modal-body">
    <div class="row">
        @if ($requerimiento->candidatosAprobar()->count() > 0)
            <div class="col-md-12 text-right mb-2">
                <button 
                    type="button"
                    class="btn btn-success btn_contratacion_cliente_masivo | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green"
                    id="btn_contratacion_cliente_masivo"
                    data-cliente="{{ $cliente->id }}"
                >
                    Contratación masiva
                </button>    
            </div>
        @endif

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($candidatosReq->count() > 0)    
                        <?php
                            $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        @if ($requerimiento->candidatosAprobar()->count() > 0)
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos"]) !!}
                                        @else
                                            -
                                        @endif
                                    </th>
                                    {{-- <th>N° Requerimiento</th> --}}
                                    <th class="text-center">Identificación</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Móvil</th>
                                    <th class="text-center">Trazabilidad</th>
                                    <th class="text-center">Informe selección</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidatosReq as $reqCandi)
                                    <?php
                                        $procesoCliente = $reqCandi->candidatosAprobar($reqCandi->candidato_id, $reqCandi->req_id);

                                        $processes_collect = collect($reqCandi->procesos);
                                        $processes = $processes_collect->pluck("proceso")->toArray();
                                        $processes_apto = $processes_collect->where('apto', '1')->pluck("proceso")->toArray();
                                    ?>

                                    <tr>
                                        <td class="text-center">
                                            @if(!empty($procesoCliente))
                                                <input 
                                                    type="checkbox"
                                                    name="req_candidato_id[]"
                                                    value="{{ $reqCandi->req_candidato_id }}"
                                                    data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                >
                                            @else
                                                -
                                            @endif
                                        </td>
                                        {{-- <td>{{ $reqCandi->req_id }}</td> --}}
                                        <td class="text-center">{{ $reqCandi->numero_id }}</td>

                                        <td class="text-center">{{ $reqCandi->nombres }} {{ $reqCandi->primer_apellido }} {{ $reqCandi->segundo_apellido }}</td>
                                        
                                        <td class="text-center">{{ $reqCandi->telefono_movil }}</td>

                                        <td class="text-center">
                                             {{-- Trazabilidad candidato --}}
                                            @include('admin.reclutamiento.includes.gestion-requerimiento._section_trazabilidad_gestion', [
                                                "candidato_req" => $reqCandi,
                                                "requermiento" => $requerimiento,
                                                "procesos" => $processes_collect,
                                                "inactiveAllbtn" => true
                                            ])
                                        </td>

                                        @if (!empty($procesoCliente))
                                            <td class="text-center">
                                                <a 
                                                    class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                                                    target="_blank"
                                                    href="{{ route('req.informe_seleccion', [$reqCandi->req_candidato_id]) }}"
                                                >
                                                    Ver informe de selección
                                                </a>
                                            </td>

                                            {{-- Acción --}}
                                            @if (is_null($procesoCliente->apto) || $procesoCliente->apto == '')
                                                <td class="text-center">
                                                    <div class="btn-group-vertical" role="group" aria-label="...">
                                                        <button 
                                                            class="btn btn-primary btn_observaciones | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                            data-cliente="{{ $cliente->id }}"
                                                            data-req_id="{{ $reqCandi->req_id }}"
                                                            data-user_id="{{ $reqCandi->candidato_id }}"
                                                        >
                                                            Observaciones
                                                        </button>

                                                        <button 
                                                            class="btn btn-warning btn_citar | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                            data-cliente="{{ $cliente->id }}"
                                                            data-req_id="{{ $reqCandi->req_id }}"
                                                            data-user_id="{{ $reqCandi->candidato_id }}"
                                                        >
                                                            Citar
                                                        </button>

                                                        @if(route('home') != "http://komatsu.t3rsc.co")
                                                            <button 
                                                                class="btn btn-success btn_contratar | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                                data-cliente="{{ $cliente->id }}"
                                                                data-req_id="{{ $reqCandi->req_id }}"
                                                                data-user_id="{{ $reqCandi->candidato_id }}"
                                                            >
                                                                Contratar
                                                            </button>
                                                        @else
                                                            <button 
                                                                class="btn btn-success btn_contratar | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                                data-cliente="{{ $cliente->id}}" 
                                                                data-req_id="{{ $reqCandi->req_id }}"
                                                                data-user_id="{{ $reqCandi->candidato_id }}"
                                                            >
                                                                Continuar
                                                            </button>
                                                        @endif

                                                        <button 
                                                            class="btn btn-danger candidato_no_aprobado | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-candidato="{{ $reqCandi->candidato_id }}"
                                                            data-req_candidato="{{ $reqCandi->req_candidato_id }}"
                                                        >
                                                            NO Aprobado
                                                        </button>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="text-center">-</td>
                                            @endif
                                        @else
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">No hay candidatos vinculados</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
</div>

<script>
    $(function () {
        $("#seleccionar_todos").on("change", function () {
            let obj = $(this);

            $("input[name='req_candidato_id[]']").prop("checked", obj.prop("checked"));
        })

        $(".btn_observaciones").on("click", function(e) {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");
            let modulo="cliente";

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente, modulo: modulo},
                url: "{{ route('req.crear_observacion') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_gra").find(".modal-content").html(response);
                    $("#modal_gra").modal("show");
                }
            })
        })

        $(".btn_contratar").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.enviar_contratar_req') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })
        })

        $(".btn_citar").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.crear_cita_cliente') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_gra").find(".modal-content").html(response);
                    $("#modal_gra").modal("show");
                }
            })
        })

        $(".btn_contratar2").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.enviar_contratar2_req') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })
        })

        $(document).on("click", "#confirmar_contratacion", function() {
            $(this).prop("disabled", true);
            let btn_id = $(this).prop("id");
            
            setTimeout(function(){
                $("#"+btn_id).prop("disabled", false);
            }, 50000);

            $.ajax({
                type: "POST",
                data: $("#fr_contratar_req").serialize(),
                url: "{{ route('req.enviar_a_contratar_cliente_req') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        mensaje_success("Los datos de contratación han sido enviados.");
                        window.location.href = '{{ route("req.mis_requerimiento") }}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })

        $(".btn_contratacion_cliente_masivo").on("click", function() {
           let cliente_id = $(this).data("cliente");

           $.ajax({
                type: "POST",
                data: $("input[name='req_candidato_id[]']").serialize() + "&cliente_id="+cliente_id,
                url: "{{ route('req.contratar_masivo_cliente') }}",
                success: function(response) {
                   $("#modal_peq").find(".modal-content").html(response);
                   $("#modal_gr").modal("hide");
                   $("#modal_peq").modal("show");
                }
            })
        })

        $(document).on("click", "#guardar_observacion", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
        
            $(this).prop("disabled", true);
            let btn_id = $(this).prop("id");

            setTimeout(function(){
                $("#"+btn_id).prop("disabled", false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_observacion_req").serialize(),
                url: "{{ route('req.guardar_observacion') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        alert("Se ha creado la observación con éxito!");
                        window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })

        $(document).on("click", "#guardar_cita_cliente", function() {
            if($('#fecha_cita').val() == '') {
                $('#fecha_cita').css('border', 'solid red 1px');
            }else if($('#observacion_cita').val() == '') {
                $('#observacion_cita').css('border', 'solid red 1px');
            }else {
                $(this).prop('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    data: $("#frm_crear_cita").serialize(),
                    url: "{{ route('req.guardar_cita_cliente') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modal_gra").modal("hide");
                            $(this).prop('disabled', 'false');
                            alert('Se ha creado la cita con éxito.');
                        }else {
                            alert("Ocurrio un error en el servidor.");
                        }
                    }
                })
            }
        })

        $(document).on("click", "#confirmar_contratacion_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_contratar_masivo_req").serialize(),
                url: "{{ route('req.contratar_masivo_cli') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        alert("Los datos de contratación han sido enviados.");
                        window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })
    })

    function mensaje_success_sin_boton(mensaje) {
        $("#modal_success_view #texto").html(mensaje);
        $("#modal_success_view").modal("show");
    }
</script>