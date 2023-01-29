<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Candidatos Aprobar</h4>
</div>

<br>

<div class="col-xs-11" style="text-align: right; left : 20px;">
  <button type="button"  id="btn_contratacion_cliente_masivo" data-cliente="{{$cliente->id}}" class="btn  btn-success btn-lg btn_contratacion_cliente_masivo" >
        Contratación masiva
    </button>    
</div>

<br><br><br>

<div class="modal-body">
  <table class="table table-bordered">
        <thead>
            <tr>
                <th style="top: 10px;" >
                 {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar
                </th>
                <th style="text-align: center;">
                    Nombre
                </th>
                <th style="text-align: center;">
                    Informe de selección
                </th>
                <th style="text-align: center;">
                    Acción
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach($req->candidatosAprobar() as $requerimiento)
            <tr>
              <td>
                <input data-candidato_req="{{$candidato_req->req_candidato_id}}"  name="req_candidato_id[]" type="checkbox" value="{{$requerimiento->requerimiento_candidato_id}}"/>
              </td>

                <td>
                    {{$requerimiento->nombres}} {{$requerimiento->primer_apellido}} {{$requerimiento->segundo_apellido}}
                </td>

                <td style="text-align: center;" >
                    <a class="btn btn-primary" href="{{route('req.informe_seleccion',[$requerimiento->requerimiento_candidato_id])}}" target="_blank">
                        Ver informe de selección
                    </a>
                </td>

                <td>
                    <button class="btn btn-info btn_observaciones" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                        Observaciones
                    </button>

                    @if(route('home') == "http://localhost:8000" || route('home') == "https://desarrollo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "http://listos.t3rsc.co" || route('home') == "https://listos.t3rsc.co")

                        <button class="btn btn-warning btn_citar" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                            Citar
                        </button>

                    @endif

                    @if(route('home') != "http://komatsu.t3rsc.co")

                        <button class="btn btn-success btn_contratar" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                            Contratar
                        </button>
                    
                    @else
                       
                       <button class="btn btn-success btn_contratar" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                            Continuar
                        </button>

                    @endif

                    <button class="btn btn-danger candidato_no_aprobado" data-candidato="{{$requerimiento->candidato_id}}" data-req_candidato="{{$requerimiento->requerimiento_candidato_id}}">
                        NO Aprobado
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        Cerrar
    </button>
</div>

<script>

    $(".btn_contratacion_cliente_masivo").on("click", function() {
           
        var cliente_id = $(this).data("cliente");
            
        $.ajax({
            type: "POST",
            data: $("input[name='req_candidato_id[]']").serialize() + "&cliente_id="+cliente_id,
            url: "{{ route('req.contratar_masivo_cliente') }}",
            success: function(response) {
                $("#modal_peq").find(".modal-content").html(response);
                $("#modal_gr").modal("hide");
                $("#modal_peq").modal("show");
            }
        });

    });

    $("#seleccionar_todos").on("change", function () {
        var obj = $(this);

        $("input[name='req_candidato_id[]']").prop("checked", obj.prop("checked"));
    });
    
    $(".btn_observaciones").on("click", function(e) {
       
        var req_id = $(this).data("req_id");
        var user_id = $(this).data("user_id");
        var id = $(this).data("candidato_req");
        var cliente = $(this).data("cliente");
        var modulo="cliente";
        $.ajax({
            type: "POST",
            data: "req_id=" + req_id +"&user_id=" + user_id + "&candidato_req=" + id + "&cliente_id=" + cliente+"&modulo="+modulo,
            url: "{{ route('req.crear_observacion') }}",
            success: function(response) {
                $("#modal_gr").modal("hide");
                $("#modal_gra").find(".modal-content").html(response);
                $("#modal_gra").modal("show");
            }
        });
    });

    $(".btn_contratar").on("click", function() {
        var req_id = $(this).data("req_id");
        var user_id = $(this).data("user_id");
        var id = $(this).data("candidato_req");
        var cliente = $(this).data("cliente");
        $.ajax({
            type: "POST",
            data: "req_id=" + req_id +"&user_id=" + user_id + "&candidato_req=" + id + "&cliente_id=" + cliente,
            url: "{{ route('req.enviar_contratar_req') }}",
            success: function(response) {
                $("#modal_gr").modal("hide");
                $("#modal_peq").find(".modal-content").html(response);
                $("#modal_peq").modal("show");
            }
        });
    });

    $(".btn_contratar2").on("click", function() {
        //alert('lol');
        var req_id = $(this).data("req_id");
        var user_id = $(this).data("user_id");
        var id = $(this).data("candidato_req");
        var cliente = $(this).data("cliente");
        $.ajax({
            type: "POST",
            data: "req_id=" + req_id +"&user_id=" + user_id + "&candidato_req=" + id + "&cliente_id=" + cliente,
            url: "{{ route('req.enviar_contratar2_req') }}",
            success: function(response) {
                $("#modal_gr").modal("hide");
                $("#modal_peq").find(".modal-content").html(response);
                $("#modal_peq").modal("show");
            }
        });
    });

    $(document).on("click", "#confirmar_contratacion", function() {
        
        $(this).prop("disabled",true);
        var btn_id = $(this).prop("id");
        
        setTimeout(function(){
           $("#"+btn_id).prop("disabled",false);
        }, 50000);

        $.ajax({
            type: "POST",
            data: $("#fr_contratar_req").serialize(),
            url: "{{ route('req.enviar_a_contratar_cliente_req') }}",
            success: function(response) {
                if (response.success) {
                    $("#modal_peq").modal("hide");
                    mensaje_success("Los datos de contratación han sido enviados.");
                    window.location.href = '{{route("req.mis_requerimiento")}}';
                } else {
                    //mensaje_success("El requerimiento ya se encuentra cerrado");
                    $("#modal_peq").find(".modal-content").html(response.view);
                }
            }
        });
    });

    function mensaje_success_sin_boton(mensaje) {
        $("#modal_success_view #texto").html(mensaje);
        $("#modal_success_view").modal("show");
    }

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
            data: $("#fr_observacion_req").serialize(),
            url: "{{ route('req.guardar_observacion') }}",
            success: function(response) {
                if (response.success) {
                    $("#modal_peq").modal("hide");
                    alert("Se ha creado la observación con éxito!");
                    window.location.href = '{{route("req.mis_requerimiento")}}';
                } else {
                    //mensaje_success("El requerimiento ya se encuentra cerrado");
                    $("#modal_peq").find(".modal-content").html(response.view);
                }

            }
        });
    });

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
                    //mensaje_success("El requerimiento ya se encuentra cerrado");
                    $("#modal_peq").find(".modal-content").html(response.view);
                }
            }
        });
    });

    $(".btn_citar").on("click", function() {

        var req_id = $(this).data("req_id");
        var user_id = $(this).data("user_id");
        var id = $(this).data("candidato_req");
        var cliente = $(this).data("cliente");
        
        $.ajax({
            type: "POST",
            data: "req_id=" + req_id +"&user_id=" + user_id + "&candidato_req=" + id + "&cliente_id=" + cliente,
            url: "{{ route('req.crear_cita_cliente') }}",
            success: function(response) {
                $("#modal_gr").modal("hide");
                $("#modal_gra").find(".modal-content").html(response);
                $("#modal_gra").modal("show");
            }
        });
    });

    $(document).on("click", "#guardar_cita_cliente", function() {

        if($('#fecha_cita').val() == ''){

            $('#fecha_cita').css('border', 'solid red 1px');

        }else if($('#observacion_cita').val() == ''){

            $('#observacion_cita').css('border', 'solid red 1px');

        }else{

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
                    }else{
                       alert("Ocurrio un error en el servidor.");
                    }

                }
            });

        }

    });

</script>