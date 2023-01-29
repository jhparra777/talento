@extends("admin.layout.master")
@section('contenedor')
    <h3>Gestión Requerimientos</h3>

    {!!Form::model(Request::all(), ["route" => "admin.lista_requerimientos", "method" => "GET"]) !!}
        
        @include('admin.requerimientos.includes._inputs_buscar_editar_requerimiento')

        <a class="btn btn-info" href="{{ route("admin.lista_requerimientos") }}">Limpiar</a>
    
    {!! Form::close() !!}
    
    <br>

    @include('admin.requerimientos.includes._table_editar_requerimientos', ["modulo" => "admin"])

    <script>
        $(function () {
            
            $(".estados_requerimiento").on("click", function () {
                var req_id = $(this).data("req");

                $.ajax({
                    type: "POST",
                    data: {req_id: req_id},
                    url: "{{route('admin.estados_requerimiento')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#terminar_requerimiento", function () {
                var obj = $("#observaciones_terminacion").val();
                var estado = $("#estado_terminacion").val();
                var motivo = $("#motivo_cancelacion").val();
                var req_id = $("#req_id").val();

                $.ajax({
                    type: "POST",
                    data: "req_id=" + req_id + "&observaciones_terminacion=" + obj + "&estado_requerimiento=" + estado + "&motivo_cancelacion=" + motivo,
                    url: "{{ route('admin.terminar_requerimiento') }}",
                    success: function (response) {
                        if (response.success) {
                            $("#modal_peq").modal("hide");
                            mensaje_success("Se ha terminado el requerimiento.");
                            window.location.href = '{{ route("admin.lista_requerimientos") }}';
                        }else{
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").attr("data-spy","scroll");
                        }
                    }
                });
            });

            $("#btn_pri_req").on("click", function (e) {
                var obj = $(this);
                var ids = $("input[type='checkbox']").serialize();
                var req_ids = $("input[name='req_ids[]']").serialize();
                var href = obj.attr("href");
                obj.attr("href", href + "?" + ids + "&" + req_ids);
                return true;
            });
        });
    </script>
@stop
