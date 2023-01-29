@extends("admin.layout.master")
@section('contenedor')
    <h3>Gestionar Entrevista Múltiple</h3>
    <input type="hidden" id="entrevista_multiple_id" value="{{ $entrevista->id }}">
    
    <div class="text-center">
        <h3>{{ $entrevista->titulo }}</h3>
        <p>{{ $entrevista->fecha() }}</p>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <p class="text-center">{{ $entrevista->descripcion }}</p>
    </div>
    <br>

    <?php
        $entrevistas = $entrevista->entrevista_multiple_detalles()->orderBy('apto')->paginate(3);
        $cliente_id = $entrevista->requerimiento->cliente();
    ?>
    <div class="row col-md-12">
        @foreach ($entrevistas as $key => $detalles)
            <div class="bs-callout bs-callout-primary">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <h5>
                                {{$key+1}} - {{ $detalles->datos_basicos->nombres . ' ' . $detalles->datos_basicos->primer_apellido . ' ' . $detalles->datos_basicos->segundo_apellido }}
                                @if (isset($detalles->datos_basicos->telefono_movil))
                                    <br>
                                    Telf móvil: {{ $detalles->datos_basicos->telefono_movil }}
                                @endif
                            </h5>
                            <div class="user_dashboard_pic user-layout-candidato text-center">
                                @if($detalles->user->foto_perfil != null && file_exists('recursos_datosbasicos/'.$detalles->user->foto_perfil))
                                    <img alt="user photo" style="max-width: 50%" src="{{ url('recursos_datosbasicos/'.$detalles->user->foto_perfil) }}">
                                @else
                                    <img alt="user photo" style="max-width: 60%" src="{{ url('img/personaDefectoG.jpg') }}">
                                @endif
                            </div>
                        </div>
                        <form id="form-{{$detalles->candidato_id}}">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="concepto" class="control-label">Concepto: <span></span></label>
                                    {!! Form::select("conceptos",
                                        [""=>"Concepto personalizado", "Opcion 1"=>"Opcion 1","Opcion 2"=>"Opcion 2","Opcion 3"=>"Opcion 3","Opcion 4"=>"Opcion 4"],null,
                                        [
                                            "class"=>"form-control selectconcepto",
                                            "data-concepto" => "concepto-$detalles->candidato_id",
                                            "id"=>"predefinido-$detalles->candidato_id",
                                            ($detalles->apto != null ? 'disabled' : '')
                                        ])
                                    !!}
                                    {!! Form::textarea("concepto",
                                        ($detalles->concepto != null ? $detalles->concepto : ($detalles->apto == 2 ? 'El candidato no asistió a la entrevista.' : null)),
                                        [
                                            "maxlength" => "2000",
                                            "placeholder" => "Máximo 2000 caracteres",
                                            "class"=>"form-control",
                                            "id"=>"concepto-$detalles->candidato_id",
                                            "rows"=>"5",
                                            "required"=>"required",
                                            "data-entrevista-detalle-id"=>"$detalles->id",
                                            "data-candidato"=>"$detalles->candidato_id",
                                            ($detalles->apto != null ? 'readonly' : '')
                                        ]);
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span for="calificacion" class="span-label">Calificación:</span>
                                    <div
                                        class="rateYo"
                                        id="calificacion-{{ $detalles->candidato_id }}"
                                        data-apto="{{ $detalles->apto }}"
                                        data-rateyo-rating="{{ ($detalles->calificacion != null ? $detalles->calificacion : 0) }}"
                                        data-rateyo-read-only="{{ ($detalles->apto != null ? 'true' : 'false') }}"
                                    ></div>
                                    <br>
                                    <label for="apto" class="control-label">Apto:</label>
                                    {!! Form::select("apto",
                                        [""=>"Seleccionar", "1"=>"Apto","2"=>"No apto"], $detalles->apto,
                                        [
                                            "class"=>"form-control",
                                            "id"=>"apto-$detalles->candidato_id",
                                            "required"=>"required",
                                            ($detalles->apto != null ? 'disabled' : '')
                                        ])
                                    !!}
                                </div>
                            </div>
                        </form>
                        <div class="col-md-3" style="padding-top: 20px;">
                            <?php
                                $ruta = route("admin.hv_pdf",["ref_id"=>$detalles->candidato_id]);
                            ?>
                            {{--
                                Komatsu
                                $ruta = route("admin.informe_seleccion",["user_id"=>$detalles->getReqCandId()]);
                            --}}
                            <a type="button" class="btn btn-sm btn-info" href="{{$ruta}}" target="_blank">
                                HV PDF
                            </a>
                            @if ($detalles->apto != 2)
                                @if ($detalles->apto == null)
                                    <button class="btn btn-sm btn-info" title="Guardar" id="guardar-{{$detalles->candidato_id}}" onclick='guardar_detalles("{{ $detalles->candidato_id }}", "{{ $detalles->id }}", "nuevo")'>
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Editar" style="display: none;" id="editar-{{$detalles->candidato_id}}" onclick='editar_detalles("{{ $detalles->candidato_id }}")'>
                                        <i class="fa fa-pen-square-o" aria-hidden="true"></i> Editar
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-warning" title="Editar" id="editar-{{$detalles->candidato_id}}" onclick='editar_detalles("{{ $detalles->candidato_id }}")'>
                                        <i class="fa fa-pen-square-o" aria-hidden="true"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-info" title="Guardar" style="display: none;" id="guardar-{{$detalles->candidato_id}}" onclick='guardar_detalles("{{ $detalles->candidato_id }}", "{{ $detalles->id }}", "editar")'>
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-sm btn-info" title="Guardar" style="display: none;" id="guardar-{{$detalles->candidato_id}}" onclick='guardar_detalles("{{ $detalles->candidato_id }}", "{{ $detalles->id }}", "nuevo")'>
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                                </button>
                                <button class="btn btn-sm btn-warning" title="Editar" id="editar-{{$detalles->candidato_id}}" onclick='editar_detalles("{{ $detalles->candidato_id }}")'>
                                    <i class="fa fa-pen-square-o" aria-hidden="true"></i> Editar
                                </button>
                            @endif

                            {{-- PROCESO --}}
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-warning">Proceso</button>

                                <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>

                                <ul class="dropdown-menu" role="menu" id="grupo_btn_{{ $detalles->req_candi_id }}">
                                    <!-- Examenes medicos -->  
                                    <li>
                                        <button
                                            type="button"
                                            style="width: 100%"
                                            class="btn btn-info btn-sm btn-enviar-examenes"
                                            data-cliente="{{ $cliente_id }}"
                                            data-candidato_req="{{ $detalles->req_candi_id }}"
                                            {!! ((FuncionesGlobales::validaBotonProcesos($detalles->req_candi_id, ["ENVIO_EXAMENES", "ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!}
                                        >
                                            EXAMENES MEDICOS
                                        </button>
                                    </li>

                                    {{-- No disponible para Asuservicio  --}}
                                    <li>
                                        <button
                                            type="button"
                                            style="width: 100%"
                                            class="btn btn-info btn-sm btn-enviar-estudio-seg"
                                            data-cliente="{{ $cliente_id }}"
                                            data-candidato_req="{{ $detalles->req_candi_id }}"
                                            {!! ((FuncionesGlobales::validaBotonProcesos($detalles->req_candi_id, ["ENVIO_ESTUDIO_SEGURIDAD", "ESTUDIO_SEGURIDAD", "ENVIO_CONTRATACION"])) ? "disabled='disabled'" : "") !!}
                                        >
                                            ESTUDIO SEGURIDAD
                                        </button>
                                    </li>

                                    {{-- Boton enviar a aprobar cliente --}}
                                    @if($user_sesion->hasAccess("admin.enviar_aprobar_cliente_view"))
                                        <li>
                                            <button 
                                                style="width: 100%"
                                                type="button"
                                                class="btn btn-sm btn-info btn_aprobar_cliente"
                                                data-cliente="{{$cliente_id}}"
                                                data-candidato_req="{{$detalles->req_candi_id}}"
                                                {!! ((funcionesglobales::validabotonprocesos($detalles->req_candi_id,["ENVIO_APROBAR_CLIENTE","ENVIO_CONTRATACION_CLIENTE","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!} 
                                            >
                                                ENVIAR A APROBAR CLIENTE
                                            
                                            {{-- Para Komatsu debe salir asi
                                                ENVIAR A APROBAR
                                            --}}
                                            </button>
                                        </li>
                                    @endif

                                    {{-- PRECONTRATAR | CONTRATAR --}}
                                    @if($sitio->precontrata == 1)
                                        <li>
                                            <button
                                                style="width: 100%"
                                                class="btn btn-sm btn-info pre_contratar"
                                                type="button"
                                                data-cliente="{{ $cliente_id }}"
                                                data-candidato_req="{{ $detalles->req_candi_id }}"
                                                {!! ((funcionesglobales::validabotonprocesos($detalles->req_candi_id,['PRE_CONTRATAR',"ENVIO_CONTRATACION"])
                                                    ) ? "disabled='disabled'" : "") !!}
                                            >
                                                PRE-CONTRATAR
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {!! $entrevistas->appends(Request::all())->render() !!}

    <hr>
    <div class="row">
        <form id="form-concepto-general">
            <div class="col-md-7 col-md-offset-2">
                <div class="form-group">
                    <label for="concepto_general" class="control-label">Concepto general: <span></span></label>
                    {!! Form::textarea("concepto_general", $entrevista->concepto_general,
                        [
                            "maxlength" => "2000",
                            "placeholder" => "Máximo 2000 caracteres",
                            "class" => "form-control",
                            "id" => "concepto_general",
                            "required"=>"required",
                            "rows" => "5",
                            ($entrevista->concepto_general != null ? 'readonly' : '')
                        ]);
                    !!}
                </div>
            </div>
        </form>
        <div class="col-md-1">
            <br><br><br>
            <button class="btn btn-sm btn-info" id="guardar-concepto-general" title="Guardar concepto general" onclick='guardar_concepto()'
                @if ($entrevista->concepto_general != null || $entrevista->concepto_general != '')
                    style="display: none;"
                @endif
            >
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
            </button>
            <button class="btn btn-sm btn-warning" title="Editar concepto general"
                id="editar-concepto-general" onclick='habilitar_concepto()'
                @if ($entrevista->concepto_general == null || $entrevista->concepto_general == '')
                    style="display: none;"
                @endif
            >
                <i class="fa fa-pen-square-o" aria-hidden="true"></i> Editar
            </button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <label>Enviado por: <span class="text-muted">{{ $entrevista->nombre_usuario_envio() }}</span></label>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <style>
        .swal-button--catch {
            background-color: #cd5c5c !important;
        }
        .swal-button--defeat {
            background-color: #00c0ef !important;
        }
        label span {
            font-weight: 400;
        }
        .span-label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .bs-callout {
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #aba6a6;
            border-right: none;
            border-left-width: 5px;
            border-radius: 3px;
            background-color: #e8e8e8;
        }
        .bs-callout h4, .bs-callout h5 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .bs-callout p:last-child {
            margin-bottom: 0;
        }
        .bs-callout code {
            border-radius: 3px;
        }
        .bs-callout+.bs-callout {
            margin-top: -5px;
        }
        .bs-callout-default {
            border-left-color: #777;
        }
        .bs-callout-default h4 {
            color: #777;
        }
        .bs-callout-primary {
            border-left-color: #428bca;
        }
        .bs-callout-primary h4, .bs-callout-primary h5 {
            color: #428bca;
            font-weight: 600;
        }
        .bs-callout-success {
            border-left-color: #5cb85c;
        }
        .bs-callout-success h4 {
            color: #5cb85c;
        }
        .bs-callout-info {
            border-left-color: #5bc0de;
        }
        .bs-callout-info h4, .bs-callout-info h5 {
            color: #5bc0de;
            font-weight: 600;
        }
    </style>

    <script>
        function updateClock(id_elemento, totalTime) {
            document.getElementById(id_elemento).innerHTML = totalTime;
            if(totalTime > 0){
                totalTime -= 1;
                setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
            }
        }

        function verificar_cambios_ir(_href) {
            var mensaje = 'Ha modificado concepto(s) de candidato(s). ¿Desea guardar antes de continuar?';
            if (candidatos_modificados.length > 0 && concepto_general_modificado) {
                mensaje = 'Ha modificado concepto(s) de candidato(s) y el concepto general. ¿Desea guardar antes de continuar?';
            } else if (concepto_general_modificado) {
                mensaje = 'Ha modificado el concepto general. ¿Desea guardar antes de continuar?';
            }
            if (unsaved){
                swal({
                    title: mensaje,
                    //title: 'Atención',
                    icon: "warning",
                    buttons: true,
                    buttons: {
                        cancel: "CANCELAR",
                        catch: {
                          text: "NO",
                          value: "ir",
                        },
                        defeat: {
                            text: "SI",
                            value: "guardar",
                        },
                    },
                })
                .then((respuesta) => {
                    if (respuesta == 'guardar') {
                        var detalles = [];
                        candidatos_modificados.forEach(function(candidato) {
                            datos = {};

                            datos.idEntrevistaDetalles = $("#concepto-"+candidato).data('entrevista-detalle-id');
                            datos.concepto = $("#concepto-"+candidato).val();
                            datos.apto = $("#apto-"+candidato).val();
                            datos.idCandidato = candidato;
                            datos.calificacion = $('#calificacion-'+candidato).rateYo("rating");

                            detalles.push(datos);
                        });
                        $.ajax({
                            url: "{{route('admin.ajax_guardar_preventivo_detalles_multiple')}}",
                            type: 'POST',
                            data: {
                                detalles: detalles,
                                concepto_general_modificado: concepto_general_modificado,
                                concepto_general: $("#concepto_general").val(),
                                idEntrevistaMultiple: $("#entrevista_multiple_id").val()
                            },
                            beforeSend: function(){
                                $.smkAlert({
                                    text: 'Enviando los detalles de las entrevistas múltiples.',
                                    type: 'info',
                                    icon: 'glyphicon-info-sign'
                                });
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
                                    unsaved = false;
                                    var totalTime = 3;
                                    var mensaje = 'Se han guardado los detalles de los candidatos en la entrevista múltiple.';
                                    if (response.candidatos_faltantes > 0) {
                                        totalTime = 7;
                                        mensaje += "<br><br>Pero para " + response.candidatos_faltantes + " candidatos no se registraron los datos de la entrevista múltiple.<br>";
                                    }
                                    mensaje += '<br><div style="text-align: right;">Será redireccionado en <span id="tiempo_recarga"></span> seg.</div>';
                                    mensaje_success(mensaje);
                                    updateClock("tiempo_recarga", totalTime);
                                    setTimeout(function(){
                                        if (_href == 'reload') {
                                            location.reload();
                                        } else {
                                            location.href = _href;
                                        }
                                    }, totalTime*1000);
                                } else {
                                    mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                                }
                            },
                            error:function(data){
                                mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                            }
                        });
                    } else if (respuesta == 'ir') {
                        if (_href == 'reload') {
                            location.reload();
                        } else {
                            location.href = _href;
                        }
                    }
                });
            } else {
                if (_href == 'reload') {
                    location.reload();
                } else {
                    location.href = _href;
                }
            }
        }

        $(function () {
            unsaved = false;
            candidatos_modificados = [];
            concepto_general_modificado = false;

            $(".rateYo").rateYo({
                starWidth: "24px",
                fullStar: true,
                normalFill: "#A0A0A0"
            });

            $('.sidebar-menu').find('a:not([href*="#"])').click(function (e) {
                e.preventDefault();
                verificar_cambios_ir(this.href)
            });

            $('.pagination').find('a').click(function (e) {
                e.preventDefault();
                verificar_cambios_ir(this.href)
            })

            // Monitor dynamic inputs
            $(document).on('change', ':input', function(){ //triggers change in all input fields including text type
                unsaved = true;
                if (this.name != 'apto') {
                    if ('concepto_general' == this.id) {
                        concepto_general_modificado = true;
                    } else {
                        var busqueda = candidatos_modificados.find(candidato => candidato == $(this).data('candidato'));
                        if (busqueda == undefined)
                            candidatos_modificados.push($(this).data('candidato'));
                    }
                }
            });

            $(document).on('keyup', "[maxlength]", function (e) {
                var este = $(this),
                maxlength = este.attr('maxlength'),
                maxlengthint = parseInt(maxlength),
                textoActual = este.val(),
                currentCharacters = este.val().length;
                remainingCharacters = maxlengthint - currentCharacters,
                espan = este.parent().find('label').find('span');

                // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
                if (document.addEventListener && !window.requestAnimationFrame) {
                  if (remainingCharacters <= -1) {
                      remainingCharacters = 0;            
                  }
                }

                espan.html('('+remainingCharacters+' caracteres restantes.)');

                if (!!maxlength) {
                    var texto = este.val();
                    if (texto.length >= maxlength) {
                        este.addClass("borderojo");
                        este.val(text.substring(0, maxlength));
                        e.preventDefault();
                    }
                    else if (texto.length < maxlength) {
                        este.addClass("bordegris");
                    }
                }
            });

            $('.selectconcepto').change(function () {
                //Agrega el concepto predefinido al textarea
                $('#'+$(this).data('concepto')).val(this.value);
            })


            $(document).on("click",".btn-enviar-examenes", function() {
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");
             
                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_examenes_view') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_examen", function(e) {
                e.preventDefault();

                if($('#fr_enviar_examen').smkValidate()){
                    var obj = $(this);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_examen").serialize(),
                        url: "{{ route('admin.enviar_examenes') }}",
                        success: function(response) {
                            if (response.success){
                                $("#modal_peq").modal("hide");

                                $.smkAlert({
                                    text: 'El candidato se ha enviado a exámenes médicos.',
                                    type: 'success',
                                    icon: 'glyphicon-ok'
                                });

                                var candidato_req = $("#candidato_req_fr").val();
                                $("#grupo_btn_" + candidato_req).find(".btn-enviar-examenes").prop("disabled", true);
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }
            });

            $(document).on("click",".btn-enviar-estudio-seg", function() {
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");
             
                $.ajax({
                   type: "POST",
                   data: "candidato_req=" + id + "&cliente_id=" + cliente,
                   url: "{{ route('admin.enviar_estudio_view') }}",
                    success: function(response) {
                     $("#modal_peq").find(".modal-content").html(response.view);
                     $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_estudio_seguridad", function(e) {
                e.preventDefault();
                var obj = $(this);

                $.ajax({
                    type: "POST",
                    data: $("#fr_enviar_estudio_seg").serialize(),
                    url: "{{ route('admin.enviar_estudio_seguridad') }}",
                    success: function(response) {
                        if(response.success) {
                            $("#modal_peq").modal("hide");

                            $.smkAlert({
                                text: 'El candidato se ha enviado a estudio seguridad.',
                                type: 'success',
                                icon: 'glyphicon-ok'
                            });
                            
                            var candidato_req = $("#candidato_req_fr").val();
                            $("#grupo_btn_" + candidato_req).find(".btn-enviar-estudio-seg").prop("disabled", true);
                        }else{
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }
                    }
                });
            });
        
            $(document).on("click",".btn_aprobar_cliente",function() {
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");

                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_aprobar_cliente_view') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });

            });

            $(document).on("click", "#confirmar_aprobar_cliente", function() {
                $(this).prop("disabled",true);
                var btn_id = $(this).prop("id");

                $.ajax({
                    type: "POST",
                    data: $("#fr_pruebas").serialize(),
                    url: "{{ route('admin.confirmar_aprobar_cliente') }}",
                    success: function(response) {
                        if(response.success){
                            $("#modal_peq").modal("hide");

                            $.smkAlert({
                                text: 'El candidato se ha enviado para la aprobación por parte del cliente.',
                                type: 'success',
                                icon: 'glyphicon-ok'
                            });
                            
                            var candidato_req = $("#candidato_req_fr").val();
                            $("#grupo_btn_" + candidato_req).find(".btn_aprobar_cliente").prop("disabled", true);
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                        }
                    }
                });
            });

            $(document).on("click", ".pre_contratar", function() {
                var cliente       = $(this).data("cliente");
                var candidato_req = $(this).data("candidato_req");

                $.smkAlert({
                            text: 'Enviando candidato a pre-contratar.',
                            type: 'info',
                            icon: 'glyphicon-info-sign'
                        });
                $.ajax({
                    type: "POST",
                    data: {
                        cliente : cliente,
                        candidato_req : candidato_req
                    },
                    url: "{{ route('admin.pre_contratar_view') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#pre_contratar_enviar", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_pre_contratar").serialize(),
                    url: "{{ route('admin.pre_contratar') }}",
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Enviando candidato a pre-contratar.',
                            type: 'info',
                            icon: 'glyphicon-info-sign'
                        });
                    },
                    success: function(response){
                        if(response.success) {
                            $("#modal_peq").modal("hide");

                            mensaje_success("El candidato se ha enviado a pre-contratar.");

                            setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                            setTimeout(function(){location.reload();}, 2000);
                        }
                    },
                    error: function(){
                        $("#modal_peq .close").click();
                        $("#modal_success .close").click();
                        mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                    }
                });
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

        function habilitar_concepto() {
            $('#concepto_general').attr('readonly', null);
            $('#editar-concepto-general').hide();
            $('#guardar-concepto-general').show();
        }

        function guardar_concepto() {
            if( $('#form-concepto-general').smkValidate() ){
                $.ajax({
                    url: "{{route('admin.ajax_guardar_concepto_entrevista_multiple')}}",
                    type: 'POST',
                    data: {
                        entrevista_multiple_id: $('#entrevista_multiple_id').val(),
                        concepto: $('#concepto_general').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            if (candidatos_modificados.length == 0) {
                                unsaved = false;
                            }
                            concepto_general_modificado = false;
                            $.smkAlert({
                                text: 'Se ha guardado el concepto general de la entrevista múltiple.',
                                type: 'success',
                                icon: 'glyphicon-ok'
                            });
                            $('#concepto_general').attr('readonly', 'readonly');
                            $('#guardar-concepto-general').hide();
                            $('#editar-concepto-general').show();
                        } else {
                            mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                        }
                    },
                    error:function(data){
                        mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                    }
                });
            }
        }

        function editar_detalles(idCandidato) {
            $('#editar-'+idCandidato).hide();
            $('#guardar-'+idCandidato).show();
            $('#concepto-'+idCandidato).attr('readonly', null);
            $('#concepto-'+idCandidato).focus();
            $('#apto-'+idCandidato).attr('disabled', null);
            $('#predefinido-'+idCandidato).attr('disabled', null);
            $('#calificacion-'+idCandidato).rateYo('option', 'readOnly', false);
        }

        function guardar_detalles(idCandidato, idEntrevistaDetalles, opcion) {
            if( $('#form-'+idCandidato).smkValidate() ){
                var cal = $('#calificacion-'+idCandidato).rateYo("rating");
                var concepto = $('#concepto-'+idCandidato).val();
                var apto = $('#apto-'+idCandidato).val();
                swal({
                    title: "Atención",
                    text: 'Va a guardar los datos del candidato en la entrevista múltiple ¿Desea continuar?',
                    icon: "warning",
                    buttons: true,
                    buttons: ["Cancelar", "Aceptar"]
                })
                .then((respuesta) => {
                    if (respuesta) {
                        $.ajax({
                            url: "{{route('admin.ajax_guardar_detalles_multiple')}}",
                            type: 'POST',
                            data: {
                                entrevista_detalles_id: idEntrevistaDetalles,
                                concepto: concepto,
                                calificacion: cal,
                                apto: apto
                            },
                            success: function (data) {
                                if (data.success) {
                                    var posicion_candidato = candidatos_modificados.findIndex(cand => cand == idCandidato);
                                    if (posicion_candidato != -1) {
                                        candidatos_modificados.splice(posicion_candidato, 1);
                                    }
                                    if (candidatos_modificados.length == 0) {
                                        unsaved = false;
                                    }
                                    $('#guardar-'+idCandidato).hide();
                                    $('#editar-'+idCandidato).show();
                                    $('#concepto-'+idCandidato).attr('readonly', 'readonly');
                                    $('#predefinido-'+idCandidato).attr('disabled', 'disabled');
                                    $('#apto-'+idCandidato).attr('disabled', 'disabled');
                                    $('#calificacion-'+idCandidato).rateYo('option', 'readOnly', true);
                                    if (opcion == 'nuevo') {
                                        mensaje_success("Se han guardado los detalles del candidato en la entrevista múltiple.");
                                        setTimeout(() => {
                                            if (candidatos_modificados.length == 0) {
                                                location.reload()
                                            } else {
                                                verificar_cambios_ir('reload');
                                            }
                                        }, 2000)
                                    } else {
                                        $.smkAlert({
                                            text: 'Se han guardado los detalles del candidato en la entrevista múltiple.',
                                            type: 'success',
                                            icon: 'glyphicon-ok'
                                        });
                                    }
                                } else {
                                    mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                                }
                            },
                            error:function(data){
                                mensaje_danger("Ocurrio un error, vuelve a intentarlo de nuevo.");
                            }
                        });
                    }
                });
            }
        }
    </script>
@stop