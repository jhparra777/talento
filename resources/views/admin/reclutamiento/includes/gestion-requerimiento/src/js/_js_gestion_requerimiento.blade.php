<script>
    $(function() {
        table = $('#table_with_users').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": true,
            "order": [[1,"desc"]],
            "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
            "language": {
              "url": '{{ url("js/Spain.json") }}'
            }
        });
        allPages = table.cells( ).nodes( );

        //Para webcam de firma
        @if($requermiento->tipo_proceso_id == $sitio->id_proceso_sitio)
            const procesoFirmaPictures = []
            const webcamElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('canvas');
            const webcam = new Webcam(webcamElement, 'user', canvasElement);

            const $btnAceptarFirmaContrato = document.querySelector('#btnAceptarFirmaContrato');

            const takePicture = () => {
                webcam.start()
                .then(result =>{
                    console.log("webcam started");
                })
                .catch(err => {
                    console.log(err);
                });

                //Toma la foto
                setTimeout(() => {
                    let picture = webcam.snap();

                    console.log("shot");

                    //Guardar el nombre de la foto y el string base64 PNG
                    procesoFirmaPictures.push({
                        'name': `digitacion-foto-1`,
                        'picture': picture
                    })

                    localStorage.setItem('procesoFirmaPictures', JSON.stringify(procesoFirmaPictures))
                }, 3000)
            }

            const stopWebcam = () => {
                webcam.stop();
                console.log('stop')
            }

            $btnAceptarFirmaContrato.addEventListener('click', () => {
                takePicture();

                setTimeout(() => {
                    //$('#btnIrFirmaContrato').click();
                    //$('#btnIrFirmaContrato').trigger('click');
                    console.log('abrir enlace');
                    var url = $('#btnIrFirmaContrato').attr('href');
                    window.open(url, '_blank');
                    $('#btnIrFirmaContrato').attr('href', '');
                    $('#modal_gr_local').modal('hide');
                    stopWebcam();
                }, 4000);
            });
        @endif
    });

    $('a[aria-controls="tabCandidatosOtrasFuentes"]').on('shown.bs.tab', function (e) {
        //Ocultar segundo botón agregar candidato
        document.querySelector('#boxBotonAgregarCandidato').setAttribute('hidden', true)
    })

    $('a[aria-controls="tabCandidatosVinculados"], a[aria-controls="tabCandidatosPreperfilados"]').on('shown.bs.tab', function (e) {
        //Mostrar segundo botón agregar candidato
        document.querySelector('#boxBotonAgregarCandidato').removeAttribute('hidden')
    })

    /*var table = $('#table_with_users').DataTable({
        "lengthChange": false,
        "responsive": true,
        "paginate": true,
        "autoWidth": true,
        "searching": true,
        "order": [[1,"desc"]],
        "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
        "language": {
          "url": '{{ url("js/Spain.json") }}'
        }
    });*/

    //Nuevo código para hacer la llamada virtual
    $(document).on("click", "#llamada_virtual", function() {
        var candidatos = $(allPages).find(".check_candi");

        candidatos.each(function( index ) {
            if($(this).prop('checked')){
                $('#bloque_candidatos_llamar').append('<input type="hidden" name="candidatos_llamar[]" value="'+$(this).val()+'"/>')
            }
            //console.log( index + ": " + $( this ).text() );
        });

        $( "#fr_candidatos" ).submit();
        
        //$('#candidatos_llamar').val(candidatos);
    })
    //fin código para la llamada virtual

    $('#search_cand').unbind().bind('keyup', function() {
        //alert();
        console.log(this.value);
        var colIndex = 1;
        console.log(colIndex);
       table.column(colIndex).search(this.value).draw();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function sendContractFirmForm(ruta) {
        $('<form>', {
            "method" : "get",
            "id": "form_contrato_firma",
            "action": ruta
        }).appendTo(document.body).submit();
    }

    //- ElEmpleo
    @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'https://desarrollo.t3rsc.co')
        $(document).on("click", "#loadCandidatesEE", function() {
            var idOffer     = $('#eeIdOffer').val();
            var consultaEE  = $('#consultaEE').val();
            var reqId       = $('#reqId').val();

            const btnCargarCandidatos = document.querySelector('#loadCandidatesEE');

            if (consultaEE == 1) {
                if (confirm('¿Desea listar nuevamente los candidatos desde elempleo?')) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.aplicados_ee') }}',
                        data: {
                            idOffer     : idOffer,
                            reqId       : reqId
                        },
                        beforeSend: function () {
                            document.querySelector('#btnLoadEE').style.display = 'none';

                            $('#preLoader').css('display', 'initial');
                        },
                        success: function(response) {
                            if(response.success == true){
                                document.querySelector('#btnLoadEE').style.display = 'none';
                                $('#preLoader').css('display', 'none');
                                btnCargarCandidatos.textContent = 'Cargar candidatos desde ElEmpleo';

                                document.querySelector('#applyBoxEE').innerHTML = response.view;

                                $('#table_with_ee').DataTable({
                                    "lengthChange": false,
                                    "responsive": true,
                                    "paginate": true,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [[ 1, "desc" ]],
                                    "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
                                    "language": {
                                      "url": '{{ url("js/Spain.json") }}'
                                  }
                                });
                            }
                        },
                        error: function (response) {
                            document.querySelector('#btnLoadEE').style.display = 'initial';
                            $('#preLoader').css('display', 'none');
                            btnCargarCandidatos.textContent = 'Reintentar';
                        }
                    });
                }else{
                }
            }else if(consultaEE == 0){
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.aplicados_ee')}}',
                    data: { idOffer: idOffer, reqId: reqId},
                    beforeSend: function () {
                      document.querySelector('#btnLoadEE').style.display = 'none';
                      $('#preLoader').css('display', 'initial');
                    },
                    success: function(response) {
                        if(response.success == true){
                            document.querySelector('#btnLoadEE').style.display = 'none';
                            $('#preLoader').css('display', 'none');
                            btnCargarCandidatos.textContent = 'Cargar candidatos desde ElEmpleo';

                            document.querySelector('#applyBoxEE').innerHTML = response.view;

                            $('#table_with_ee').DataTable({
                                "lengthChange": false,
                                "searching": false,
                                "paging": true,
                                "bPaginate": false,
                                "lengthMenu": [[6, 25, 50, -1], [6, 25, 50, "All"]],
                                "language": {
                                    "url": '{{ url("js/Spain.json") }}'
                                }
                            });
                        }
                    },
                    error: function (response) {
                        document.querySelector('#btnLoadEE').style.display = 'initial';
                        $('#preLoader').css('display', 'none');
                        btnCargarCandidatos.textContent = 'Reintentar';
                    }
                });
            }else{
            }
        });

        // Seleccionar todos los candidatos de ElEmpleo
        $(document).on("change", "#select_apply_ee", function () {
            var obj = $(this);
            var stat = obj.prop("checked");

            if(stat){
                $("input[name='apply_candidates_ee[]']").prop("checked", true);
            }else{
                $("input[name='apply_candidates_ee[]']").prop("checked", false);
            }
        });

        /*$(document).on('click', '#btn_add_ee_candidates', function () {
            //let inputCheck = $("input[name='apply_candidates_ee[]']").is(":checked");
            if($("input[name='apply_candidates_ee[]']").is(":checked")) {
             $('#add_ee_candidates').submit();
            }else{
             $("#ul_error_ee").html('<li>No se seleccionaron candidatos.</li>');
             $("#modal_info_async_view").modal("show");
            }
        });*/

        $(document).on("click", "#btn_add_ee_candidates", function(e) {
            e.preventDefault();
            var ids_req_cand = [];
            var cand = 0;
            var candidatos=$("input[name='apply_candidates_ee[]']");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    ids_req_cand.push($(this).val());
                    cand++;
                }
            });

            if ($("input[name='apply_candidates_ee[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos_fuentes:ids_req_cand,
                       requerimiento_id:$("#req_id_section_aplicacion_ee").val(),
                       asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            } else {
                $.smkAlert({text: 'Debe seleccionar 1 o mas candidatos.', type:'danger'})
            }
        })
    @endif
    //----

    //Modal ranking de aplicados
    $(document).on("click", "#ver_ranking", function () {
        var req_id = $(this).data("req")
        var cargo_id = $(this).data("cargo_id")

        $.ajax({
            data: {
                req_id: req_id,
                cargo_id : cargo_id
            },
            url: "{{ route('admin.ver_ranking') }}",
            success: function (response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
            }
        });
    });

    //Modal respuestas de aplicados
    $(document).on("click", "#ver_respuestas", function () {
        var req_id = $(this).data("req");
        var cargo_id = $(this).data("cargo_id")

        $.ajax({
            data: {
                req_id: req_id,
                cargo_id: cargo_id
            },
            url: "{{ route('admin.ver_respuestas') }}",
            success: function (response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
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

    $(document).on("click", "#pausar_firma", function() {
        var user_id = $(this).data("user_id");
        var req_id = $(this).data("req_id");
        var cand_req = $(this).data("req_cand_id");
        var cliente = $(this).data("cliente");

        $.ajax({
            type: "POST",
            url: "{{ route('admin.pausar_firma_virtual') }}",
            data: {
                user_id : user_id,
                req_id : req_id,
                cand_req : cand_req
            },
            beforeSend: function() {
                mensaje_success('Actualizando estado ...');
            },
            success: function(response) {
                if(response.success == true){
                    if(response.stand_by == 1){
                        mensaje_success('Firma de contrato pausada');
                        $("#pausar_firma").html('INICIAR FIRMA');
                        
                        setTimeout(() => {
                            $("#modal_success").modal("hide");
                        }, 1500)
                    }else if(response.stand_by == 0){
                        //Si la firma está pausada
                        setTimeout(() => {
                            $("#modal_success").modal("hide");
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
                                $("#modal_peq").find(".modal-content").html(response);
                                $("#modal_peq").modal("show");
                                $("#modal_peq").css("overflow-y", "scroll");
                            }
                        });

                        //mensaje_success('Firma de contrato iniciada');
                        $("#pausar_firma").html('PAUSAR FIRMA');
                    }
                }else if(response.firmado == true){
                    mensaje_danger('El contrato ya se encuentra firmado.');
                }else{
                    mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                }
            }
        });
    });

    $(document).on("click", "#confirmar_informacion_contratacion", function() {
        $.ajax({
            type: "POST",
            data: $("#fr_informacion_contratacion").serialize(),
            url: "{{ route('admin.guardar_informacion_contratacion') }}",
            beforeSend: function(){
                mensaje_success("Espere mientras se carga la información");
            },
            error: function(){
                $("#modal_peq .close").click();
                $("#modal_success .close").click();
                mensaje_danger("Ha ocurrido un error. Verifique los datos.");
            },
            success: function(response){
                if(response.success) {
                    $("#modal_peq").modal("hide");

                    mensaje_success("La información se ha editado correctamente y el contrato ha sido iniciado nuevamente.");

                    setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                    setTimeout(function(){ location.reload(); }, 2000);
                } else {
                    $("#modal_success .close").click();
                    $("#modal_success").modal("hide");

                    $("#modal_peq").find(".modal-content").html(response.view);

                    $("#modal_peq").css("overflow-y","scroll");
                }
            }
        });
    });

    //Anular contrato
    $(document).on('click', "#anular_contrato", function () {
        $("#modal_anulacion").modal("show");

        var user_id = $(this).data("user_id");
        var req_id = $(this).data("req_id");
        var cand_req = $(this).data("req_cand_id");
        var cliente_id = $(this).data("cliente_id");

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
                    }, 2000)
                    
                    if(confirm('¿Deseas enviar a contratar nuevamente al candidat@?')){
                        //Llamar función con todo
                        enviar_a_contratar(cand_req, cliente_id)
                    }else{
                        //Cerrar modal y ya
                        window.location.reload(true);
                    }
                }else{
                    mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                }
            }
        });
    });

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
        });
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

                        mensaje_success("El candidato se ha enviado a {{(route('home') == 'https://gpc.t3rsc.co') ? 'aprobar' : 'contratar'}}.");

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
        var req_id=$(this).data("req_id");

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

    $(document).on("click", "#pre_contratar", function() {
        var cliente       = $(this).data("cliente");
        var candidato_req = $(this).data("candidato_req");

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
        $(this).prop("disabled",true);
        $.ajax({
            type: "POST",
            data: $("#fr_pre_contratar").serialize(),
            url: "{{ route('admin.pre_contratar') }}",
            beforeSend: function(){
                mensaje_success("Enviando candidato a pre-contratar");
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

    $(document).on("click", "#g_empresa_contrata", function() {

         
        var empresa = $('#empresa_contrata').val();
        var req = {{$requermiento->id}};
        if(empresa!=""){
        $.ajax({
           type: "POST",
           url: "{{route('admin.cambio_empresa')}}",
           data: {empresa : empresa, req : req},
           success: function(response) {
             if(response.success == true){

               mensaje_success('Logo actualizado');
             
             }else{
              mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
             }
            }
        });

        }
        else{

            mensaje_danger('Debe seleccionar una empresa');
            empresa.focus();

        }
    });

    $(document).on("click", "#dotacion", function() {
         
        var req = {{$requermiento->id}};

            $.ajax({
              type: "POST",
              data:{req:req},
              url: "{{route('admin.dotacion_view')}}",
              success: function(response) {
                $("#modal_peq").find(".modal-content").html(response);
                $("#modal_peq").modal("show");
                $("#req").val(req);
              }
            });
    });

    $(document).on("click", "#kactus", function() {
         
        var req = {{$requermiento->id}};

            $.ajax({
              type: "POST",
              data:{req:req},
              url: "{{route('admin.kactus_view')}}",
              success: function(response){

               $("#modal_peq").find(".modal-content").html(response);
               $("#modal_peq").modal("show");
               $("#req").val(req);

              }
            });
    });

    $(document).on("click", "#confirmar_dotacion", function() {
            
      $.ajax({
         type: "POST",
         data: $("#fr_dotacion").serialize(),
         url: "{{route('admin.confirmar_dotacion')}}",
        success: function(response){
         if(response.success) {
          mensaje_success("Se guardado detalle de dotacion.");
            location.reload();
         }else{ 
          //$("#modal_peq").find(".modal-content").html(response.view);
          $("#modal_peq").modal("show");
         }
        }

       });

    });

    $(document).on("click", "#confirmar_kactus", function() {
                
        $.ajax({
            type: "POST",
            data: $("#fr_kactus").serialize(),
            url: "{{route('admin.confirmar_kactus')}}",
            success: function(response){
                if(response.success){
                    mensaje_success("Se guardado el id Kactus.");
                    location.reload();
                }else{
                    $("#modal_peq").modal("show");
                }
            }
        });
    });

    $(document).on("click", "#reabrir", function() {
        var req = $(this).data("req");

        $.ajax({
            type: "POST",
            data: {
                req : req
            },
            url: "{{ route('admin.reabrir_req') }}",
            success: function(response){

             if(response.success == true) {
                   
              mensaje_success('Se ha abierto el requerimiento nuevamente');
              
              setTimeout(function(){
                location.reload();
              }, 3000);
                                      
             }
            }
        });
    });

    function actualizar_trazabilidad(tipo){
        $("#trazabilidad").append(' <div style="text-align: center;" id="respuestas">'+tipo+'<br> </div> <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">');
    }

    function actualizar_trazabilidad_individual(tipo,req_cand, id_proceso){
        switch(tipo) {
            case "ENV_REF":
                var url = "{{route('admin.gestionar_referencia', ':id') }}";
                break;
            case "ENV_DOCU":
                var url = "{{route('admin.gestionar_documentos', ':id') }}";
                break;
            case "ENV_PRUE":
                var url = "{{route('admin.gestionar_prueba', ':id') }}";
                break;
            case "ENV_ENTRE":
                var url = "{{route('admin.gestionar_entrevista', ':id') }}";
                break;
            case "ENV_ENTRE_VIR":
                var url = "{{route('admin.gestionar_entrevista_virtual', ':id') }}";
                break;
            case "ENV_EXAME":
                var url = "{{route('admin.gestionar_documentos_medicos', ':id') }}";
                break;
            case "ENV_PRUEBA_IDIO":
                var url = "{{route('admin.gestionar_prueba_idioma', ':id') }}";
                break; 
            case "ENV_EST_SEG":
                var url = "{{route('admin.gestionar_documentos_estudio_seguridad', ':id') }}";
                break;
            default:
                var url = "";
        } 

        url = url.replace(':id', id_proceso);

        if(tipo == "ENV_ENTRE_VIR"){
            url = url.replace(':id', req_cand);
            $("#trazabilidad-"+req_cand).append(' <div style="text-align: center;" id="respuestas">'+tipo+'<br> </div> <a target="_black" href='+url+' class="btn" id="btn-irReq"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>    Ir </a> <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">');
        }else{
            $("#trazabilidad-"+req_cand).append(' <div style="text-align: center;" id="respuestas">'+tipo+'<br> </div> <a target="_black" href='+url+' class="btn" id="btn-irReq"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>    Ir </a> <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">');
        }
    }

    function updateClock(id_elemento, totalTime) {
        document.getElementById(id_elemento).innerHTML = totalTime;
        if(totalTime > 0){
            totalTime -= 1;
            //console.log(id_elemento + ' ' + totalTime);
            setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
        }
    }

    $(function() {
        /*
            $('#time-inicio').timepicker();

            $(document).on("click",".btn_observaciones", function() {
                
                var req_can_id = $(this).data("req_can_id");
                
                $.ajax({
                    type: "POST",
                    data: "req_can_id=" + req_can_id ,
                    url: "{{ route('admin.ver_observacion') }}",
                    success: function(response) {
                        $("#modal_gr").modal("hide");
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });

            });
        */
       
       $('#table_with_users').delegate( '.btn_observaciones', 'click', function(){

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

        $(".btn_pre_contratacion_masivo").on("click", function() {
            var ids_req_cand = "";
            var cand = 0;
            var candidatos=$(allPages).find(".check_candi");
            candidatos.each(function(index ) {
                //console.log(index + ' ' + $(this).val() + ' ' + $(this).prop('checked'));
                if($(this).prop('checked')){
                    if(cand > 0){
                        ids_req_cand += "&"
                    }
                    ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                    cand++;
                }
            });

            if (ids_req_cand != "") {
                $.ajax({
                    type: "POST",
                    data: ids_req_cand,
                    url: "{{ route('admin.pre_contratar_masivo_view') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        //$("#modal_gr").modal("hide");
                        $("#modal_peq").modal("show");
                    }
                });
            } else {
                mensaje_danger("Debe seleccionar 1 o mas candidatos");
            }
        });

        $(".btn_entrevista_multiple").on("click", function() {
            var ids_req_cand = "";
            var cand = 0;
            var candidatos=$(allPages).find(".check_candi");
            candidatos.each(function(index ) {
                //console.log(index + ' ' + $(this).val() + ' ' + $(this).prop('checked'));
                if($(this).prop('checked')){
                    if(cand > 0){
                        ids_req_cand += "&"
                    }
                    ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                    cand++;
                }
            });

            if (ids_req_cand != "") {
                $.ajax({
                    type: "POST",
                    data: ids_req_cand,
                    url: "{{ route('admin.enviar_entrevista_multiple_view') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        //$("#modal_gr").modal("hide");
                        $("#modal_peq").modal("show");
                    }
                });
            } else {
                mensaje_success("Debe seleccionar al menos un candidat@");
            }
        });

        $(document).on("click", "#confirmar_entrevista_multiple", function() {
            if($('#fr_entrevista_multiple').smkValidate()){
                $.ajax({
                    type: "POST",
                    data: $("#fr_entrevista_multiple").serialize(),
                    url: "{{ route('admin.confirmar_entrevista_multiple') }}",
                    beforeSend: function(){
                        $("#modal_peq").modal("hide");
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
                            var totalTime = 3;
                            var mensaje = 'Se han enviado a entrevista múltiple los candidatos satisfactoriamente.';
                            if (response.candidatos_no_enviados.length > 0) {
                                totalTime = 7;
                                mensaje += "<br><br>Pero " + response.candidatos_no_enviados.length + " candidatos ya se encuentran en proceso de entrevista múltiple y no se han enviado:<br>";
                                response.candidatos_no_enviados.forEach(function(cand, index) {
                                    mensaje += '<b>' + cand + '</b>';
                                    if (response.candidatos_no_enviados.length - 1 > index) {
                                        mensaje += ' - ';
                                    }
                                });
                            }
                            mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                            mensaje_success(mensaje);
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

        $(document).on("click", "#confirmar_pre_contratar_masivo", function() {
            
            $.ajax({
                type: "POST",
                data: $("#fr_pre_contratar_masivo").serialize(),
                url: "{{ route('admin.confirmar_pre_contratar_masivo') }}",
                beforeSend: function(){
                    $("#modal_peq").modal("hide");
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
                        var mensaje = 'Se han pre-contratado los candidatos satisfactoriamente.';
                        if (response.candidatos_no_precontratados.length > 0) {
                            totalTime = 10;
                            mensaje += "<br><br>Pero " + response.candidatos_no_precontratados.length + " candidatos ya se encuentran en proceso de pre-contratación o contratación y no se han enviado:<br>";
                            response.candidatos_no_precontratados.forEach(function(cand, index) {
                                mensaje += '<b>' + cand + '</b>';
                                if (response.candidatos_no_precontratados.length - 1 > index) {
                                    mensaje += ' - ';
                                }
                            });
                        }
                        mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                        mensaje_success(mensaje);
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

        });

        $(".btn_contratacion_masivo").on("click", function() {
            var ids_req_cand = "";
            var cand = 0;
            var candidatos=$(allPages).find(".check_candi");
            candidatos.each(function(index ) {
                //console.log(index + ' ' + $(this).val() + ' ' + $(this).prop('checked'));
                if($(this).prop('checked')){
                    if(cand > 0){
                        ids_req_cand += "&"
                    }
                    ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                    cand++;
                }
            });

            if (ids_req_cand != "") {
                $.ajax({
                    type: "POST",
                    data: ids_req_cand,
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

        $(".btn_contratacion_cliente_masivo").on("click", function() {
           
           var cliente_id = $(this).data("cliente");
           var req_id = $(this).data("req_id");

            $.ajax({
                type: "POST",
                data: $("input[name='req_candidato[]']").serialize() + "&cliente_id="+cliente_id 
                + "&req_id="+req_id,
                url: "{{ route('admin.contratar_masivo_cliente') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click", "#confirmar_contratacion_masivo_admin", function() {
            
            $.ajax({
                type: "POST",
                data: $("#fr_contratar_masivo_req").serialize(),
                url: "{{ route('admin.contratar_masivo_cli') }}",
                beforeSend: function(){
                    mensaje_success("Espere mientras se carga la informacion");
                },
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        alert("Los datos de {{(route('home') == 'https://gpc.t3rsc.co')?'aprobación':'contratación'}} han sido enviados.");
                        location.reload();
                    } else {
                        $("#modal_peq").modal("hide");
                        mensaje_danger(response.view);
                    }
                }
            });

        });

        $('#seleccionar_todos_candidatos_apli').on('change', function(){

            
            var obj = $(this);
            
            var stat = obj.prop("checked");

            console.log(stat);

            if(stat){
                $("input[name='aplicar_candidatos[]']").prop("checked", true);
            }else{
                $("input[name='aplicar_candidatos[]']").prop("checked", false);
            }
            
        });

        $("#seleccionar_todos_candidatos_reclutamiento_externo").on("change", function () {
            
            var obj = $(this);
            
            var stat = obj.prop("checked");

            //console.log(stat);

            if(stat){
                $(".externo").prop("checked", true);
            }else{
                $(".externo").prop("checked", false);
            }
            
        });

        $("#seleccionar_todos_candidatos_fuentes").on("change", function () {
            
            var obj = $(this);
            
            var stat = obj.prop("checked");

            console.log(stat);
            
            if(stat){
                $("input[name='aplicar_candidatos_fuentes[]']").prop("checked", true);
            }else{
                $("input[name='aplicar_candidatos_fuentes[]']").prop("checked", false);
            }
            
        });
        
        $("#seleccionar_todos_candidatos_preperfilados").on("change", function () {
            
            var obj = $(this);
            
            var stat = obj.prop("checked");
            
            console.log(stat);
            
            if(stat){
                $("input[name='aplicar_candidatos_preperfilado[]']").prop("checked", true);
            }else{
                $("input[name='aplicar_candidatos_preperfilado[]']").prop("checked", false);
            }
            
        });

        $(document).on("click","#seleccionar_todos_candidatos_vinculados",function () {
            
            var obj = $(this);
            $('#table_with_users').DataTable().destroy();
            var stat = obj.prop("checked");
            console.log(stat);
            if(stat){

             $("tbody .check_candi").each(function(i) {
               // console.log($(this).html());
                $(this).prop("checked", true);
             });
             //$("input.check_candi").prop("checked", true);
            }else{
              
              $(document).find(".check_candi").prop("checked", false);
            }
            
            $('#table_with_users').DataTable({
                "lengthChange": true,
                "responsive": true,
                "paginate": true,
                "autoWidth": true,
                "searching": false,
                "order": [[1,"desc"]],
                "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
                "language": {
                  "url": '{{ url("js/Spain.json") }}'
                }
            });
            
        });

        $(document).on("click","#videoPerfil",function() {

            var user_id = $(this).data("candidato_id");

            $.ajax({
                type: "POST",
                data: {user_id:user_id},
                url: "{{route('ver_video_perfil')}}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click","#datos_contacto_mostrar", function () {
            
            var datos_basicos_id = $(this).data("datos");

            $.ajax({
                type: "POST",
                data: {datos_basicos_id: datos_basicos_id},
                url: "{{ route('admin.datos_contacto_mostrar') }}",
                success: function (response) {

                    location.reload()
                }
            });

        });

        $(document).on("click","#datos_contacto_no_mostrar", function () {
            
            var datos_basicos_id = $(this).data("datos");

            $.ajax({
                type: "POST",
                data: {datos_basicos_id: datos_basicos_id},
                url: "{{ route('admin.datos_contacto_no_mostrar') }}",
                success: function (response) {
                    location.reload() 
               }
            });

        });

        $(document).on("click", ".enviar_llamada", function() {
            
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.seguimiento_candidato') }}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            })

        });        

        //Enviar a vincular candidato
        $(document).on("click",".btn_enviar_vincular",function() {
            
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $(this).prop("disabled",true);

            var btn_id = $(this).prop("id");

            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.vincular') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });
        // -------- /

        // Guardar cita
        $(document).on("click", "#guardar_cita", function() {
            $.ajax({
                data: $("#fr_citacion").serialize(),
                url: "{{route('admin.guardar_citacion')}}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se ha guardado la cita correctamente.");
                        $("#modal_peq").modal("hide");
                        window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });
        
        });
        // -------- /

        // Confirmar envio a validacion al candidato
        $(document).on("click", "#confirmar_vinculacion", function() {
            
            $(this).prop("disabled",true);
            
            var btn_id = $(this).prop("id");
            
            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_vinculacion").serialize(),
                url: "{{ route('admin.confirmar_vinculacion') }}",
                success: function(response) {
                    if (response.success) {
                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);
                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_pruebas").prop("disabled", true);
                        mensaje_success("El candidato se ha enviado a vinculación.");
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        
        });
        // ------- /

        $(document).on("click", ".modal_citacion", function() {
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
            var user_id = $(this).data("candidato_user");
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente + "&candidato_user=" + user_id,
                url: "{{ route('admin.proceso_citacion') }}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            })
        
        });

        // Generar PDF informe preliminar
        $(document).on("click", "#informe_preliminar_pdf", function(){
            $.ajax({
                type: "POST",
                data: $("#fr_candidatos").serialize(),
                url: "{{ route('admin.informe_preliminar') }}",
                success: function(response){
                    $("#mensaje-error").hide();
                    window.open(html(response.view),"_blank");
                },
                error: function(response){
                    $.each(response.responseJSON, function(index, val){
                      $("#error").html(val);
                    });
                    $("#mensaje-error").fadeIn();
                }
            });
        
        });
        // ---------- /

        // Formulario Informe preliminar
        $(document).on("click", ".get_informe_preliminar", function() {
            
            var id_req = {{$requermiento->id}};
            var cliente = $(this).data("cliente");
            var user_id = $(this).data("candidato_user");
            var valida_boton = $(this).data("valida_boton");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id_req + "&cliente_id=" + cliente + "&candidato_user=" + user_id + "&valida_boton=" + valida_boton,
                url: "{{ route('admin.informe_preliminar_formulario') }}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response.view);
                    $("#modal_gr").modal("show");
                    $.each(response.data, function(index, val){
                        $(".criterio").eq(index).val(val.puntuacion);
                        $(".id_preliminar").eq(index).val(val.id); 
                    });
                }
            })

        });
        //--------- /

        //INFORME INDIVIDUAL
        $(document).on("click", "#btn_gestion_indi", function() {
            var id_req = $(this).data("req_id");    
            var user_id = $(this).data("candidato_user");

            $.ajax({
                type: "POST",
                data: "id_req=" + id_req + "&candidato_user=" + user_id ,
                url: "{{ route('admin.gestion_informe_individual') }}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response.view);
                    $("#modal_gr").modal("show");
                    $.each(response.data, function(index, val){
                        //$(".criterio").eq(index).val(val.puntuacion);
                        //$(".id_preliminar").eq(index).val(val.id); 
                    });
                }
            })

        });
        //FIN INFORME INDIVIDUAL

        $(document).on("click", "#guardar_informe_individual", function() {    
            $.ajax({
                data: $("#fr_individual").serialize(),
                url: "{{route('admin.guardar_informe_individual')}}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han guardado las calificaciones correctamente.");
                        $("#modal_peq").modal("hide");
                        window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }            

                 }
            });

        });

        // Guardar Informe Preliminar
        $(document).on("click", "#guardar_preliminar", function(e) {
            e.preventDefault();
            $(this).prop("disabled",true);
            $.ajax({
                data: $("#fr_preliminar").serialize(),
                url: "{{route('admin.guardar_informe_preliminar')}}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se ha guardado la calificación correctamente.");
                        $("#modal_peq").modal("hide");
                        window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';
                    } else {
                        $(this).prop("disabled",false);
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });

        });
        //---- /

        // Actualizar Informe Preliminar
        $(document).on("click", "#actualizar_preliminar", function(e) {
            e.preventDefault();
            $.ajax({
                data: $("#fr_preliminar").serialize(),
                url: "{{route('admin.actualizar_informe_preliminar')}}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se ha guardado la calificación correctamente.");
                        $("#modal_peq").modal("hide");
                        window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });

        });
        //---------- /

        $("#detalle_req").on("click", function() {
            
            var req = $(this).data("req");

            $.ajax({
                data: {id: req},
                url: "{{route('admin.detalle_requerimiento')}}",
                success: function(response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });

        });

        // Ingresar candidato otras fuentes
        $("#ingresar_candidato, #ingresarCandidatoOtrasFuentes").on("click", function() {
            var id = $(this).data("req");

            $.ajax({
                type: "POST",
                data: "requerimiento_id=" + id,
                url: "{{route('admin.agregar_candidato_nuevo')}}",
                success: function(response) {
                    $("#modalTriSmall").find(".modal-content").html(response.view)
                    $("#modalTriSmall").modal("show")
                }
            })
        })

        $(document).on("click",".edit-fuente", function(e) {
            
            e.preventDefault();
            var url = $(this).data("url");

            $.ajax({
                type: "POST",
                url: url,
                success: function(response) {
                    $("#modalTriSmall").find(".modal-content").html(response.view);
                    $("#modalTriSmall").modal("show");
                }
            });

        });

        $(document).on("click",".elim-candidato-modulo", function(e) {
            e.preventDefault();
            var url = $(this).data("url");
            var modulo = $(this).data("modulo");
            var id_buscar = $(this).data("id_buscar");
            var row = $(this).parents().parents();

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    modulo: modulo,
                    id_buscar: id_buscar
                },
                error: function() {
                    mensaje_success("A ocurrido un error vuelve a intentar"+'/'+row.html());  
                },
                success: function(response) {
                    if(response.success){
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }else{
                        mensaje_success("A ocurrido un error vuelve a intentar");
                    }
                }
            });
        });

        $(document).on("click","#confirmar_eliminar_candidato_gestion", function(e) {
            if ($('#frm_eliminar_candidato_gestion').smkValidate()) {
                $("#modal_peq").modal("hide");
                let modulo = $('#modulo_eliminar_gestion').val();
                let req_id = $('#req_id_eliminar_gestion').val();
                let candidato_id = $('#candidato_id_eliminar_gestion').val();
                let id_registro = $('#id_registro_eliminar_gestion').val();
                let observacion = 'Candidato descartado req. ' + req_id + ' ' + modulo + ' - ' + $('#observacion_eliminar_gestion').val();
                let motivo_descarte_id = $('#motivo_descarte_id').val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.confirmar_eliminar_candidato_gestion_modulo') }}",
                    data: {
                        modulo: modulo,
                        id_registro: id_registro,
                        candidato_id: candidato_id,
                        req_id: req_id,
                        observacion: observacion,
                        motivo_descarte_id: motivo_descarte_id
                    },
                    error: function() {
                        mensaje_danger("A ocurrido un error vuelve a intentar"+'/'+row.html());  
                    },
                    success: function(response) {
                        if(response.success){
                            mensaje_success("Se ha eliminado correctamente");
                            if (modulo == 'preperfilado') {
                                carga_filtro(1);
                            } else if (modulo == 'postulado') {
                                carga_filtro_aplicaron(1);
                            } else {
                                setTimeout(function(){
                                    //otras fuentes
                                    location.reload();
                                }, 2000);
                            }
                            setTimeout(function(){
                                $("#modal_success").modal("hide"); 
                            }, 3000);
                        }else{
                            mensaje_danger("A ocurrido un error vuelve a intentar");
                        }
                    }
                });
            }
        })

        $(document).on("click", ".obs-candidato-hv", function(e) {
            e.preventDefault();
            var url = $(this).data("url");
            var candidato_id = $(this).data("candidato_id");
            var row = $(this).parents().parents();

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    candidato_id: candidato_id
                },
                error: function() {
                    mensaje_success("A ocurrido un error vuelve a intentar"+'/'+row.html());  
                },
                success: function(response) {
                    if(response.success){
                        $("#modal_gr").find(".modal-content").html(response.view);
                        $("#modal_gr").modal("show");
                    }else{
                        mensaje_success("A ocurrido un error vuelve a intentar");
                    }
                }
            });
        })

        $(document).on("click",".elim-fuente", function(e) {
            
            e.preventDefault();
            var url = $(this).data("url");
            var row = $(this).parents().parents();

            $.ajax({
                type: "GET",
                url: url,
                error: function(){

                  mensaje_success("A ocurrido un error vuelve a intentar"+'/'+row.html());  
                },
                success: function(response) {
                  //  console.log(response);
                 if(response.success){

                  mensaje_success("Se ha eliminado correctamente.");
                  $('#tr_candidato_'+response.id).hide();
                  //row.remove();
                  //return false;
                 }else{

                  mensaje_success("A ocurrido un error vuelve a intentar");
                 }
                }
            });

        });

        //eliminar candidatos preperfilados

        $(document).on("click",".elim-preperfilado", function(e) {
            
            e.preventDefault();
            var url = $(this).data("url");
            var row = $(this).parents().parents();

            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                  //  console.log(response);
                 if(response.success){

                  mensaje_success("Se ha eliminado correctamente.");
                  $('#tr_candidato_'+response.id).hide();
                  //row.remove();
                  //return false;
                 }
                }
            });

        });

        // Guardar candidato otras fuentes
        $(document).on("click", "#guardar_candidato_fuente", function(e) {
           // e.preventDefault();
            //alert('envio');
            if($('#fr_otra_fuente').smkValidate()){
                $(this).prop("disabled", false);
                url = $("#fr_otra_fuente").attr('action');

                $.ajax({
                    type: "POST",
                    data: $("#fr_otra_fuente").serialize(),
                    url:  url,
                    error: function (jqXHR, textStatus, data) {
                        //console.log(jqXHR.responseText[0]);
                        var valor = JSON.parse(jqXHR.responseText);
                        var mensaje = "";
                        $.each(valor, function (k, v) {

                            mensaje += k + ": "+ v + " \n\n ";

                            $('select[name='+k+']').after('<span class="text text-danger">'+v+'</span>');

                        });
                        //swal("Atencion",mensaje,"warning");
                        // $("#modal_gr").modal('toggle');
                        return false;
                    },
                    success: function(response) {

                        var candidatos = response.candidatos;

                        if(response.success==false) {
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                return false;
                            }
                            mensaje_danger("El candidato ya está en otras fuentes");
                        }

                        if(response.candidatos == ''){

                            $('#no_hay').show();

                        }else{

                            if(typeof response.editar != 'undefined') {
                                $('#tr_candidato_'+candidatos.id).remove();
                            }

                            var tr = $("<tr id='tr_candidato_"+candidatos.id+"'></tr>");

                            tr.append( $("<td> <input name='aplicar_candidatos_fuentes[]' type='checkbox' value="+candidatos.cedula+"> </td>") );
                            tr.append($("<td></td>", {text: candidatos.cedula}));

                            if(candidatos.nombres != "" && candidatos.nombres != null){
                                tr.append($("<td></td>", {text: candidatos.nombres}));
                            }else{
                                tr.append($("<td></td>", {text: response.emptyName}));
                            }

                            tr.append($("<td></td>", {text: candidatos.celular}));

                            if(response.hvView == 1){
                                tr.append($("<td>Si</td>"));
                            }else{
                                tr.append($("<td>No</td>"));
                            }

                            vu ="{{url("admin/editar-candidato-fuentes")}}"+"/"+candidatos.id;

                            //console.log(vu);
                            ///////////////////************************** botones editar y eliminar
                            var add = "<a data-url='"+vu+"' class='btn btn-xs btn-primary edit-fuente' title='Editar Candidato' href='#'><i class='fas fa-pen'></i></a>";

                            if(response.candidatos.email != ''){
                                add += "<button type='button' class='btn btn-xs btn-info construir_email'> <i class='fa fa-envelope'></i></button><input type='hidden' id='id_candidato' value="+response.candidatos.id+">";
                            }
                            if(response.candidatos.celular != '') {
                                if("{{$user_sesion->hasAccess('boton_ws')}}" == 'true' || "{{$user_sesion->hasAccess('boton_ws')}}" == '1') {
                                    add += "<a class='btn btn-xs btn-success' href='https://api.whatsapp.com/send?phone=57"+response.candidatos.celular+"&text=Hola!%20"+candidatos.nombres+"%20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},' target='_blank'> <i class='fa fa-whatsapp'></i> </a>";
                                }
                            }
                            add += "<a class='btn btn-xs btn-danger elim-fuente' data-url='{{url("admin/eliminar-candidato-fuente")}}/"+candidatos.id+"' title='Eliminar Candidato' href='#''><i class='fa fa-trash'></i></a>";
                            tr.append($("<td>" + add + "</td>"));

                            if(response.estado_req == true){
                                $('#botonAgregarCandidato').html('<button class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow" type="button" id="add_requerimiento_cand_fuente"><i class="fas fa-plus" aria-hidden="true"></i> Agregar candidatos seleccionados</button>');
                            }

                            if (response.success) {
                                $("#tbl_preguntas tbody").append(tr);

                                mensaje_success("Se ha agregado el candidato con éxito.");

                                $("#modalTriSmall").modal("hide");
                                $("#no_hay").hide();

                                setTimeout(function(){ $("#modal_success").modal("hide"); }, 2000);

                            } else {
                                mensaje_success("El candidato ya está en otras fuentes");
                            }
                        }     
                    }
                });
            }
        });

        $(document).on("click", "#add_requerimiento_cand_fuente", function(e) {
            e.preventDefault();
            var ids_req_cand = [];
            var cand = 0;
            var candidatos=$("input[name='aplicar_candidatos_fuentes[]']");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    ids_req_cand.push($(this).val());
                    cand++;
                }
            });

            if ($("input[name='aplicar_candidatos_fuentes[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos_fuentes:ids_req_cand,
                       requerimiento_id:$("#req_id_section_otras_fuentes").val(),
                       asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            } else {
                $.smkAlert({text: 'Debe seleccionar 1 o mas candidatos.', type:'danger'})
            }
        })

        $(document).on("click", "#add_requerimiento_preperfilados", function(e) {
            e.preventDefault();
            var ids_req_cand = [];
            var cand = 0;
            var candidatos=$("input[name='aplicar_candidatos_preperfilado[]']");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    ids_req_cand.push($(this).val());
                    cand++;
                }
            });

            if ($("input[name='aplicar_candidatos_preperfilado[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos_preperfilado:ids_req_cand,
                       requerimiento_id:$("#req_id_section_preperfilados").val(),
                       asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            } else {
                $.smkAlert({text: 'Debe seleccionar 1 o mas candidatos.', type:'danger'})
            }
        })

        $(document).on("click", "#add_requerimiento_postulados", function(e) {
            e.preventDefault();
            var ids_req_cand = [];
            var cand = 0;
            var candidatos=$("input[name='aplicar_candidatos[]']");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    ids_req_cand.push($(this).val());
                    cand++;
                }
            });

            if ($("input[name='aplicar_candidatos[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos:ids_req_cand,
                       requerimiento_id:$("#req_id_section_postulados").val(),
                       asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            } else {
                $.smkAlert({text: 'Debe seleccionar 1 o mas candidatos.', type:'danger'})
            }
        })

        $(document).on("click", "#add_requerimiento_reclutamiento_externo", function(e) {
            e.preventDefault();
            var ids_req_cand = [];
            var cand = 0;
            var candidatos=$("input[name='aplicar_candidatos[]']");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    ids_req_cand.push($(this).val());
                    cand++;
                }
            });

            if ($("input[name='aplicar_candidatos[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos:ids_req_cand,
                       requerimiento_id:$("#req_id_section_reclutamiento_externo").val(),
                       reclutamiento_externo: true,
                       asociar_directo: true
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            if (response.transferir_directo) {
                                location.reload();
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            } else {
                $.smkAlert({text: 'Debe seleccionar 1 o mas candidatos.', type:'danger'})
            }
        })

        //Asociar directo al requerimeinto
        $(document).on("click", "#asociar_directo", function(e) {
            e.preventDefault();
            if($('#fr_otra_fuente').smkValidate()){
                $.ajax({
                    type: "POST",
                    data: {
                       aplicar_candidatos_fuentes:[ $("#fr_otra_fuente #cedula").val()],
                       requerimiento_id:$("#fr_otra_fuente #requerimiento_id").val(),
                       cedula:$("#fr_otra_fuente #cedula").val(),
                       nombres:$("#fr_otra_fuente #nombres").val(),
                       primer_nombre:$("#fr_otra_fuente #primer_nombre").val(),
                       segundo_nombre:$("#fr_otra_fuente #segundo_nombre").val(),
                       celular:$('#fr_otra_fuente #celular').val(),
                       primer_apellido:$("#fr_otra_fuente #primer_apellido").val(),
                       segundo_apellido:$("#fr_otra_fuente #segundo_apellido").val(),
                       email:$("#fr_otra_fuente #email").val(),
                       tipo_fuente_id: $("#fr_otra_fuente #tipo_fuente_id").val(),
                       _token: $("#fr_otra_fuente input[name=_token]").val()
                    },
                    url: "{{route('admin.agregar_candidato_fuentes')}}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        } else{
                            if (response.mensaje != null) {
                                mensaje_danger(response.mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                return false;
                            }
                        }
                    }
                });
            }
        });

        $("#cant_registros").on("change", function() {
            $("#fr_candidatos").submit();
        });

        $(document).on("click",".btn_quitar", function() {
            
            var id = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id,
                url: "{{ route('admin.quitar_candidato_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click",".btn-enviar-examenes", function() {
            
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
         
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_examenes_view') }}",
                success: function(response) {
                    $("#modalTriSmall").find(".modal-content").html(response.view);
                    $("#modalTriSmall").modal("show");
                }
            });

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
            $(this).prop("disabled",true);
            $.ajax({
                type: "POST",
                data: $("#fr_enviar_estudio_seg").serialize(),
                url: "{{ route('admin.enviar_estudio_seguridad') }}",
                success: function(response) {
                    if(response.success) {
                        $("#modal_peq").modal("hide");
                        mensaje_success("El candidato se ha enviado a estudio seguridad.");

                        actualizar_trazabilidad_individual('ENV_EST_SEG',response.candidato_req, response.id_proceso);
                        obj.prop("disabled", true);

                        var candidato_req = $("#candidato_req_fr").val();
                        $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-estudio-seg").prop("disabled", true);

                        location.reload();
                    }else{
                        $(this).prop("disabled",false);
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });
        });

        $(".btn-enviar-examenes-masivos").on("click", function() {
            var ids_req_cand = "";
            var cand = 0;
            var candidatos=$(allPages).find(".check_candi");
            var req_id= $(this).data("req_id");
            
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    if(cand > 0){
                        ids_req_cand += "&"
                    }
                    ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                    cand++;
                }
            });
            //console.log(ids);

            if ($("input[name='req_candidato[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: ids_req_cand+"&req_id="+req_id,//$("input[name='req_candidato[]']").serialize(),
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
                        $("#modalTriSmall").modal("hide");
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
                            $("#modalTriSmall").find(".modal-content").html(response.view);
                            $("#modalTriSmall").modal("show");
                        }
                    }
                });
            }

        });

        $(".btn-enviar-evs-masivos").on("click", function() {
            var ids_req_cand = "";
            var cand = 0;
            var candidatos=$(allPages).find(".check_candi");
            candidatos.each(function(index ) {
                if($(this).prop('checked')){
                    if(cand > 0){
                        ids_req_cand += "&"
                    }
                    ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                    cand++;
                }
            });

            if ($("input[name='req_candidato[]']").serialize() != "") {
                $.ajax({
                    type: "POST",
                    data: ids_req_cand,
                    url: "{{ route('admin.enviar_evs_masivo') }}",
                    success: function(response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            } else {
                mensaje_danger("Debe seleccionar 1 o mas candidatos");
            }

        });

        $(document).on("click", "#confirmar_evs_masivo", function() {
            if($('#fr_evs_masi').smkValidate()){
                $.ajax({
                    type: "POST",
                    data: $("#fr_evs_masi").serialize(),
                    url: "{{ route('admin.confirmar_evs_masivo') }}",
                    beforeSend: function(){
                        $("#modalTriSmall").modal("hide");
                        $.smkAlert({text: 'Guardando...', type:'info'})
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
                            var totalTime = 3;
                            var mensaje = 'Se han enviado a los candidatos satisfactoriamente.';
                            if (response.candidatos_no_enviados.length > 0) {
                                totalTime = 10;
                                mensaje += "<br>Pero " + response.candidatos_no_enviados.length + " candidatos ya se encuentran en proceso de estudio virtual de seguridad y no se han enviado:<br>";
                                response.candidatos_no_enviados.forEach(function(cand, index) {
                                    mensaje += '<b>' + cand + '</b>';
                                    if (response.candidatos_no_enviados.length - 1 > index) {
                                        mensaje += ' - ';
                                    }
                                });
                            }
                            mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                            mensaje_success(mensaje);
                            updateClock("tiempo_recarga", totalTime);
                            setTimeout(function(){
                                location.reload();
                            }, totalTime*1000);
                        }else{
                            $("#modalTriSmall").find(".modal-content").html(response.view);
                            $("#modalTriSmall").modal("show");
                        }
                    }
                });
            }

        });

        $(document).on("click",".btn_consentimiento_permisos_adic", function() {
            var id = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id,
                url: "{{ route('admin.enviar_consentimiento_permisos_adicionales')}}",
                success: function(response) {
                    $("#modalTriSmall").find(".modal-content").html(response);
                    $("#modalTriSmall").modal("show");
                }
            });
        });

        $(document).on("click", "#confirmar_envio_consentimiento_permisos_adic", function(e) {
            e.preventDefault();

            $(this).prop("disabled",true);

            $.ajax({
                type: "POST",
                data: $("#fr_consentimientos_permisos").serialize(),
                url: "{{ route('admin.confirmar_envio_consentimiento_permisos_adicionales') }}",
                success: function(response) {
                    if(response.success) {
                        mensaje_success("Candidato enviado al proceso correctamente");
                        setTimeout(function(){ location.reload(); }, 2000);
                    }
                }
            });
        });

        $(document).on("click", "#guardar_examen", function(e) {
            e.preventDefault()

            if($('#fr_enviar_examen').smkValidate()) {
                var obj = $(this)
                $(this).prop("disabled", true)

                $.ajax({
                    type: "POST",
                    data: $("#fr_enviar_examen").serialize(),
                    url: "{{ route('admin.enviar_examenes') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modalTriSmall").modal("hide")
                            mensaje_success("El candidato se ha enviado a examenes médicos.")
                            obj.prop("disabled", true)
                            var candidato_req = $("#candidato_req_fr").val()

                            $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-examenes").prop("disabled", true)

                            window.location.reload(true)
                        } else {
                            if (response.omnisalud) {
                                $.smkAlert({
                                    text: `No se puede enviar a la(el) candidata(o). Verifica que tenga sus datos básicos completos. <br> 
                                            <b>(celular, fecha nacimiento, dirección, tipo identificación, género etc.)</b>`,
                                    type: 'danger',
                                    permanent: true
                                })

                                obj.prop("disabled", false)
                            }else {
                                $("#modalTriSmall").find(".modal-content").html(response.view);
                            }
                        }
                    }
                })
            }
        });

        // Quitar candidato
        $(document).on("click", "#quitar_candidato_fr", function() {
            
            var objPadre = $(this).parents("tr");
            
            $.ajax({
                type: "POST",
                data: $("#fr_quitar_candidato").serialize(),
                url: "{{ route('admin.quitar_candidato')}}",
                success: function() {
                    alert("Candidato retirado.");
                 window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';
                }
            })

        });
        // ----

        //Pruebas
        $(document).on("click",".btn_pruebas", function() {
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_pruebas_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(document).on("click", "#confirmar_pruebas", function() {
            if ($('#externa_pruebas').is(':checked') || $('#brig_pruebas').is(':checked') || $('#excel_basico_pruebas').is(':checked') || $('#excel_intermedio_pruebas').is(':checked') || $('#prueba_valores_1').is(':checked') || $('#competencias_pruebas').is(':checked') || $('#digitacion_pruebas').is(':checked')) {
                $(this).prop("disabled", true);

                var btn_id = $(this).prop("id");
                
                setTimeout(function(){
                   $("#"+btn_id).prop("disabled",false);
                }, 5000);

                $.ajax({
                    type: "POST",
                    data: $("#fr_pruebas").serialize(),
                    url: "{{ route('admin.confirmar_prueba') }}",
                    success: function(response) {
                        //Si el cargo o req no tiene configuración
                        if (response.configuracion) {
                            $.smkAlert({text: 'No hay configuraciones definidas para esta prueba BRYG, debes crear una configuración para enviar candidatos.', type:'danger'})

                            $("#modal_peq").modal("hide");
                        }

                        //Si el candidato ya tiene una prueba respondida
                        if(response.reusar){
                            $("#modal_peq").modal("toggle");

                            $.smkConfirm({
                                text:'El/la candidato(a) ya ha respondido la prueba BRYG-A anteriormente, ¿Deseas reusar esta prueba?',
                                accept:'Si, reusar',
                                cancel:'No, crear nueva'
                            }, function(res) {
                                console.log(res)

                                let reusar = 'no'
                                if (res) { reusar = 'si' }

                                let data = $("#fr_pruebas").serialize() + '&' + $.param({reusar: reusar})

                                console.log(data)

                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "{{ route('admin.bryg.reusar_prueba') }}",
                                    beforeSend: function() {
                                        if (res) {
                                            $.smkAlert({text: 'Reusando prueba BRYG-A ...', type:'info'})
                                        }else {
                                            $.smkAlert({text: 'Enviando candidato(a) a prueba BRYG-A ...', type:'info'})
                                        }
                                    },
                                    success: function(response) {
                                        if (res) {
                                            $.smkAlert({text: 'Información de prueba  BRYG-A reusada. <b>Puedes ingresar a la gestión de la prueba.</b>', type:'success'})
                                        }else {
                                            $.smkAlert({text: 'Nueva prueba BRYG-A creada correctamente.', type:'success'})
                                        }

                                        setTimeout(() => {
                                            window.location.reload(true)
                                        }, 2500)
                                    }
                                })
                            })
                        }

                        if(response.success) {
                            var candidato_req = $("#candidato_req_fr").val();
                            var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");

                            td.eq(4).html(response.text_estado);

                            $("#modal_peq").modal("hide");
                            $("#grupo_btn_" + candidato_req + "").find(".btn_pruebas").prop("disabled", true);

                            mensaje_success("El candidato se ha enviado a pruebas.");

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                        }
                    }
                });
            }else {
                $.smkAlert({
                    text: 'Debes seleccionar una prueba a enviar.',
                    type: 'danger'
                })
            }
        });
        
        //Pruebas
        $(document).on("click",".btn_retroalimentacion", function() {
            var cand_req = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + cand_req,
                url: "{{ route('admin.enviar_retroalimentacion_video_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(document).on("click", "#confirmar_retroalimentacion_video", function() {
            $(this).prop("disabled", true);
            var ruta_retroalimentacion = "{{ url('admin/gestionar_retroalimentacion_video')  }}";
            console.log(ruta_retroalimentacion);

            $.ajax({
                type: "POST",
                data: $("#fr_retroalimentacion").serialize(),
                url: "{{ route('admin.confirmar_retroalimentacion_video') }}",
                success: function(response) {
                    if(response.success) {
                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        console.info(candidato_req);

                        td.eq(4).html(response.text_estado);

                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_retroalimentacion").prop("disabled", true);

                        mensaje_success("El candidato se ha enviado a retroalimentación.");

                        setTimeout(() => {
                            window.open(ruta_retroalimentacion + '/' + candidato_req, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=900,height=600")
                            window.location.reload(true)
                        }, 1500)
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        });

        @if($sitioModulo->estudio_virtual_seguridad == 'enabled')
            $(document).on("click",".btn_enviar_evs", function() {
                //para mostrar el modal de la evaluacion sst
                var id = $(this).data("candidato_req");

                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id,
                    url: "{{ route('admin.enviar_estudio_virtual_seguridad_view')}}",
                    success: function(response) {
                      $("#modalTriSmall").find(".modal-content").html(response);
                      $("#modalTriSmall").modal("show");
                    }
                });
            });

            $(document).on("click", "#confirmar_envio_estudio_virtual_seguridad", function(e) {
                e.preventDefault();

                if ($('#fr_enviar_evs').smkValidate()) {
                    $(this).prop("disabled",true);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_evs").serialize(),
                        url: "{{ route('admin.confirma_estudio_virtual_seguridad') }}",
                        beforeSend: function() {
                            mensaje_success("Espere mientras se carga la información");
                        },
                        success: function(response) {
                            if(response.success) {
                                mensaje_success("Candidato enviado a estudio virtual de seguridad");
                                setTimeout(function(){ location.reload(); }, 2000);
                            }
                        }
                    });
                }
            });
        @endif

        @if($sitioModulo->evaluacion_sst == 'enabled')
            $(document).on("click",".btn_enviar_sst", function() {
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

                $.ajax({
                    type: "POST",
                    data: $("#fr_evaluacion").serialize(),
                    url: "{{ route('confirmar_envio_evaluacion_sst') }}",
                    success: function(response) {
                        if(response.success) {
                            location.reload();

                            var candidato_req = $("#candidato_req_fr").val();
                            var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");

                            td.eq(4).html(response.text_estado);
                            $("#modal_peq").modal("hide");
                            $("#grupo_btn_" + candidato_req + "").find(".btn_pruebas").prop("disabled", true);
                            mensaje_success("El candidato se ha enviado a evaluación sst.");
                            setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                        }else{
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                        }
                    }
                });
            });

            //Aqui quede agregando el envio de la sst, de forma masiva

            $(".btn_evaluacion_sst_masivo").on("click", function() {
                var ids_req_cand = "";
                var cand = 0;
                var candidatos=$(allPages).find(".check_candi");
                candidatos.each(function(index ) {
                    //console.log(index + ' ' + $(this).val() + ' ' + $(this).prop('checked'));
                    if($(this).prop('checked')){
                        if(cand > 0){
                            ids_req_cand += "&"
                        }
                        ids_req_cand += "req_candidato%5B%5D="+$(this).val();
                        cand++;
                    }
                });

                if (ids_req_cand != "") {
                    $.ajax({
                        type: "POST",
                        data: ids_req_cand,
                        url: "{{ route('admin.enviar_evaluacion_sst_masivo_view') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response.view);
                            //$("#modal_gr").modal("hide");
                            $("#modal_peq").modal("show");
                        }
                    });
                } else {
                    mensaje_success("Debe seleccionar al menos un candidat@");
                }
            });

            $(document).on("click", "#confirmar_evaluacion_sst_masivo", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_evaluacion_sst_masivo").serialize(),
                    url: "{{ route('admin.confirmar_evaluacion_sst_masivo') }}",
                    beforeSend: function(){
                        $("#modal_peq").modal("hide");
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
                            var totalTime = 3;
                            var mensaje = 'Se han enviado los candidatos satisfactoriamente.';
                            if (response.candidatos_no_enviados.length > 0) {
                                totalTime = 7;
                                mensaje += "<br><br>Pero " + response.candidatos_no_enviados.length + " candidatos ya tienen activo el proceso y no se han enviado:<br>";
                                response.candidatos_no_enviados.forEach(function(cand, index) {
                                    mensaje += '<b>' + cand + '</b>';
                                    if (response.candidatos_no_enviados.length - 1 > index) {
                                        mensaje += ' - ';
                                    }
                                });
                            }
                            mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                            mensaje_success(mensaje);
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
            });
        @endif

        @if($sitioModulo->visita_domiciliaria == 'enabled')
            $(document).on("click",".btn_enviar_visita_domiciliaria", function() {
                //para mostrar el modal de la evaluacion sst
                var id = $(this).data("candidato_req");

                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id,
                    url: "{{ route('admin.enviar_visita_domiciliaria_view')}}",
                    success: function(response) {
                      $("#modal_peq").find(".modal-content").html(response);
                      $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#confirmar_envio_visita_docimiciliaria", function(e) {
                e.preventDefault();

                $(this).prop("disabled",true);
                
                var btn_id = $(this).prop("id");
                
                setTimeout(function(){
                   $("#"+btn_id).prop("disabled",false);
                }, 5000);

                $.ajax({
                    type: "POST",
                    data: $("#fr_visita").serialize(),
                    url: "{{ route('admin.confirma_visita_domiciliaria') }}",
                    success: function(response) {
                        if(response.success) {
                            
                            mensaje_success("Candidato enviado a visita domiciliaria");
                            setTimeout(function(){ location.reload(); }, 2000);
                        }
                    }
                });
            });
        @endif

        // Referencia masivo
        @if(route("home") == "https://komatsu.t3rsc.co")
            
            $(".btn_referenciacion_masivo").on("click", function() {
               
                if($("input[name='req_candidato[]']").serialize() == ''){

                  mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{

                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_referenciacion_view_masivo') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                        }
                    });

                }

            });

        @else

            $(".btn_referenciacion_masivo").on("click", function() {
               
                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{
                    var candidatos=$(allPages).find(".check_candi").serialize();

                    $.ajax({
                        type: "POST",
                        data:  candidatos,
                        url: "{{ route('admin.confirmar_referenciacion_masivo') }}",
                        success: function(response) {
                            if (response.success) {
                                mensaje_success("Se han enviado a los candidat@s a refernciar satisfactoriamente.");
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }
                    });

                }

            });

        @endif

        $(".btn_referencia_estudios_masivo").on("click", function() {
               
               if($("input[name='req_candidato[]']").serialize() == ''){

                   mensaje_success("Debes seleccionar al menos un candidat@.");

               }else{
                   var candidatos=$(allPages).find(".check_candi").serialize();

                   $.ajax({
                       type: "POST",
                       data:  candidatos,
                       url: "{{ route('admin.confirmar_referencia_estudios_masivo') }}",
                       success: function(response) {
                           if (response.success) {
                               mensaje_success("Se han enviado a los candidat@s a referencia de estudios satisfactoriamente.");
                               location.reload();
                           } else {
                               $("#modal_peq").find(".modal-content").html(response.view);
                               $("#modal_peq").modal("show");
                           }
                       }
                   });

               }

        });

        $(".btn_asistencia_masivo").on("click", function() {
            
            var req_id = $(this).data("req_id");
            
            $.ajax({
                type: "POST",
                data: $("input[name='req_candidato[]']").serialize() + "&req_id="+req_id,
                url: "{{ route('admin.enviar_asistencia_view_masivo') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });   

        // Entrevista masivo
        @if(route("home") == "https://komatsu.t3rsc.co")

            $(".btn_entrevista_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{
                    
                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_entrevista_view_masivo') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                        }
                    });

                }

            });

        @else

            $(".btn_entrevista_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{
                    var candidatos=$(allPages).find(".check_candi").serialize();
                    $.ajax({
                        type: "POST",
                        data: candidatos,
                        url: "{{ route('admin.confirmar_entrevista_masivo') }}",
                        success: function(response) {
                            if (response.success) {
                                mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }
                    });

                }
            });

        @endif

        // Pruebas masivo
        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
            
            $(".btn_pruebas_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{

                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_pruebas_view_masivo') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                        }
                    });

                }
            
            });

        @else

            $(".btn_pruebas_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{

                    $.ajax({
                        type: "POST",
                        data: $("#fr_candidatos").serialize(),
                        url: "{{ route('admin.enviar_pruebas_view_masivo') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                        }

                        /*
                        url: "{{ route('admin.confirmar_pruebas_masivo') }}",
                        success: function(response) {
                            if (response.success) {
                                mensaje_success("Se ha enviado a los candidat@s satisfactoriamente.");
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }*/
                    });
                    
                }
            
            });

        @endif

        $(document).on("click",".btn_referenciacion", function() {

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_referenciacion_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        
        });

        $(document).on("click", "#confirmar_referenciacion", function() {
            
            $(this).prop("disabled",true);

            var btn_id = $(this).prop("id");
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{ route('admin.confirmar_referenciacion') }}",
                success: function(response) {
                    if(response.success) {
                        @if(route('home')== "https://demo.t3rsc.co")
                            var ruta = "{{url('admin/gestionar_referencia')}}"+"/"+response.id_proceso;
                            console.log(ruta);
                            ir_gestionar(ruta);
                        @endif

                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);

                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_referenciacion").prop("disabled", true);
                        
                        mensaje_success("Candidato enviado a referenciación.");
                        //actualizar_trazabilidad_individual('ENV_REF',response.candidato_req, response.id_proceso);
                        //setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });

        });

        $(document).on("click",".btn_referencia_estudios", function() {

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_referencia_estudios_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click", "#confirmar_referencia_estudios", function() {
            
            $(this).prop("disabled",true);

            var btn_id = $(this).prop("id");
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{ route('admin.confirmar_referencia_estudios') }}",
                success: function(response) {
                    if(response.success) {
                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);
                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_referencia_estudios").prop("disabled", true);
                         mensaje_success("Candidato enviado a referenciación de estudios.");
                         //actualizar_trazabilidad_individual('ENV_REF_ESTUDIOS',response.candidato_req, response.id_proceso);
                        //setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });

        });

        $(document).on("click",".btn_entrevista", function() {
            
            if($(this).data("route") != "http://komatsu.t3rsc.co" && $(this).data("route") != "https://komatsu.t3rsc.co") {
                // alert('no fiunciono');
                $(this).prop("disabled", true);
            }

            var btn_id = $(this).prop("id");

            setTimeout(function(){
               $("#"+btn_id).prop("disabled", false);
            }, 5000);

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_entrevista_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        
        });

        $(document).on("click",".btn-crear_entrevista_virtual", function() {
            $(this).prop("disabled",true);
           //  alert(btn_id);
            var btn_id = $(this).prop("id");
            setTimeout(function(){
               
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            var id = $(this).data("candidato_req");
            var req_id = $(this).data("req_id");
            var cliente = $(this).data("cliente");
            $.ajax({
                type: "POST",
                data: "req_id=" + req_id + "&cliente_id=" + cliente,
                url: "{{ route('admin.nueva_entrevista_virtual') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        
        });

        $(document).on("click", "#guardar_entrevista_virtual", function() {
            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");
            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            $.ajax({
                type: "POST",
                data: $("#fr_entre_virtual").serialize() + "&enviar=1",
                url: "{{ route('admin.guardar_entrevista_virtual')}}",
                success: function(response) {
                  $("#modal_peq").find(".modal-content").html(response.view);
                  $("#modal_peq").modal("show");
                  $("#modal_peq").modal("hide");
                  mensaje_success("Se ha creado la entrevista virtual con éxito.");
                        location.reload();
                }
            });
        
        });

        //Prueba idioma
        $(document).on("click",".btn-crear_prueba_idioma", function() {
            
            $(this).prop("disabled",true);

            var btn_id = $(this).prop("id");
            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            var id = $(this).data("candidato_req");
            var req_id = $(this).data("req_id");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "req_id=" + req_id + "&cliente_id=" + cliente,
                url: "{{ route('admin.nueva_prueba_idioma') }}",
                success: function(response) {

                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");

                }
            });

        });

        $(document).on("click", "#guardar_prueba_idioma", function() {

            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");

            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_prueba_idioma").serialize() + "&enviar=1",
                url: "{{ route('admin.guardar_prueba_idioma') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                    $("#modal_peq").modal("hide");
                    mensaje_success("Se ha creado la prueba de idioma con éxito.");
                    location.reload();
                }
            });
        
        });
        //----

        $(document).on("click",".btn_asistencia",function() {
            /*$(this).prop("disabled",true);*/
            var btn_id = $(this).prop("id");
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            var id = $(this).data("candidato_req");
            var candidato_id = $(this).data("candidato_id");
            var req_id = $(this).data("req_id");
            $.ajax({
                type: "POST",
                data:"req_id="+req_id + "&candidato_req=" + id + "&candidato_id=" + candidato_id,
                url: "{{ route('admin.enviar_entrevista_asistencia') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        //Validación Documental
        @if(route("home") == "https://komatsu.t3rsc.co")

            $(".btn_documento_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{

                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_documento_view_masivo') }}",
                        success: function(response) {
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                        }
                    });

                }
            });

        @else

            $(".btn_documento_masivo").on("click", function() {

                if($("input[name='req_candidato[]']").serialize() == ''){

                    mensaje_success("Debes seleccionar al menos un candidat@.");

                }else{

                    $.ajax({
                        type: "POST",
                        data: $("#fr_candidatos").serialize(),
                        url: "{{ route('admin.confirmar_documento_masivo') }}",
                        success: function(response) {
                            if (response.success) {
                                mensaje_success("Se han enviado a los candidat@s a estudio de seguridad satisfactoriamente.");
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }
                    });

                }

            });

        @endif
        //----- /

        $(".btn_aprobar_cliente_masivo").on("click", function() {
            const req_id = $(this).data("req_id");
            const req_candidato = $("input[name='req_candidato[]']").serialize();
            var candidatos=$(allPages).find(".check_candi").serialize();

            $.ajax({
                type: "POST",
                data: candidatos,
                url: "{{ route('admin.enviar_aprobar_cliente_view_masivo') }}",
                success: function(response) {
                    if (response.empty) {
                        $.smkAlert({
                            text: 'Debes seleccionar al menos un/a candidato/a.',
                            type: 'info',
                        })
                    } else {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        });

        $(".btn_aprobar_candidatos_masivo").on("click", function() {
            const req_id = $(this).data("req_id");
            const req_candidato = $("input[name='req_candidato[]']").serialize();
            var candidatos=$(allPages).find(".check_candi").serialize();

            $.ajax({
                type: "POST",
                data: {
                    req_id: req_id,
                },
                url: "{{ route('admin.aprobar_candidatos_admin_view_masivo') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });
         
        $(document).on("click", "#confirmar_aprobar_candidatos_masivo", function() {
            if ($('#fr_aprobar_candidatos_masivo').smkValidate()) {
                let formData = new FormData(document.getElementById("fr_aprobar_candidatos_masivo"));

                $(this).attr('disabled', true);

                $.smkAlert({text: 'Cargando archivo de candidatos...', type:'info'})

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('admin.confirmar_aprobar_candidato_masivo') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#modal_peq").modal("hide");
                        if (response.success) {
                            var totalTime = 5;
                            var mensaje = 'No se ha actualizado ningún registro';
                            if (response.registros_modificados > 0) {
                                mensaje = response.mensaje_success;
                            }
                            if (response.index_errores.length > 0) {
                                totalTime = 15;
                                mensaje += "<br>Errores al procesar el archivo:<br><table id='table_error_aprobacion' class='table table-striped'><thead><th>Número de linea</th><th>Error</th></thead><tbody>";
                                response.index_errores.forEach(function(posicion, index) {
                                    mensaje += '<tr><td>' + posicion + '</td><td>' + response.errores_global[posicion].errores[0] + '</td></tr>';
                                });
                                mensaje += "</tbody></table>";
                            }
                            mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                            mensaje_success(mensaje);
                            if (response.index_errores.length > 0) {
                                $('#table_error_aprobacion').DataTable({
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
                            mensaje_danger("Ha ocurrido un error, intente nuevamente si el problema persiste contacte con soporte.");
                        }
                    }
                });
            }
        })

        $(".btn_video_entrevista_masivo").on("click", function() {
           
            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            var candidatos=$(allPages).find(".check_candi").serialize();
            var parametros = {
                "cliente_id" : cliente_id,
                "req_id" : req_id
            };
            console.log(req_id);
            $.ajax({
                type: "POST",
                 data: candidatos+ "&cliente_id="+cliente_id+ "&req_id="+req_id,
                url: "{{ route('admin.enviar_entrevista_virtual_view_masivo') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        //---
        $(".btn_prueba_idioma_masivo").on("click", function() {
           
            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            var candidatos=$(allPages).find(".check_candi").serialize();
            var parametros = {
                "cliente_id" : cliente_id,
                "req_id" : req_id
            };
            console.log(req_id);
            $.ajax({
                type: "POST",
                 data: candidatos+ "&cliente_id="+cliente_id+ "&req_id="+req_id,
                url: "{{ route('admin.enviar_prueba_idioma_view_masivo') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });
        //---

        $('#table_with_users').delegate( '.btn_documento', 'click', function(){
            
            $(this).prop("disabled", true);

            var btn_id = $(this).prop("id");
            
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_documento_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });

        /*$(".btn_documento").on("click", function() {

            $(this).prop("disabled", true);

            var btn_id = $(this).prop("id");
            
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
               
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });*/

        $("#ver_ranking").on("click", function () {
            var req_id = $(this).data("req");
            $.ajax({
                data: {req_id: req_id},
                url: "{{route('admin.ver_ranking')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $("#ver_respuestas").on("click", function () {
            var req_id = $(this).data("req");
            $.ajax({
                data: {req_id: req_id},
                url: "{{route('admin.ver_respuestas')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $(document).on("click", "#realizar_entrevista", function() {
            $(this).prop("disabled", true);
            var btn_id = $(this).prop("id");

            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_pruebas").serialize() + "&enviar=1",
                url: "{{ route('admin.confirmar_entrevista') }}",
                success: function(response) {
                    @if(route('home')== "https://demo.t3rsc.co")
                        var ruta = "{{url('admin/gestionar_entrevista/')}}"+"/"+response.id_proceso;
                        console.log(ruta);
                        ir_gestionar(ruta);
                    @endif

                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                    $("#modal_peq").modal("hide");

                    mensaje_success("El candidato se ha enviado a entrevista.");
                    //actualizar_trazabilidad_individual('ENV_ENTRE',response.candidato_req, response.id_proceso);
                    
                    //setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                    setTimeout(() => {
                        location.reload()
                    }, 1500)
                }
            });
        });

        $(document).on("click", "#realizar_asistencia", function() {
            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");
            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            $.ajax({
                type: "POST",
                data: $("#fr_asistencia").serialize(),
                url: "{{ route('admin.confirmar_asistencia') }}",
                success: function(response) {

                    if(response.success){
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                         mensaje_success("Se ha enviado la respuesta de la asistencia.");
                         location.reload();
                     }else{

                         //alert('lol')
                     $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                     mensaje_success("No se le ha hecho la entrevista al candidato.");
                     }
                },
                error:function(response){
                }
            });
        });
        
        $(document).on("click", "#confirmar_entrevista", function() {
          
            @if(route("home")!= "http://komatsu.t3rsc.co" && route("home")!= "https://komatsu.t3rsc.co")
                $(this).prop("disabled",true);
            @endif

            var btn_id = $(this).prop("id");
            setTimeout(function(){
                //alert(btn_id);
               $("#"+btn_id).prop("disabled",false);
            }, 5000);
            $.ajax({
                type: "POST",
                data: $("#fr_pruebas").serialize(),
                url: "{{ route('admin.confirmar_entrevista') }}",
                success: function(response) {

                  if(response.success){

                    @if(route('home')== "https://demo.t3rsc.co")

                      var ruta = "{{url('admin/gestionar_entrevista/')}}"+"/"+response.id_proceso;
                      console.log(ruta);
                      ir_gestionar(ruta);
                     
                    @endif

                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");

                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);

                        @if(route("home")!= "http://komatsu.t3rsc.co" && route("home")!= "https://komatsu.t3rsc.co")
                            alert();
                            $("#grupo_btn_" + candidato_req + "").find(".btn_entrevista").prop("disabled", true);
                        @endif
                        $("#modal_peq").modal("hide");
                        mensaje_success("El candidato se ha enviado a entrevista.");
                        location.reload();

                   }else{
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        });

        //Confirma validación documental
        $(document).on("click", "#confirmar_documentos_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_docu_masi").serialize(),
                url: "{{ route('admin.confirmar_documento_masivo') }}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han enviados a los candidatos a estudio de seguridad satisfactoriamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })
        //------- /

        $(document).on("click", "#confirmar_aprobar_cliente_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_apro_masi").serialize(),
                url: "{{ route('admin.confirmar_aprobar_cliente_masivo') }}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han enviado a los candidatos correctamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })

        $(document).on("click", "#confirmar_asistencia_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_asis_masi").serialize(),
                url: "{{ route('admin.confirmar_asistencia_masivo') }}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                        location.reload();
                    } else  {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                    if (response.error) {
                         $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                    }
                 
            });
        })

        $(document).on("click", "#confirmar_entrevista_virtual_masivo", function() {
            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            console.log(req_id);
            $.ajax({
                type: "POST",
                data: $("#fr_entre_vir_masi").serialize(),
                url: "{{ route('admin.confirmar_entrevista_virtual_masivo') }}",
                beforeSend: function(){
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
                    if (response.success) {
                        mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })

        //--
        $(document).on("click", "#confirmar_prueba_idioma_masivo", function() {
            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            console.log(req_id);
            $.ajax({
                type: "POST",
                data: $("#fr_prueba_idio_masi").serialize(),
                url: "{{ route('admin.confirmar_prueba_idioma_masivo') }}",
                beforeSend: function(){
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
                    if (response.success) {
                        mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })
        //--

        // Confirmar entrevisa masivo
        $(document).on("click", "#confirmar_entrevista_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_entre_masi").serialize(),
                url: "{{ route('admin.confirmar_entrevista_masivo') }}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })

        // Confirma referenciación masiva
        $(document).on("click", "#confirmar_referenciacion_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_refe_masi").serialize(),
                url: "{{ route('admin.confirmar_referenciacion_masivo') }}",
                success: function(response) {
                    if (response.success) {
                        mensaje_success("Se han mandado a los candidatos satisfactoriamente.");
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });
        })
        // ---- /

        // Confirmar pruebas masivas
        $(document).on("click", "#confirmar_pruebas_masivo", function() {
            
            $.ajax({
                type: "POST",
                data: $("#fr_prueba_masi").serialize(),
                url: "{{ route('admin.confirmar_pruebas_masivo') }}",
                beforeSend: function(){
                    $("#modal_peq").modal("hide");
                    $.smkAlert({
                        text: 'Enviando las pruebas a los candidatos seleccionados.',
                        type: 'info',
                    })
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
                        var totalTime = 3;
                        var mensaje = 'Se han enviado a pruebas a los candidatos satisfactoriamente.';
                        if (response.candi_no_enviados.length > 0) {
                            totalTime = 10;
                            mensaje += "<br><br>Excepto " + response.candi_no_enviados.length + " candidatos debido a que ya tienen proceso activo en las siguientes pruebas:<br>";
                            response.candi_no_enviados.forEach(function(cand, index) {
                                mensaje += '<b>' + cand.nombre_completo + '</b> prueba(s) no enviada(s) ' + cand.observaciones + '<br>';
                            });
                        }
                        mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                        mensaje_success(mensaje);
                        updateClock("tiempo_recarga", totalTime);
                        setTimeout(function(){
                            location.reload();
                        }, totalTime*1000);
                    } else {
                        $.unblockUI();
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });

        })
        // ------ /

        $(document).on("click", "#confirmar_documentos", function() {
            
            $(this).prop("disabled",true);
            
            var btn_id = $(this).prop("id");

            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_pruebas").serialize(),
                url: "{{ route('admin.confirmar_documento') }}",
                success: function(response) {
                console.log(response);
                   if(response.success){

                    @if(route('home')== "https://demo.t3rsc.co")

                     var ruta = "{{url('admin/gestionar_documentos')}}"+"/"+response.id_proceso;
                      console.log(ruta);
                      ir_gestionar(ruta);
                     
                    @endif

                      var candidato_req = $("#candidato_req_fr").val();
                      var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);
                        $("#grupo_btn_" + candidato_req + "").find(".btn_documento").prop("disabled", true);
                        $("#modal_peq").modal("hide");
                        console.log(response.id_proceso);
                       mensaje_success("El candidato se ha enviado a validación documental.");
                        //actualizar_trazabilidad_individual('ENV_DOCU',response.candidato_req, response.id_proceso);
                        //setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
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
            
            setTimeout(function(){
               $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_pruebas").serialize(),
                url: "{{ route('admin.confirmar_aprobar_cliente') }}",
                success: function(response) {
                    if(response.success){
                        {{-- @if(route('home')== "https://demo.t3rsc.co")--}}
                        // "+"/"+response.id_proceso;
                        // console.log(ruta);
                        //  ir_gestionar(ruta);
                        {{-- @endif --}}

                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                        td.eq(4).html(response.text_estado);

                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_aprobar_cliente").prop("disabled", true);
                        
                        if(window.location.host == "komatsu.t3rsc.co"){
                            mensaje_success("Se ha enviado a aprobar candidato.");
                        }else{
                            mensaje_success("El candidato se ha enviado para la aprobación por parte del cliente.");
                        }
                        
                        location.reload();
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });

        });
        
        /*$(document).on("click",".btn_contratar", function() {
            var req_id = $(this).data("req_id");
            var user_id = $(this).data("user_id");
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data:"req_id="+ req_id+ "&user_id="+ user_id+ "&candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_contratar') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                    $("#modal_peq").attr("data-spy","scroll");
                }
            });

        });*/

        $('#table_with_users').delegate(".btn_contratar2", "click", function() {
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

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

        $(document).on("click", "#observaciones", function() {
            
            $.ajax({
              type: "POST",
              data: {
                    req_id:$(this).data("req")
              },
              url: "{{ route('admin.observaciones') }}",  
              success: function(response) {
                $('#modal_gr').modal({ backdrop: 'static', keyboard: false });
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
              }
            });

        });

        $(document).on("click", "#guardar_observaciones_gestion", function() {
            
            $.ajax({
              type: "POST",
              data: $("#fr_observaciones_gestion").serialize(),
              url: "{{ route('admin.guardar_observaciones_gestion') }}", 
              success: function(response) {
                
                $("#modal_gr").modal("hide");
                mensaje_success("Observación realizada");
                setTimeout(function(){$("#modal_success").modal("hide"); }, 1000);
              }
            });

        });

        $(document).on("change","#tipo_ingreso", function(){
           var tipo = $(this).val();
            switch(tipo) {
                case "1":
                    // code block
                    $("#fecha_fin_ultimo").hide();
                break;
                case "2":
                    // code block
                    $("#fecha_fin_ultimo").show();
                break;
                default:
                $("#fecha_fin_ultimo").hide();
            }

            $("#fecha_fin_ultimo").submit();
        });

        //Enviar a contratar candidato MODAL
        $(document).on("click", "#confirmar_contratacion", function() {
            var m = confirmar_cuenta(); // si coinciden las cuentas
            //console.log(m); //si los numero de cuenta no coinciden no enviar el form
            if(m === 1){
                return false;
            }else{
                /*valid = confirmar_campos();

                if(valid === 1){
                    return false;
                }*/

                if($('#fr_contratar').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_contratar").serialize(),
                        url: "{{ route('admin.enviar_a_contratar') }}",
                        beforeSend: function(){
                            mensaje_success("Espere mientras se carga la información");
                        },
                        error: function(){
                            $("#modal_peq .close").click();
                            $("#modal_success .close").click();
                            mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                        },
                        success: function(response){
                            if(response.success) {

                                var totalTime = 5;
                                var mensaje = '';
                                if (response.no_contratados_masivo.length == 0) {
                                    var candidato_req = $("#candidato_req_fr").val();

                                    mensaje = "El candidato se ha enviado a {{ (route('home') == 'https://gpc.t3rsc.co') ? 'aprobar' : 'contratar' }}.";

                                    //actualizar_trazabilidad('ENV_CON');

                                    $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-examenes").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_pruebas").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_referenciacion").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_entrevista").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_aprobar_cliente").prop("disabled", true);
                                    //$("#grupo_btn_" + candidato_req + "").find(".btn_contratar").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_contratar2").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_rechazar").prop("disabled", true);
                                    $("#grupo_btn_" + candidato_req + "").find(".btn_quitar").prop("disabled", true);
                                    
                                    var td = $("#grupo_btn_" + candidato_req + "").parent().parent().find("td");
                                    td.eq(4).html(response.text_estado);
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
                                    location.reload()
                                }, totalTime * 1000);
                            } else {
                                //$("#modal_peq").modal("hide");
                                //$("#modal_peq .close").click();

                                $("#modal_success .close").click();
                                $("#modal_success").modal("hide");

                                //$("#modal_peq").find(".modal-content").html(response.view);
                                //mensaje_danger('Verifica los datos');

                                $("#modal_peq").find(".modal-content").html(response.view);

                                //$("#modal_peq").modal("show");

                                $("#modal_peq").css("overflow-y","scroll");
                            }
                        }
                    });
                }
            }
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
        
        //validar campos antes de enviar a contratar
        function confirmar_campos(){
            var i = 0;
            message = "";

            //var c_una =  $("#fecha_inicio_contrato").val();

            var c_dos =  $("#observacion").val();
            var c_tres = $("#user_autorizacion").val();

            if(c_dos == ""){
                message += " Debes Colocar observación \n";

                i=1;

                $("#fr_contratar #observacion").css('border', 'solid 1px red');
                $("#fr_contratar #observacion").focus();
            }

            if(c_tres == ""){ message += 'Debes Seleccionar Usuario';
                i=1;

                $("#fr_contratar #user_autorizacion").css('border', 'solid 1px red');
                $("#fr_contratar #user_autorizacion").focus();
            }

            if(i === 1){ alert(message);}

            return i;
        }

        $(document).on("click",".btn_rechazar", function() {

            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.rechazar_candidato_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })

        });

        $(document).on("click", "#rechazar_candidato", function() {

            $.ajax({
                type: "POST",
                data: $("#fr_rechazo").serialize(),
                url: "{{ route('admin.rechazar_candidato') }}",
                success: function(response) {
                    if (response.success) {
                        var candidato_req = $("#candidato_req_fr").val();
                        var td = $("#grupo_btn_" + candidato_req + "").parent().parent().remove();
                        $("#modal_peq").modal("hide");
                        $("#grupo_btn_" + candidato_req + "").find(".btn_rechazar").prop("disabled", true);

                        mensaje = 'El candidato ha sido inactivado<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';

                        mensaje_success(mensaje);
                        updateClock("tiempo_recarga", 3);
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })

        });

        $("#estados_requerimiento").on("click", function() {
            
            $.ajax({
                type: "POST",
                data: {req_id: "{{$requermiento->id}}"},
                url: "{{route('admin.estados_requerimiento')}}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click", "#terminar_requerimiento", function() {
            
            var obj = $("#observaciones_terminacion").val();
            var estado = $("#estado_terminacion").val();

            $.ajax({
                type: "POST",
                data: "req_id={{$requermiento->id}}&observaciones_terminacion=" + obj + "&estado_requerimiento=" + estado,
                url: "{{route('admin.terminar_requerimiento')}}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");

                        mensaje_success("Se ha terminado el requerimiento.");
                        window.location.href = '{{route("admin.gestion_requerimiento",[$requermiento->id])}}';

                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                    }
                }
            });

        });

        // Armar email a candidato gestion requerimiento
        $(document).on("click", ".construir_email", function(){
            
            var objButton = $(this);
            id_candidato = objButton.parent().find("input").val();
            $.ajax({
                type: "POST",
                data: "id_candidato="+id_candidato,
                url: "{{route('admin.construir_email_gestion_req')}}",
                success: function(response){
                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                }
            });

        });
        // ---------- /

        //Enviar email a candidato gestion requerimiento
        $(document).on("click", ".enviar_email_candidato", function(){
            
            $.ajax({
                type: "POST",
                data: $("#fr_email").serialize(),
                url: "{{ route('admin.enviar_email_gestion_req')}}",
                success: function(response){
                    alert("Se envio el email correctamente.");
                }
            });

        });
        // ------ /

        // Configurar el informe preliminar en el requerimiento actual
        $(document).on("click", "#configurar_informe_preliminar", function(){
            
            var requerimiento_id = {{$requermiento->id}};

            if(requerimiento_id >= 1)
            {
                $.ajax({
                    type: "POST",
                    data: "requerimiento_id="+ requerimiento_id,
                    url: "{{ route('configurar_informe_preliminar_requerimiento')}} ",
                    success: function(response){
                      $("#modal_peq").find(".modal-content").html(response.view);
                      $("#modal_peq").modal("show");
                    }
                });
            }else{
                mensaje_danger("Problemas al abrir la configuración, favor intentar nuevamente.");
            }
            
        });

        $(document).on("click", ".detalle_otras_fuentes", function(){
            var cedula = $(this).data("id");
            var req_id = $(this).data("req_id");
           
            $.ajax({
                type: "POST",
                data: {
                 cedula:cedula,
                 req_id:req_id
                },
                url: "{{ route('admin.detalle_otras_fuentes')}} ",
                success: function(response){
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        // ------- /

        //Guardar la configuración del informe preliminar al requerimiento actual
        $(document).on("click", "#guardar_configuracion_informe_preliminar_requerimiento", function(){
            
            $.ajax({
                type: "POST",
                data: $("#fr_configuracion_informe_preliminar_requerimiento").serialize(),
                url: "{{ route('admin.guardar_configuracion_informe_preliminar_requerimiento')}}",
                success: function(response){
                    $("#modal_peq").modal("hide");
                    mensaje_success("Se guardo correctamente la configuración del informe preliminar.");
                    setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                }
            });

        });
        // ------ /

        //Eliminar todas los informes preliminares del requerimiento actual para poder cambiar la configuración del informe preliminar
        $(document).on("click", "#eliminar_informe_preliminar_evaluados", function(){

            if (confirm("Seguro de eliminar todas las calificaciones ya realizada a los candidatos en el requerimiento actual?")){
                var requerimiento_id = {{$requermiento->id}};
                $.ajax({
                    type: "POST",
                    data: "requerimiento_id="+ requerimiento_id,
                    url: "{{ route('admin.eliminar_informe_preliminar_requerimiento')}}",
                    success: function(response){
                        location.reload();
                        $("#modal_peq").modal("hide");
                        mensaje_success("Se elimino todos los registro evaluados de informe preliminar del requerimiento actual.");
                    }
                });
            }

        });
        // ------ /

        $(document).on("click", "#mostrarSeguimiento", function() {
            var req_id = $(this).data("req_id");
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
            var candidato_id = $(this).data("candidato_id");

            $.ajax({
                type: "POST",
                data: "req_id="+req_id+"&candidato_id="+ candidato_id +"&candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.seguimiento_candidato') }}",
                success: function(response) {
                    $("#modalTriLarge").find(".modal-content").html(response);
                    $("#modalTriLarge").modal("show");
                }
            })
        });

        //Enviar email con url de entrevista virtual
        $(document).on("click",".btn_video_entrevista", function(){

            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            var user_id = $(this).data("user_id");
            var candidato_req = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: "req_id="+req_id + "&cliente_id="+cliente_id+"&user_id="+user_id +"&candidato_req=" + candidato_req,
                url: "{{ route('admin.video_entrevista') }}",
                beforeSend: function(){
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
                    mensaje_success("Se envio un email para que el candidato realice la video entrevista.");
                    location.reload();
                }
            });

        });
        // ------ /

        $(document).on("click",".btn_prueba_idioma", function(){

            var cliente_id = $(this).data("cliente");
            var req_id = $(this).data("req_id");
            var user_id = $(this).data("user_id");
            var candidato_req = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: "req_id="+req_id + "&cliente_id="+cliente_id+"&user_id="+user_id +"&candidato_req=" + candidato_req,
                url: "{{ route('admin.enviar_prueba_idioma') }}",
                beforeSend: function(){
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
                    mensaje_success("Se envio un email para que el candidato realice la prueba de idioma.");
                    location.reload();
                }
            });

        });



        $(document).on("click",".btn_citar_to_cliente", function() {

          var candidato_req = $(this).data("candidato_req");

            $.ajax({
                type: "POST",
                data: {
                    'candidato_req' : candidato_req
                },
                url: "{{ route('admin.verifica_cita_cliente') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });

        });

        $(document).on("click", "#guardar_cita_to_cliente", function() {

            $.ajax({
                type: "POST",
                data: $('#frm_modifica_cita').serialize(),
                url: "{{ route('admin.modifica_cita_cliente') }}",
                success: function(response) {
                    mensaje_success("La cita ha sido activada con éxito.");

                    $("#modal_gr").modal("hide");

                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });

        });

        carga_filtro(1);//llama a funcion de preperfilados cuando carga la pagina
        carga_filtro_aplicaron(1);//llama a funcion de preperfilados cuando carga la pagina
        
        //funcion para mineria en preperfilados
        $(document).on("click","#filtrar-hv", function(){

            var filtro = $('#filtro-hv').val();
           // var req_id = $(this).data("req");
            var refresh = $(this).data("refresh");

            carga_filtro(refresh);

        });

        $(document).on("click","#filtrar-aplicaron", function(){

            var filtro = $('#filtro-aplicaron').val();
           // var req_id = $(this).data("req");
            var refresh = $(this).data("refresh");

            carga_filtro_aplicaron(refresh);

        });

        function carga_filtro_aplicaron(refresh){

            var filtro = $('#filtro-aplicaron').val();
            var req_id = {{$requermiento->id}};
            //var req_id = $(this).data("req");

            if(refresh === 1){
                $('#filtro-aplicaron').val('');
                filtro = '';
            }

            $.ajax({
                type: "POST",
                data: "req_id="+req_id+"&filtro="+filtro,
                url: "{{ route('admin.filtro_aplicaron') }}",
                error: function(response) {

                },
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('.tabla_aplicaron')) {
                        var datatable = $('.tabla_aplicaron').DataTable();
                        datatable.destroy();
                    }

                    $('#incluir_aplicaron').html(response.view);

                    var table = $('.tabla_aplicaron').DataTable({
                        "lengthChange": false,
                        "responsive": true,
                        "paginate": true,
                        "autoWidth": true,
                        "searching": false,
                        "order": [[ 1, "desc" ]],
                        "lengthMenu": [[10, 25, -1], [10, 25, "All"]],
                        "language": {
                            "url": '{{ url("js/Spain.json") }}'
                        }
                    });

                    if (table.data().count() > 0) {
                        $('#boton_agregar_aplicados').show();
                    } else {
                        $('#boton_agregar_aplicados').hide();
                    }
                }
            });
        }

        function carga_filtro(refresh){

            var filtro = $('#filtro-hv').val();
            var req_id = {{$requermiento->id}};
            //var req_id = $(this).data("req");

            if(refresh === 1){
                $('#filtro-hv').val('');
                filtro = '';
            }

            $.ajax({
               type: "POST",
               data: "req_id="+req_id+"&filtro="+filtro,
               url: "{{ route('admin.filtro_preperfilados') }}",
               beforeSend: function(){

                $('#incluir').html(' <label> Buscando....</label>');
                    //imagen de carga
                },
                error: function(response) {

                  //$.unblockUI();
                 // mensaje_success("Se envio un email para que el candidato realice la prueba de idioma.");
                 //console.log(response);
                    $('#incluir').html('<label>No se encontraron coincidencias..</label>');
                },

                success: function(response) {

                  //$.unblockUI();
                 // mensaje_success("Se envio un email para que el candidato realice la prueba de idioma.");
                 //console.log(response);
                    $('#incluir').html(response.view);

                    $('.data-table').DataTable({
                        "lengthChange": false,
                        "responsive": true,
                        "paginate": true,
                        "autoWidth": true,
                        "searching": false,
                        "order": [[ 1, "desc" ]],
                        "lengthMenu": [[5,10, 25, -1], [5,10, 25, "All"]],
                        "language": {
                          "url": '{{ url("js/Spain.json") }}'
                      }
                    });
                }
            });
        }

        @if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "http://localhost:8000")
      
            $(document).on("click", ".guardar_notas", function() {
                var notas = $('#notas').val();
                var enterprise = $('#enterprise').val();
                var req = {{$requermiento->id}};

                $.ajax({
                    type: "POST",
                    data: "req=" +req+ "&notas=" +notas+ "&enterprise=" +enterprise,
                    url: "{{route('admin.guardar_notas')}}",
                    success: function(response){
                        if(response.success){
                            swal('Atencion',response.mensaje,'info');
                            //$("#modal_gr").find(".modal-content").html(response.mensaje);
                            //$("#modal_gr").modal("show");
                            
                            $('#tabla_notas').children('td').remove();
                            $('#tabla_notas').html('<label>NOTAS ADICIONALES </label>  ' + notas + '<hr><label> ENTERPRISE  </label> ' + enterprise);
                        }
                    }
                })
            });

            $(document).on("click", "#orden_contra", function() {
                var req = {{$requermiento->id}};

                window.open("{{ route('orden_contratacion', ['req'=>$requermiento->id]) }}", '_blank');

                $.ajax({
                    type: "POST",
                    data: "req=" +req,
                    url: "{{ route('orden_contratacion',['req'=>$requermiento->id]) }}",
                    success: function(response){
                        if(response.success){
                            swal('Atencion',response.mensaje,'info');
                            //$("#modal_gr").find(".modal-content").html(response.mensaje);
                            //$("#modal_gr").modal("show");
                            $('#tabla_notas').children('td').remove();
                            $('#tabla_notas').html('<label>NOTAS ADICIONALES </label>  ' + notas + '<hr><label> ENTERPRISE  </label> ' + enterprise);
                        }
                    }
                })
            });
        @endif

        $(document).on("click", ".eliminar_proceso", function() {
             
            var proceso=$(this).data("proceso");
            var proceso_id=$(this).data("id");
            var candidato=$(this).data("candidato");

            $.ajax({
                type: "POST",
                data: {
                    proceso:proceso,
                    proceso_id:proceso_id,
                    candidato:candidato
                },
                url: "{{route('admin.eliminar_proceso')}}",
                success: function(response){
                
                   $("#modal_peq").find(".modal-content").html(response);
                  
                  $("#modal_peq").modal("show");
                 
                 }
                
            })

        });

        $(document).on("click", "#confirmar_eliminar_proceso", function() {
            
            $.ajax({
                type: "POST",
                data: $("#fr_eliminar_proceso").serialize(),
                url: "{{ route('admin.confirmar_eliminar_proceso') }}",
                success: function(response) {
                     $("#modal_peq").modal("hide");
                     
                   mensaje_success("El proceso ha sido eliminado");
                    setTimeout(function(){location.reload()}, 1500);
                }
            });
        
        });

        $(document).on("click", ".reabrir_proceso", function() {
             
            var proceso=$(this).data("proceso");
            var proceso_id=$(this).data("id");
            var candidato=$(this).data("candidato");

            $.ajax({
                type: "POST",
                data: {
                    proceso:proceso,
                    proceso_id:proceso_id,
                    candidato:candidato
                },
                url: "{{route('admin.reabrir_proceso')}}",
                success: function(response){
                
                  $("#modal_peq").find(".modal-content").html(response);

                  $("#modal_peq").modal("show");
                 
                 }
                
            })
        });

        $(document).on("click", "#confirmar_reabrir_proceso", function() {

            $.ajax({
               type: "POST",
               data: $("#fr_reabrir_proceso").serialize(),
               url: "{{route('admin.confirmar_reabrir_proceso')}}",
                success: function(response) {
                     $("#modal_peq").modal("hide");
                     
                 mensaje_success("El proceso se ha abierto");
                  setTimeout(function(){location.reload()}, 1500);
                }
            });
        
        });

        //funcion para enviar al proceso o  quedar alli
        @if(route("home") == "https://listos.t3rsc.co" || route("home") == "http://localhost:8000")
            function ir_gestionar(ruta){
                var gestion = ruta;

                swal("Enviado al Proceso", " ¿Desea ir a gestionar?", "info", {
                    buttons: {
                        cancelar: { text: "No", className:'btn btn-success'
                    },
                    agregar: {
                        text: "Si", className:'btn btn-warning'
                    },
                },
                }).then((value) => {
                    switch(value){
                        case "cancelar":
                        //aqui queda en gestion
                        break;
                        case "agregar":
                        window.location.href = gestion;
                        //AQUI CODIGO DONDE AGREGAS
                        break;
                    }
                });
            }
        @endif

        @if(route('home')== "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
            //para long list
            $(document).on("click","#btn_long", function(e) {
                e.preventDefault();
         
                var req = {{$requermiento->id}};

                if($("input[name='req_candidato[]']").serialize() == ''){
                    mensaje_success("Debes seleccionar al menos un candidato.");
                    return false;
                }else{
                    var candidato = $("input[name='req_candidato[]']").serialize();

                    //$(this).prop("href","?"+candidato+"&req_id="+req);
                    window.open("{{route('admin.hv_long_list')}}?"+candidato+"&req_id="+req,'_blank');
             
                    return false;
                }
            });

            //para long list
            $(document).on("click","#btn_long2", function(e) {
                e.preventDefault();
         
                var req = {{$requermiento->id}};

                if($("input[name='req_candidato[]']").serialize() == ''){
                    mensaje_success("Debes seleccionar al menos un candidato.");
                    return false;
                }else{
                  
                  var candidato = $("input[name='req_candidato[]']").serialize();
                    //$(this).prop("href","?"+candidato+"&req_id="+req);
                  window.open("{{route('admin.excel_long_list')}}?"+candidato+"&req_id="+req,'_blank');

                    return false;
                }
            });

        @endif
    });

    $(function () {
        $('#export_excel_btn').click(function(e){
            $req = $(this).data("req");
            $(this).prop("href","{{ route('admin.otras_fuentes_excel')}}?req="+$req);
        });
    })
</script>