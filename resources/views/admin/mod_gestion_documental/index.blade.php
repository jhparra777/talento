@extends("admin.layout.master")
@section('contenedor')

    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

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

     @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión GD"])

    

    <div class="clearfix"></div>

    <div class="row">
    

   

    {!! Form::model(Request::all(), ["route" => "admin.gestion_documental.index", "method" => "GET"]) !!}
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label for="inputEmail3">@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Numero requerimiento @endif:</label>

            
                {!! Form::text("num_req", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
            
        </div>

        @if(route('home') != "http://localhost/developer/public")
            @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="control-label">Clientes:</label>

                    
                        {!! Form::select("cliente_id", $clientes, null,
                        ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                    
                </div>
            @endif
        @else
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Áreas:</label>

               
                    {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                
            </div>
        @endif

        <div class="clearfix"></div>
        
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Cédula:</label>

            
                {!! Form::text("cedula", null, ["class" => "form-control solo- | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
            
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Estado:</label>
            
                {!! Form::select("estado", $estados, null, 
                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
            
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Regional:</label>
        
            
                {!! Form::select("agencia", $agencias, null, ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
            
        </div>

        <div class="col-md-6 form-group">
          <label class="control-label" for="inputEmail3">Fecha retiro:</label>
      
           
                {!! Form::text("rango_fecha",null,
                [
                    "class"=>"form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"fecha_inicio"
                ]); !!}
          
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12 text-right">
    
             <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                Buscar <i aria-hidden="true" class="fa fa-search"></i>
            </button>

            <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("admin.gestion_documental.index") }}">
                    Limpiar
            </a>
        </div>

        
    {!! Form::close() !!}
    <br>
    <br>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="tri-fs-16 text-center mb-2">
                        ACCIONES GLOBALES
                    </h4>

                    {{-- Botones parte de arriba --}}
                    @include('admin.mod_gestion_documental.includes._section_acciones_globales_documentos')
                </div>
            </div>
        </div>

       
    </div>

    <br>

    <div class="clearfix"></div>

    

    <div class="clearfix"></div>
    <?php
        $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
    ?>
    <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
        
            <table class="table table-hover" id="data-table">
                <thead>
                    <tr>
                        <th>
                            {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, ["id" => "seleccionar_todos_candidatos_vinculados"]) !!}
                        </th>
                        <th>IDENTIFICACION</th>
                        <th>NOMBRES</th>
                        <th>#REQ</th>
                        <th>CLIENTE</th>
                        <th>CARGO</th>
                        <th>CIUDAD</th>
           
                        <th>FECHA INGRESO</th>
                        <th>FECHA FIN CONTRATO</th>
                        <th>TRAZABILIDAD</th>
                        <th style="text-align: center;">ACCIÓN</th>
                    </tr>
                </thead>

                <tbody>
                    @if($candidatos->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif

                    @foreach($candidatos as $candidato_req)
                            <?php $transferido = null;
                                $processes_collect = collect($candidato_req->procesos);
                                $processes = $processes_collect->pluck("proceso")->toArray();
                                $processes_apto = $processes_collect->where('apto', '1')->pluck("proceso")->toArray();
                             ?>
                        <tr @if($candidato_req->asistira == "0") style="background:rgba(210,0,0,.2)" @endif>
                            <td>
                                {!! Form::hidden("req_id", $candidato_req->req_id) !!}
                                <input
                                    class="check_candi"
                                    data-candidato_req="{{ $candidato_req->req_can_id }}"
                                    data-cliente=""
                                    name="req_candidato[]"
                                    type="checkbox"
                                    value="{{ $candidato_req->req_can_id }}"
                                >
                            </td>
                             <td>
                                {{ $candidato_req->numero_id }}
                            </td>
                            <td>
                                {{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}
                            </td>
                            <td>
                                {{ $candidato_req->req_id }}
                            </td>
                            <td>
                                {{ $candidato_req->cliente }}
                            </td>
                            <td>
                                {{ $candidato_req->cargo }}
                            </td>
                            <td>
                                {{$candidato_req->nombre_ciudad}}
                            </td>
                           
                           
                            
                            
                            <td>
                                @if($candidato_req->contratacion_directa)
                                    {{ $candidato->fecha_inicio }}
                                
                                @else
                                    {{ $candidato_req->fecha_ingreso }}
                                
                                @endif
                            </td>
                            <td>
                                @if(!$candidato_req->contratado_retirado)
                                    Activo
                                @else
                                    {{$candidato_req->fecha_terminacion_contrato}}
                                @endif
                            </td>
                            
                            <td id="trazabilidad-{{ $candidato_req->req_can_id }}">
                                @include('admin.reclutamiento.includes.gestion-requerimiento._section_trazabilidad_gestion',["procesos" => $candidato_req->procesos])
                            </td> 



                            <td>
                                <div class="btn-group-vertical" role="group" aria-label="...">
                                    {{--<button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-block status"
                                        data-candidato="{{ $candidato->nombres }}"
                                        data-fecha="{{ $candidato->fecha_inicio }}"
                                        data-req="{{ $candidato->req_id }}"
                                        data-observacion="{{ $candidato->observacion }}"
                                        data-user="{{ $candidato->user_envio }}"
                                        data-req_can="{{ $candidato->req_can_id }}"
                                        data-user_id="{{ $candidato->user_id }}"
                                        data-proceso_cand="{{ $candidato->proceso_candidato_req }}"
                                    >
                                        Status
                                    </button>--}}
                                    
                                       <a
                                            
                                            class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"
                                            href="{{ route('admin.gestion_documental.download_carpeta') }}?req_can[]={{$candidato_req->req_can_id}}"

                                            data-candidato="{{ $candidato->nombres }}"
                                            data-fecha="{{ $candidato->fecha_inicio }}"
                                            data-req="{{ $candidato->req_id }}"
                                            data-observacion="{{ $candidato->observacion }}"
                                            data-user="{{ $candidato->user_envio }}"
                                            data-req_can="{{ $candidato->req_can_id }}"
                                            data-user_id="{{ $candidato->user_id }}"
                                            data-proceso_cand="{{ $candidato->proceso_candidato_req }}"
                                        >
                                            Descargar carpeta
                                        </a>
                                    

                                    <a
                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"
                                        href="{{ route('admin.gestion_documental.gestion_contratacion', ['candidato' => $candidato_req->candidato_id, 'req' => $candidato_req->req_id]) }}"
                                    >
                                        Gestionar
                                    </a>

                                 
                                   

                                   

                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="modal fade" id="modal_anulacion" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4>Motivo de anulación</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <form id="fr_anular">
                            <div class="col-md-12 form-group">
                                <select class="form-control" name="motivo_anulacion" id="motivo_anulacion">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Modificación de datos del cliente</option>
                                    <option value="2">Otro</option>
                                </select>

                                <input type="hidden" name="user_id" id="anular_user_id" value="">
                                <input type="hidden" name="req_id" id="anular_req_id" value="">
                                <input type="hidden" name="cand_req" id="anular_cand_req" value="">
                                <input type="hidden" name="cliente_id" id="anular_cliente_id" value="">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="anular_contrato_frm">Anular</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        {!! $candidatos->appends(Request::all())->render() !!}
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
                                    $("#modal_peq").find(".modal-content").html(response)
                                    $("#modal_peq").modal("show")
                                    $("#modal_peq").css("overflow-y", "scroll")
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

             table=$('#data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              initComplete: function() {
              //var div = $('#data-table');
              //$("#filtro").prepend("<label for='idDepartamento'>Cliente:</label><select id='idDepartamento' name='idDepartamento' class='form-control' required><option>Seleccione uno...</option><option value='1'>  FRITURAS</option><option value='2'>REFRESCOS</option></select>");
                  this.api().column(0).each(function() {
                      var column = this;
                      console.log(column.data());
                      $('#estado_id').on('change', function() {
                          var val = $(this).val();
                          column.search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });
                  });
              },
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
          });

             allPages = table.cells( ).nodes( );

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
                    $("#modal_gr").modal("hide");
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
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
                url: "{{ route('admin.guardar_observacion') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_gr").modal("hide");
                        alert("Se ha creado la observación con éxito!");
                        //window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        //mensaje_success("El requerimiento ya se encuentra cerrado");
                        $("#modal_peq").find(".modal-content").html(response.view);
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

            $(document).on("click", ".download", function(){
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
                    url: "{{ route('admin.gestion_documental.download_carpeta') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
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
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            function enviarDocumentos() {
                $.ajax({
                    type: "POST",
                    data: $("#form_contratacion").serialize(),
                    url: "{{ route('admin.envio_documentos_contratacion') }}",
                    beforeSend: function(response) {
                        $("#modal_gr").modal("hide");
                        $.smkAlert({
                            text: 'Enviando confirmación de contratación ...',
                            type: 'info',
                            icon: 'glyphicon-info-sign'
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                          $("#modal_gr").modal("hide");

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
                            $("#modal_peq").find(".modal-content").html(response.view);
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
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
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
                        $("#modal_gr").find(".modal-content").html(response.view);
                        $("#modal_gr").modal("show");
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
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
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
                            $("#modal_gr").find(".modal-content").html(response.view);
                            $("#modal_gr").modal("show");
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
                          $("#modal_peq").find(".modal-content").html(response);
                          $("#modal_peq").modal("show");
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
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
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
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
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
                                    $("#modal_peq").modal("hide");

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
                                $("#modal_peq .close").click();
                                $("#modal_success .close").click();

                                mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                            }
                        });
                    }
                }
            });

                $(document).on("click", "#descarga_masiva", function() {
                    var candidatos=$(allPages).find(".check_candi");
                    candidatos.each(function( index ) {
                        if($(this).prop('checked')){
                        $('#bloque_candidatos_descargar').append(' <input type="hidden" name="req_can[]" value="'+$(this).val()+'"/>')
                        }
                      //console.log( index + ": " + $( this ).text() );

                    });

                    $( "#fr_candidatos" ).submit();
                    $.unblockUI();
                    
                    //$('#candidatos_llamar').val(candidatos);


                })
        });
    </script>
@stop