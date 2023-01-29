@extends("admin.layout.master")
@section('contenedor')

<h3>Gestionar Vinculacion</h3>
<h5 class="titulo1">Información Candidato</h5>
<table class="table table-bordered">
    <tr>
        <th>Cedula</th>
        <td>{{$candidato->numero_id}}</td>
        <th>Nombres</th>
        <td>{{strtoupper($candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido)}}</td>
    </tr>
    <tr>
        <th>Telefono</th>
        <td>{{$candidato->telefono_fijo}}</td>
        <th>Movil</th>
        <td>{{$candidato->telefono_movil}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{strtoupper($candidato->email)}}</td>
    </tr>

</table>

<table class="table table-bordered tbl_info">
    <tr>
        <th colspan="7">Estado</th>
    </tr>
    <tr>
        <th>Requerimiento</th>
        <th>Usuario Envio</th>
        <th>Fecha Registro</th>
        <th>Proceso</th>
        <th>Estado</th>
        <th>Motivo Rechazo</th>
        <th>Observaciones</th>
    </tr>
    @foreach($estados_procesos_referenciacion as $ref)
    <tr>
        <td>{{$candidato->requerimiento_id}}</td>
        <td>{{strtoupper($ref->name)}}</td>

        <td>{{$ref->fecha_inicio}}</td>

        <td>
            @if($ref->proceso == "ENVIO_VALIDACION")
                <p>ENVIO VINCULACIÓN</p>
            @endif
        </td>
        <td>
            <?php
            switch ($ref->apto) {
                case 1:
                    echo "Apto";
                    break;
                case 2:
                    echo "No Apto";
                    break;
                case 3:
                    echo "Pendiente";
                    break;
            }
            ?>
        </td>
        <td>{{$ref->motivo_rechazo_id}}</td>
        <td>{{$ref->observaciones}}</td>
    </tr>
    @endforeach
</table>
<button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
<a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">
    Ficha PDF
</a>

<!--
<div class="row">
    <h3 class="titulo1">Gestionar Vinculación</h3>
    <div class="container_referencia">
        <div class="referencia">
            <table class="table table-hover" style="margin-bottom: 0px">
                <tr>
                    <th>Validar</th>
                    <th>Documento</th>
                </tr>
            @foreach($validacion as $valida)
                <tr>
                    <td> 
                        <button type="button" class="btn btn-success validar"
                            data-req="{{$candidato->requerimiento_id}}" 
                            data-user="{{$candidato->user_id}}" 
                            data-ficha="{{$ficha}}" 
                            data-documento="{{$valida->id}}">
                            Validar
                        </button>
                    </td>
                    <td> {{$valida->descripcion}} </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
</div>
-->

<script>
    $(function () {

        $(document).on("click", ".validar", function () {
            var req_id = $(this).data("req");
            var user_id = $(this).data("user");
            var ficha_id = $(this).data("ficha");
            var documento_id = $(this).data("documento");
            $.ajax({
                data:"req_id=" + req_id + "&user_id=" + user_id + "&ficha_id=" + ficha_id + "&documento_id=" + documento_id,
                url: "{{route('admin.validar_vinculacion')}}",
                success: function (response) {
                    if (response.success) {
                        mensaje_success("El documento se encuentra validado.");
                    }else{
                        mensaje_danger("Problemas al realizar la validación.");    
                    }
                }
            });
        });

        $("#cambiar_estado").on("click", function () {
            $.ajax({
                type: "POST",
                data: "ref_id={{$candidato->ref_id}}&modulo=pruebas",
                url: "{{route('admin.cambiar_estado_view')}}",
                success: function (response) {
                    console.log("af");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(document).on("click", "#guardar_estado", function () {
            $.ajax({
                data: $("#fr_cambio_estado").serialize(),
                url: "{{route('admin.guardar_cambio_estado')}}",
                success: function (response) {
                    if (response.success) {
                        mensaje_success("Estado actualizado");
                        window.location.href = "{{ route('admin.vinculacion_lista')}}";
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }

                }
            });
        });
       

    });
</script>
@stop