<div class="modal-header">
  <button aria-label="Close" class="close" data-dismiss="modal" type="button">
    <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">
        Candidatos Aprobar
    </h4>
</div>
<div class="modal-body">
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">
                    Nombre
                </th>
                <th class="text-center">
                    Informe de selección
                </th>
                <th class="text-center">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($req->candidatosAprobar() as $requerimiento)
            <tr>
                <td class="text-center">
                    {{$requerimiento->name}}
                </td>
                <td class="text-center">
                    <a class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route('admin.informe_seleccion',[$requerimiento->requerimiento_candidato_id])}}" target="_blank">
                        Ver informe de selección
                    </a>
                </td>
                <td class="text-center">
                    <button class="btn btn-success btn_contratar | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" data-candidato_req="{{$requerimiento->requerimiento_candidato_id}}" data-cliente="{{$cliente->id}}" data-req_id="{{$requerimiento->requerimiento_id}}" data-user_id="{{$requerimiento->candidato_id}}">
                        Contratar
                    </button>
                    <button class="btn btn-danger candidato_no_aprobado | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" data-candidato="{{$requerimiento->candidato_id}}" data-req_candidato="{{$requerimiento->requerimiento_candidato_id}}">
                        No Aprobado
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal" type="button">
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
                    $("#modalTriLarge").modal("hide");
                    $("#modalTriSmall").find(".modal-content").html(response);
                    $("#modalTriSmall").modal("show");
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
                  $("#modalTriLarge").modal("hide");
                  $("#modalTriSmall").find(".modal-content").html(response);
                  $("#modalTriSmall").modal("show");
                }
            });
        });

        $(document).on("click", "#confirmar_contratacion", function() {

            $.ajax({
                type: "POST",
                data: $("#fr_contratar").serialize(),
                url: "{{ route('admin.enviar_a_contratar') }}",
                beforeSend: function(response){

                },
                success: function(response) {
                  if(response.success) {
                    $("#modal_peq").modal("hide");
                        
                    mensaje_success("Los datos de contratación han sido enviados.");

                    window.location.href = '{{route("admin.mis_requerimiento")}}';
                  }else{
                        //mensaje_success("El requerimiento ya se encuentra cerrado");
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }

                }
            });
        });
        
</script>