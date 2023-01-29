@extends("admin.layout.master")
@section("contenedor")
<style>
    .dropdown-menu{ left: -80px !important; padding: 0 !important; }

    .form-control-feedback{
        display: none !important;
    }

    .smk-error-msg{
        position: unset !important;
        float: right;
        margin-right: 14px !important;
    }

    .text-center {
        text-align: center;
    }
</style>
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Afiliaciones"])

    <div class="row">
        <div class="col-md-12">
            <img alt="t3rs" height="40" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}">
        </div>
    </div>
    <br>

    {{-- Las notificaciones ahora se muestran como modal con JS
    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif
        @if(Session::has("mensaje_warning"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{ Session::get("mensaje_warning") }}
                </div>
            </div>
        @endif
    </div>
    --}}

    {!! Form::model(Request::all(), ["route" => "admin.afiliaciones", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="rango_fecha">
                    Rango de fecha de firma de contrato:
                </label>
                {!! Form::text("rango_fecha_firma", null, ["class" => "form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="cedula">
                    Cédula:
                </label>

                {!! Form::text("cedula",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Cédula", "id" => "cedula"]); !!}
            
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-success | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green" href="#" id="export_excel_btn" role="button">
                    Excel <i aria-hidden="true" class="fa fa-file-excel-o"></i>
                </a>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("admin.afiliaciones") }}">
                    Limpiar
                </a>
            </div>
        </div>
    {!! Form::close() !!}

    {{-- Acciones globales al requerimiento --}}
    <div class="row pt-2">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="tri-fs-16 text-center mb-2">
                        ACCIONES GLOBALES
                    </h4>

                    @include('admin.afiliaciones.partials._section_acciones_globales')
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="tabla table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, ["id" => "seleccionar_todos_candidatos_vinculados"]) !!}
                            </th>
                            <th>ÍTEM</th>
                            <th>REQUERIMIENTO</th>
                            <th>NOMBRES Y APELLIDOS</th>
                            <th>TIPO DOCUMENTO</th>
                            <th>IDENTIFICACIÓN</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>CIUDAD</th>
                            <th>LOCALIDAD DE RESIDENCIA</th>
                            <th>DIRECCIÓN</th>
                            <th>CORREO</th>                          
                            <th>CELULAR</th>
                            
                            <th>FONDO DE PENSIÓN</th>
                            <th>EPS</th>
                            <th>REGIMEN EPS</th>
                            <th>TIPO TRAMITE</th>
                            <th>CARGO</th>
                            <th>SALARIO</th>
                            <th>FECHA INGRESO</th>
                            <th>FECHA FIN CONTRATO</th>
                            <th>FECHA FIRMA CONTRATO</th>
                            <th>RIESGO ARL TRABAJADOR</th>
                            <th>CAJA DE COMPENSACIÓN</th>
                            {{-- <th>OBSERVACIONES</th> --}}
                            <th>ESTADO AFILIACIÓN</th>
                            <th>ESTADO CONTRATO</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($candidatos as $item => $candidato)
                            <?php
                                //Se suma 1 para que comience en 1; se suman de 12 en 12 a partir de la pagina 2
                                $nro_item = ($item+1)+(12*($candidatos->currentPage()-1));
                            ?>
                            <tr>
                                <td>
                                    {!! Form::hidden("req_id", $candidato->req_id) !!}
                                    <input
                                        class="check_candi"
                                        data-candidato_req="{{ $candidato->req_can_id }}"
                                        data-cliente=""
                                        name="req_candidato[]"
                                        type="checkbox"
                                        value="{{ $candidato->req_can_id }}"
                                    >
                                </td>
                                <td>
                                    {{$nro_item}}
                                </td>
                                <td>
                                    {{$candidato->req_id}}
                                </td>
                                <td>
                                    {{ mb_strtoupper($candidato->nombres ." ".$candidato->primer_apellido." ".$candidato->segundo_apellido) }}
                                </td>
                                <td>
                                    {{ $candidato->tipo_documento }}
                                </td>
                                <td>
                                    {{ $candidato->numero_id }}
                                </td>
                                <td>
                                    {{ $candidato->fecha_nacimiento }}
                                </td>
                                <td>
                                    {{$candidato->nombre_ciudad}}
                                </td>
                                <td>
                                    {{ $candidato->barrio }}
                                </td>
                                <td>
                                    {{ $candidato->direccion }}
                                </td>

                                <td>
                                    {{ $candidato->email }}
                                </td>
                                <td>
                                    {{ $candidato->telefono_movil }}

                                    {{-- Boton de whatsapp --}}
                                    <div class="mt-1">
                                        @if($user_sesion->hasAccess("boton_ws"))
                                            <a 
                                                class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-green" 
                                                target="blank" 
                                                href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato->telefono_movil }}&text=Hola!%20{{$candidato->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}}."
                                 
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-container="body"
                                                title="Enviar mensaje a tráves de Whatsapp"
                                            >
                                                <i class="fab fa-whatsapp tri-fs-14" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $candidato->fondo_pension }}
                                </td>
                                <td>
                                    {{ $candidato->eps }}
                                </td>
                                <td>
                                    PENDIENTE
                                </td>
                                <td>
                                    @if($candidato->tipo_ingreso == 1)
                                        NUEVO                                  
                                    @else
                                        RECONTRATO          
                                    @endif
                                </td>
                                <td>
                                    {{ $candidato->cargo }}
                                </td>
                                <td>
                                    {{ $candidato->salario }}
                                </td>
                                <td>
                                    {{ $candidato->fecha_ingreso }}
                                </td>
                                <td>
                                    {{ $candidato->fecha_fin_contrato }}
                                </td>
                                <td>
                                    {{ $candidato->fecha_firma }}
                                </td>
                                <td>
                                    {{ $candidato->riesgo_arl }}
                                </td>
                                <td>
                                    {{ $candidato->caja_compensacion }}
                                </td>  
                                <td>
                                    @if ($candidato->estado_afiliado == 0)
                                        <i class="fas fa-hourglass-half"></i>
                                    @else
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    {{ ($candidato->estado_contrato == 0 ? 'Anulado' : 'Firmado') }}
                                </td>
                                <td>
                                    <div class="btn-group-vertical">

                                        <a class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            href={{route('admin.documentos_seleccion', ["candidato" => $candidato->candidato_id, "req" => $candidato->req_id, "req_can" => $candidato->req_can_id])}}>
                                            Visualizar documentos
                                        </a>

                                        <a class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            href="{{ route('admin.documentos_contratacion', ['candidato' => $candidato->candidato_id, 'req' => $candidato->req_id]) }}">
                                            Cargar soportes
                                        </a>
                                        <a class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            href="{{route('admin.documentos_beneficiarios', ['candidato' => $candidato->candidato_id, 'req' => $candidato->req_id])}}">
                                            Beneficiarios
                                        </a>
                                        <a 
                                            type="button" 
                                            data-req_can_id="{{$candidato->req_can_id}}"
                                            class="btn btn-primary btn_observaciones btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            target="_blank">
                                            Observaciones
                                        </a>
                                        <a class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            href={{route('admin.afiliaciones_gestionadas', ["candidato" => $candidato->candidato_id, "req" => $candidato->req_id, "contrato_id" => $candidato->contrato_id])}}>
                                            Confirmar afiliaciones
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="21">
                                    No se encontraron registros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div>
                {!! $candidatos->appends(Request::all())->render() !!}
            </div>

            {{-- Modal de anulación --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento.modals._modal_anulacion_gestion')

        </div>
    </div>

    <script type="text/javascript">
        
        function updateClock(id_elemento, totalTime) {
            document.getElementById(id_elemento).innerHTML = totalTime;
            if(totalTime > 0){
                totalTime -= 1;
                //console.log(id_elemento + ' ' + totalTime);
                setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
            }
        }

        function sendContractFirmForm(ruta) {
            $('<form>', {
                "method" : "get",
                "id": "form_contrato_firma",
                "action": ruta
            }).appendTo(document.body).submit();
        }

        function validar_email(email) {
            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email) ? true : false;
        }

        //Pausar firma contrato
        const pausar_firma_contrato = obj => {
            const user_id  = obj.dataset.user_id
            const req_id   = obj.dataset.req_id
            const cand_req = obj.dataset.req_cand_id
            const cliente  = obj.dataset.cliente

            $.ajax({
                type: "POST",
                url: "{{ route('admin.pausar_firma_virtual') }}",
                data: {
                    user_id : user_id,
                    req_id : req_id,
                    cand_req : cand_req
                },
                beforeSend: function() {
                    mensaje_success('Actualizando estado ...')
                },
                success: function(response) {
                    if(response.success == true){
                        if(response.stand_by == 1){
                            mensaje_success('Firma de contrato pausada')
                            obj.textContent = "INICIAR FIRMA"

                            setTimeout(() => {
                                $("#modal_success").modal("hide")
                            }, 1500)
                        }else if(response.stand_by == 0){
                            //Si la firma está pausada
                            setTimeout(() => {
                                $("#modal_success").modal("hide")
                            }, 1500)

                            //Solicitud de modal para actualizar datos
                            $.ajax({
                                type: "POST",
                                data: {
                                    candidato_req : cand_req,
                                    cliente : cliente,
                                    user_id : user_id,
                                    req_id : req_id
                                },
                                url: "{{ route('admin.editar_informacion_contrato') }}",
                                success: function(response) {
                                    $("#modalTriLarge").find(".modal-content").html(response)
                                    $("#modalTriLarge").modal("show")
                                    $("#modalTriLarge").css("overflow-y", "scroll")
                                }
                            });

                            //mensaje_success('Firma de contrato iniciada');
                            obj.textContent = "PAUSAR FIRMA"
                        }
                    }else if(response.firmado == true){
                        mensaje_danger('El contrato ya se encuentra firmado.')
                    }else{
                        mensaje_danger('Ha ocurrido un error, intenta nuevamente.')
                    }
                }
            });
        }

        $(function () {

            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            @if(Session::has("mensaje_warning"))
                mensaje_danger("{{Session::get('mensaje_warning')}}");
            @endif

            @if(Session::has("mensaje_success"))
                mensaje_success("{{Session::get('mensaje_success')}}");
            @endif

             $(document).on("click", ".btn_observaciones", function() {

            //var req_id = $(this).data("req_id");
            //var user_id = $(this).data("user_id");
            var id = $(this).data("req_can_id");
            //var cliente = $(this).data("cliente");
            
            $.ajax({
                type: "POST",
                data:    "candidato_req=" + id,
                url: "{{ route('admin.crear_observacion') }}",
                success: function(response) {
                    $("#modalTriLarge").modal("hide");
                    $("#modalTriLarge").find(".modal-content").html(response);
                    $("#modalTriLarge").modal("show");
                }
            });
        });

        $('#export_excel_btn').click(function(e){
            console.log('clic');
            $rango_fecha = $("#rango_fecha").val();
            $cedula = $("#cedula").val();

            $(this).prop("href","{{ route('admin.reporte_confirmacion_afiliaciones_excel') }}?&formato=xlsx&rango_fecha="+$rango_fecha+"&cedula="+$cedula);
        });

        $(document).on("click", "#guardar_observacion", function() {
            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");

            setTimeout(function(){
                $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_observacion_req").serialize(),
                url: "{{ route('admin.guardar_observacion_afiliaciones') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modalTriLarge").modal("hide");
                        $.smkAlert({
                            text: 'Se ha creado la observación con éxito!',
                            type: 'success',
                        });
                        //window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        //mensaje_success("El requerimiento ya se encuentra cerrado");
                        $("#modalTriLarge").find(".modal-content").html(response.view);
                    }

                }
            });
        });


            $(document).on("click", "#btn_recontratar_videos", function() {
                var user_id = $(this).data("candidato_id");
                var req_id = $(this).data("requerimiento_id");

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_correo_video_confirmacion') }}",
                    data: {
                        user_id : user_id,
                        req_id : req_id
                    },
                    beforeSend: function() {
                        mensaje_success('Enviando correo con enlace ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Correo enviado correctamente a la dirección '+ response.email);
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });


            $(document).on("click", "#llamada_virtual", function() {
                var candidatos_llamar = 0;
                $(".check_candi").each(function (id, item) {
                    if (item.checked) {
                        candidatos_llamar++;
                        $('#bloque_candidatos_llamar').append('<input type="hidden" name="candidatos_llamar[]" value="'+item.value+'"/>')
                    }
                })
                if (candidatos_llamar > 0) {
                    $( "#fr_candidatos" ).submit();
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }
            })

            //Guardar datos editados el contrato pausado
            $(document).on("click", "#confirmar_informacion_contratacion", function() {
                if($('#fr_informacion_contratacion').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_informacion_contratacion").serialize(),
                        url: "{{ route('admin.guardar_informacion_contratacion') }}",
                        beforeSend: function(){
                            mensaje_success("Espere mientras se carga la información");
                        },
                        success: function(response){
                            if (response.success) {
                                $("#modal_peq").modal("hide");

                                mensaje_success("La información se ha editado correctamente y el contrato ha sido iniciado nuevamente.");

                                setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                                setTimeout(function(){ location.reload(); }, 2000);
                            } else {
                                $("#modal_success .close").click();
                                $("#modal_success").modal("hide");

                                $("#modal_peq").find(".modal-content").html(response.view);

                                $("#modal_peq").css("overflow-y", "scroll");
                            }
                        },
                        error: function(){
                            $("#modal_peq .close").click();
                            $("#modal_success .close").click();
                            mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                        }
                    })
                }
            });
            //

            $(document).on('click', "#anular_contrato", function () {
                $("#modal_anulacion").modal("show");

                const user_id = $(this).data("user_id");
                const req_id = $(this).data("req_id");
                const cand_req = $(this).data("req_cand_id");
                const cliente_id = $(this).data("cliente_id");

                $('#anular_user_id').val(user_id);
                $('#anular_req_id').val(req_id);
                $('#anular_cand_req').val(cand_req);
                $('#anular_cliente_id').val(cliente_id);
            });

            $(document).on("click", "#anular_contrato_frm", function() {
                let cand_req = $('#anular_cand_req').val();
                let cliente_id = $('#anular_cliente_id').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.anular_contratacion_candidato') }}",
                    data: $('#fr_anular').serialize(),
                    beforeSend: function() {
                        mensaje_success('Anulando contrato, está acción puede tardar. Aguarde ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Contrato anulado correctamente');
                            
                            setTimeout(() => {
                                $("#modal_peq").modal("hide");
                                $("#modal_success").modal("hide");
                                $("#modal_anulacion").modal("hide");
                            }, 1000)

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                            
                            /*
                                $.smkConfirm({
                                    text:'¿Deseas enviar a contratar nuevamente al candidat@?',
                                    accept:'Aceptar',
                                    cancel:'Cancelar'
                                },function(res){
                                    if (res) {
                                        //Llamar función con todo
                                        enviar_a_contratar(cand_req, cliente_id)
                                    }else {
                                        //Cerrar modal y ya :v
                                        window.location.reload(true);
                                    }
                                })
                            */
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });

            //Carga modal con información de contratación
            const enviar_a_contratar = (cand_req, cliente) => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_a_contratar') }}",
                    data: {
                        candidato_req : cand_req,
                        cliente_id : cliente
                    },
                    beforeSend: function() {
                        mensaje_success('Cargando información ...')
                        setTimeout(() => {
                            $("#modal_success").modal("hide")
                        }, 1000)
                    },
                    success: function(response) {
                        if(response){
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").css("overflow-y", "scroll");
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                })
            }

            $(document).on("click", "#confirmar_contratacion_re", function() {
                if($('#fr_contratar').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_contratar").serialize(),
                        url: "{{ route('admin.reenviar_a_contratar_proceso') }}",
                        beforeSend: function(){
                            mensaje_success("Espere mientras se carga la información");
                        },
                        error: function(){
                            $("#modal_peq .close").click();
                            $("#modal_success .close").click();

                            mensaje_danger("Ha ocurrido un error, verifique los datos.");
                        },
                        success: function(response){
                            if(response.success) {
                                $("#modal_peq").modal("hide");

                                mensaje_success("El candidato se ha enviado a {{(route('home') == 'https://gpc.t3rsc.co')?'aprobar':'contratar'}}.");

                                setTimeout(function(){
                                    $("#modal_success").modal("hide");
                                    window.location.reload(true);
                                }, 1000);

                            } else {
                                $("#modal_success .close").click();
                                $("#modal_success").modal("hide");
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").css("overflow-y","scroll");
                            }
                        }
                    });
                }
            });

            $(document).on("click", "#reenviar_correo_contrato", function() {
                var user_id = $(this).data("candidato_id");
                var req_id = $(this).data("req_id");

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_correo_contratacion') }}",
                    data: {
                        user_id : user_id,
                        req_id: req_id
                    },
                    beforeSend: function() {
                        mensaje_success('Enviando ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Correo reenviado correctamente a la dirección '+ response.email);
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });

            $(document).on("click", ".cambiar_estado_asistencia", function () {
                var proceso = $(this).data("proceso");

                $.ajax({
                    data: {proceso: proceso, respuesta: "si"},
                    url: "{{route('admin.contratacion.cambiar estado_asistencia')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", ".asignar_psicologo", function () {
                var req_id = $(this).data("req_id");
                var cliente_id = $(this).data("cliente_id");

                $.ajax({
                    data: {req_id: req_id, cliente_id: cliente_id},
                    url: "{{route('admin.asignar_psicologo')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_asignacion", function () {
                $(this).prop("disabled", false)

                $.ajax({
                    type: "POST",
                    data: $("#fr_asig").serialize(),
                    url: "{{ route('admin.asignar_psicologo_guardar')}}",
                    success: function(response) {
                        if(response.success){
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").modal("hide");
                            mensaje_success("Asignación realizada");
                            location.reload();
                         }else{
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").modal("hide");
                            mensaje_danger("Ya se le hizo la asignación al analista");
                        }
                    }
                });
            });

            $(document).on("click", ".orden", function(){

                req_can=$(this).data("req_can");
                proceso=$(this).data("proceso_cand");
                
                $.ajax({
                    type: "POST",
                    data: {
                        "req_can":req_can,
                        "proceso":proceso
                    },
                    url: "{{ route('admin.contratacion.detalle_orden') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", ".status", function(){
                req_can = $(this).data("req_can");
                proceso = $(this).data("proceso_cand");
                candidato = $(this).data("candidato");
                requerimiento = $(this).data("req");
                user_id = $(this).data("user_id");

                $.ajax({
                    type: "POST",
                    data: {
                        "req_can" : req_can,
                        "proceso" : proceso,
                        'candidato' : candidato,
                        'requerimiento' : requerimiento,
                        'user_id' : user_id
                    },
                    url: "{{ route('admin.contratacion.status_contratacion') }}",
                    success: function (response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            /* Modal de envío de documentos */
            $(document).on("click", "#confirmacion_contratacion_modal", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                        req : $(this).data("req"),
                        candidato_req : $(this).data('candidato_req'),
                        user_id : $(this).data('user_id'),
                    },
                    url: "{{ route('admin.contratacion.confirmacion_contratacion_asistente') }}",
                    success: function (response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            function enviarDocumentos() {
                $.ajax({
                    type: "POST",
                    data: $("#form_contratacion").serialize(),
                    url: "{{ route('admin.envio_documentos_contratacion') }}",
                    beforeSend: function(response) {
                        $("#modalTriLarge").modal("hide");
                        $.smkAlert({
                            text: 'Enviando confirmación de contratación ...',
                            type: 'info',
                            icon: 'glyphicon-info-sign'
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                          $("#modalTriLarge").modal("hide");

                          mensaje = "Confirmación de contratación enviada a los siguientes correos:";

                          $.each(response.correos, function (i,val) {
                            mensaje += ' '+val.email+',';
                          });

                           mensaje+="<br/>"+response.otros;

                           if (response.candidato_email != '') {
                               mensaje+="<br/>"+response.candidato_email;
                           }

                           mensaje_success(mensaje);

                            $.smkAlert({
                                text: 'Confirmación de contratación enviada correctamente',
                                type: 'success',
                            });

                            //mensaje_success("Confirmación de contratación enviada");
                        } else {
                            $("#modalTriSmall").find(".modal-content").html(response.view);
                        }
                    },
                    error: function(response){
                        $.smkAlert({
                            text: 'Ha ocurrido un error inesperado, intente nuevamente.',
                            type: 'danger',
                        });
                    }
                });
            }

            /* Envío de documentos al cliente */
            $(document).on("click", "#enviar_confirmacion_contratacion_modal", function() {
                if (! $('#form_contratacion').smkValidate() || ($('input[name="documentos[]"]:checked').length === 0 && ! $('#carnet').prop('checked'))) {
                    //Sino selecciono ningun documento o sino existen documentos; se pregunta si desea enviar el correo
                    swal("Sin documentos por enviar", " ¿Desea enviar el correo sin documentos?", "info", {
                        buttons: {
                            cancelar: { text: "No",className:'btn btn-warning'
                            },
                            enviar: {
                                text: "Si",className:'btn btn-success'
                            },
                        },
                    }).then((value) => {
                        switch(value){
                            case "cancelar":
                                return false;
                            break;
                            case "enviar":
                                enviarDocumentos();
                            break;
                        }
                    });
                } else {
                    enviarDocumentos();
                }
            });

            $(document).on("click" ,".cancelar_contratacion", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                        req: $(this).data("req"),
                        dato: $(this).data('candidato_req')
                    },
                    url: "{{ route('admin.contratacion.cancelar_contratacion_asistente') }}",
                    success: function (response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            });

            $(document).on("click", ".finalizar_contratacion", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                     req: $(this).data("req"), dato:$(this).data('candidato_req')
                    },
                    url: "{{ route('admin.contratacion.finalizar_contratacion_asistente') }}",
                    success: function (response) {
                        mensaje_success("Contratación finalizada");
                    }
                });

            });

            $(".btn-enviar-examenes").on("click", function() {
            
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");         
         
                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_examenes_view') }}",
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response.view);
                        $("#modalTriLarge").modal("show");
                    }
                });

            });

            $(document).on("click", "#guardar_examen", function() {
            
                if($('#proveedor').val() === ""){
                    $('#proveedor_med_text').show();
                }else{
                    
                    var obj = $(this);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_examen").serialize(),
                        url: "{{ route('admin.enviar_examenes') }}",
                        success: function(response) {
                            if (response.success) {
                                $("#modal_peq").modal("hide");
                                mensaje_success("El candidato se ha enviado a exámenes médicos.");
                                obj.prop("disabled", true);
                                var candidato_req = $("#candidato_req_fr").val();
                                $(".this").prop("disabled", true);
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }

            });

            //---
            $(".btn-enviar-estudio").on("click", function() {
            
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");         
         
                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_estudio_seguridad_view') }}",
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response.view);
                        $("#modal_gr").modal("show");
                    }
                });

            });

            $(document).on("click", "#guardar_estudio_seguridad", function() {
                
                if($('#proveedor_seg').val() === ""){
                    $('#proveedor_seg_text').show();
                }else{
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_estudio_seg").serialize(),
                        url: "{{ route('admin.enviar_estudio_seguridad') }}",
                        success: function(response) {
                            if (response.success) {
                                $("#modal_peq").modal("hide");
                                mensaje_success("El candidato se ha enviado a estudios de seguridad.");
                                obj.prop("disabled", true);
                                var candidato_req = $("#candidato_req_fr").val();
                                $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-estudio").prop("disabled", true);
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }

            });
            //---

            $(".btn-enviar-examenes-masivos").on("click", function() {
           
                if ($("input[name='req_candidato[]']").serialize() != "") {
                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_examenes_masivo') }}",
                        success: function(response) {
                            $("#modalTriSmall").find(".modal-content").html(response);
                            $("#modalTriSmall").modal("show");
                        }
                    });
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }

            });

            $(document).on("click", "#confirmar_examenes_masivo", function() {
                if($('#fr_exam_masi').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_exam_masi").serialize(),
                        url: "{{ route('admin.confirmar_examenes_masivo') }}",
                        beforeSend: function(){
                            $("#modal_peq").modal("hide");
                            //imagen de carga
                            $.blockUI({
                                message: '<img src="http://www.fundacionprotejer.com/wp-content/plugins/filtros/img/loading.gif">', 
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
                        success: function(response) {
                            $.unblockUI();
                            if(response.success) {
                                var mensaje = 'Se han enviado a los candidatos satisfactoriamente.';
                                if (response.candidatos_no_enviados.length > 0) {
                                    mensaje += "<br>Pero " + response.candidatos_no_enviados.length + " candidatos ya se encuentran en proceso de exámenes médicos y no se han enviado:<br>";
                                    response.candidatos_no_enviados.forEach(function(cand, index) {
                                        mensaje += '<b>' + cand + '</b>';
                                        if (response.candidatos_no_enviados.length - 1 > index) {
                                            mensaje += ' - ';
                                        }
                                    });
                                }
                                mensaje_success(mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 10000);
                            }else{
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }
                    });
                }

            });

            $(".btn_contratacion_masivo").on("click", function() {
                if ($("input[name='req_candidato[]']").serialize() != "") {
                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.contratar_masivo_view') }}",
                        success: function(response) {
                            $("#modalTriLarge").find(".modal-content").html(response.view);
                            $("#modalTriLarge").modal("show");
                        }
                    });
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }
            });

            $(document).on("click", "#confirmar_contratacion_masiva", function() {
                if($('#fr_contratar_masivo').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_contratar_masivo").serialize(),
                        url: "{{ route('admin.confirmar_contratar_masivo') }}",
                        beforeSend: function(){
                            $("#modal_gr").modal("hide");
                            mensaje_success("Espere mientras se carga la información");
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
                        success: function(response) {
                            $.unblockUI();
                            if (response.success) {
                                var totalTime = 5;
                                var mensaje = 'Se han contratado los candidatos satisfactoriamente.';
                                if (response.no_contratados_masivo.length > 0) {
                                    totalTime = 15;
                                    mensaje += "<br><br>Pero " + response.no_contratados_masivo.length + " candidatos no se han enviado a contratar:<br><table id='table_no_contratados' class='table table-striped'><thead><th>Documento identidad</th><th>Nombres y apellido</th><th>Motivo no se envia a contratar</th></thead><tbody>";
                                    response.no_contratados_masivo.forEach(function(cand, index) {
                                        mensaje += '<tr><td>' + cand.numero_id + '</td><td>' + cand.nombres + '</td><td>' + cand.observacion + '</td></tr>';
                                    });
                                    mensaje += "</tbody></table>";
                                }
                                mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                                mensaje_success(mensaje);
                                if (response.no_contratados_masivo.length > 0) {
                                    $('#table_no_contratados').DataTable({
                                        'stateSave': true,
                                        "lengthChange": false,
                                        "responsive": true,
                                        "paginate": true,
                                        "autoWidth": true,
                                        "searching": false,
                                        "order": [[1,"desc"]],
                                        "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
                                        "language": {
                                          "url": '{{ url("js/Spain.json") }}'
                                        }
                                    });
                                }
                                updateClock("tiempo_recarga", totalTime);
                                setTimeout(function(){
                                    location.reload();
                                }, totalTime*1000);
                            } else {
                                $("#modal_peq").modal("hide");
                                mensaje_danger(response.view);
                            }
                        }
                    });
                }
            });

            @if($sitioModulo->evaluacion_sst == 'enabled')
                $(document).on("click",".btn-enviar-sst", function() {
                    //para mostrar el modal de la evaluacion sst
                    var id = $(this).data("candidato_req");

                    $.ajax({
                        type: "POST",
                        data: "candidato_req=" + id,
                    url: "{{ route('enviar_evaluacion_sst')}}",
                        success: function(response) {
                          $("#modalTriSmall").find(".modal-content").html(response);
                          $("#modalTriSmall").modal("show");
                        }
                    });
                });

                $(document).on("click", "#confirmar_envio_evaluacion_sst", function(e) {
                    e.preventDefault();

                    $(this).prop("disabled",true);
                    
                    var btn_id = $(this).prop("id");
                    
                    setTimeout(function(){
                       $("#"+btn_id).prop("disabled",false);
                    }, 5000);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_evaluacion").serialize(),
                        url: "{{ route('confirmar_envio_evaluacion_sst') }}",
                        success: function(response) {
                            if(response.success) {
                                location.reload();

                                mensaje_success("El candidato se ha enviado a evaluación sst.");
                                setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                            }else{
                                $("#modalTriSmall").find(".modal-content").html(response.view);
                                $("#modalTriSmall").modal("show");
                            }
                        }
                    });
                });
            @endif

            $("#seleccionar_todos_candidatos_vinculados").on("change", function () {
                
                var obj = $(this);
                
                var stat = obj.prop("checked");
                console.log(stat);
                
                if(stat){
                    $("input[name='req_candidato[]']").prop("checked", true);
                }else{
                    $("input[name='req_candidato[]']").prop("checked", false);
                }
                
            });

            $(document).on("click", "#enviar_contratar_asistente", function() {
                var cliente = $(this).data("cliente");
                var id = $(this).data("candidato_req");

                $.ajax({
                    type: "POST",
                    data:  "&candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_contratar2') }}",
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            function confirmar_cuenta(){
                var i = 0;
            
                @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" ||
                    route("home")=="https://pruebaslistos.t3rsc.co" || route("home")=="https://listos.t3rsc.co")
                    var c_una =  $("#numero_cuenta").val();
                    var c_dos =  $("#confirm_numero_cuenta").val();

                    if(c_una.length != 0){ //validar solo si se lleno 
                        if(c_una == c_dos){
                            i = 0//si las cuentas coinciden
                        }else{
                            alert('Confirmacion de la cuenta erroneo');
                            i = 1;
                            $("#confirm_numero_cuenta").css('border', 'solid 1px red');
                            $("#confirm_numero_cuenta").focus();
                        }
                    }
                @endif

                return i;
            }

            $(document).on("click", "#confirmar_contratacion", function() {
                var m = confirmar_cuenta();

                if(m === 1){
                    return false;
                }else{
                    if($('#fr_contratar').smkValidate()){
                        $.ajax({
                            type: "POST",
                            data: $("#fr_contratar").serialize(),
                            url: "{{ route('admin.enviar_a_contratar') }}",
                            beforeSend: function(){
                                mensaje_success("Espere mientras se carga la información");
                            },
                            success: function(response){
                                if(response.success) {
                                    $("#modalTriLarge").modal("hide");

                                    var totalTime = 5;
                                    var mensaje = '';
                                    if (response.no_contratados_masivo.length == 0) {
                                        mensaje = "El candidato se ha enviado a {{ (route('home') == 'https://gpc.t3rsc.co') ? 'aprobar' : 'contratar' }}.";
                                    }
                                    if (response.no_contratados_masivo.length > 0) {
                                        totalTime = 15;
                                        mensaje += "No se ha enviado a contratar al candidato:<br><table id='table_no_contratados' class='table table-striped'><thead><th>Documento identidad</th><th>Nombres y apellido</th><th>Motivo no se envia a contratar</th></thead><tbody>";
                                        response.no_contratados_masivo.forEach(function(cand, index) {
                                            mensaje += '<tr><td>' + cand.numero_id + '</td><td>' + cand.nombres + '</td><td>' + cand.observacion + '</td></tr>';
                                        });
                                        mensaje += "</tbody></table>";
                                    }
                                    mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                                    mensaje_success(mensaje);
                                    if (response.no_contratados_masivo.length > 0) {
                                        $('#table_no_contratados').DataTable({
                                            'stateSave': true,
                                            "lengthChange": false,
                                            "responsive": true,
                                            "paginate": true,
                                            "autoWidth": true,
                                            "searching": false,
                                            "order": [[1,"desc"]],
                                            "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
                                            "language": {
                                              "url": '{{ url("js/Spain.json") }}'
                                            }
                                        });
                                    }
                                    updateClock("tiempo_recarga", totalTime);
                                    setTimeout(function(){
                                        location.reload();
                                    }, totalTime*1000);
                                }
                            },
                            error: function(){
                                $("#modalTriLarge .close").click();
                                $("#modal_success .close").click();

                                mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                            }
                        });
                    }
                }
            });
        });
    </script>
@stop