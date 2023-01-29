<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Candidatos rechazar
    </h4>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <thead>
            <tr>
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
                    {{$requerimiento->name}}
                </td>
                <td>
                    <a class="btn btn-primary" href="{{route('admin.informe_seleccion',[$requerimiento->requerimiento_candidato_id])}}" target="_blank">
                        Ver informe de selección
                    </a>
                </td>
                <td>
                  @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                        <button class="btn btn-success btn_contratar" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                        Avanzar
                        </button>
                  @else
                        <button class="btn btn-success btn_contratar" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                        Contratar
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
    $(".btn_contratar").on("click", function() {
            //alert('lol');
            var req_id = $(this).data("req_id");
            var user_id = $(this).data("user_id");
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");
            $.ajax({
                type: "POST",
                data: "req_id=" + req_id +"&user_id=" + user_id + "&candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_contratar') }}",
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
                url: "{{ route('admin.enviar_contratar2') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

          $(document).on("click", "#confirmar_contratacion", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_contratar").serialize(),
                url: "{{ route('admin.enviar_a_contratar_cliente') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        
                        mensaje_success("Los datos de contratación han sido enviados.");

                        window.location.href = '{{route("admin.mis_requerimiento")}}';
                    } else {
                        //mensaje_success("El requerimiento ya se encuentra cerrado");
                        $("#modal_peq").find(".modal-content").html(response.view);


                    }

                }
            });
        });
</script>