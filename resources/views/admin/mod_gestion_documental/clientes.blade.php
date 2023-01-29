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

     @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión GDC"])

    

    <div class="clearfix"></div>

    <div class="row">
    

   

    {!! Form::model(Request::all(), ["route" => "admin.gestion_documental.clientes", "method" => "GET"]) !!}
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        

        @if(route('home') != "http://localhost/developer/public")
            @if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co")
                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="control-label">Clientes:</label>

                    
                        {!! Form::select("cliente_id", $clientes, null,
                        ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                    
                </div>

                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="control-label">Nit:</label>

                    
                        {!! Form::text("nit", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                    
                </div>
            @endif
        @else
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Áreas:</label>

               
                    {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                
            </div>
        @endif

        <div class="clearfix"></div>
        
        
        <div class="clearfix"></div>

        <div class="col-md-12 text-right">
    
             <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                Buscar <i aria-hidden="true" class="fa fa-search"></i>
            </button>

            <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route('admin.gestion_documental.clientes') }}">
                    Limpiar
            </a>
        </div>

        
    {!! Form::close() !!}
    <br>
    <br>
       

       
    </div>

    <br>

    <div class="clearfix"></div>

    

    <div class="clearfix"></div>
   
    <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
        
            <table class="table table-hover" id="data-table">
                <thead>
                    <tr>
                        {{--<th>
                            {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, ["id" => "seleccionar_todos_candidatos_vinculados"]) !!}
                        </th>--}}
                        <th>ID CLIENTE</th>
                        <th>NOMBRE</th>
                        <th>NIT</th>
                       
           
                        <th style="text-align: center;">ACCIÓN</th>
                    </tr>
                </thead>

                <tbody>
                    @if($lista_clientes->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif

                    @foreach($lista_clientes as $cliente)
                        <tr>
                            {{--<td>
                                {!! Form::hidden("req_id", $candidato_req->req_id) !!}
                                <input
                                    class="check_candi"
                                    data-candidato_req="{{ $candidato_req->req_can_id }}"
                                    data-cliente=""
                                    name="req_candidato[]"
                                    type="checkbox"
                                    value="{{ $candidato_req->req_can_id }}"
                                >
                            </td>--}}
                             <td>
                                {{ $cliente->id }}
                            </td>
                            <td>
                                {{ $cliente->nombre}}
                            </td>
                            <td>
                                {{ $cliente->nit }}
                            </td>
             
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="...">
                                    
                              
                                    <a
                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"
                                        href="{{ route('admin.gestion_documental.gestion_cliente', ['cliente_id'=>$cliente->id]) }}"
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

    

    {{--<div>
        {!! $lista_clientes->appends(Request::all())->render() !!}
    </div>--}}

    <script type="text/javascript">
    

        //Pausar firma contrato
        

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
                    
                    //$('#candidatos_llamar').val(candidatos);


                })
        });
    </script>
@stop