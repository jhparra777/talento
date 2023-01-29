@extends("admin.layout.master")
@section('contenedor')

<h3>Gestionar Aprobar Cliente</h3>
<h5 class="titulo1">Información Candidato</h5>
<table class="table table-bordered">
    <tr>
        <th>Cedula</th>
        <td>{{$candidato->numero_id}}</td>
        <th>Nombres</th>
        <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
    </tr>
    <tr>
        <th>Telefono</th>
        <td>{{$candidato->telefono_fijo}}</td>
        <th>Movil</th>
        <td>{{$candidato->telefono_movil}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{$candidato->email}}</td>
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
        <th>Gestión Req</th>
    </tr>
    @foreach($estados_procesos_referenciacion as $ref)
    <tr>
        <td>{{$candidato->requerimiento_id}}</td>
        <td>{{$ref->name}}</td>

        <td>{{$ref->fecha_inicio}}</td>

        <td>{{$ref->proceso}}</td>
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

                  if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co" || route("home") == "http://desarrollo.t3rsc.co"){
                       
                       echo "Tentativo";
                     
                  }else{

                     echo "Pendiente";
                  }
                  
                break;
            }
            ?>
        </td>
        <td>{{$ref->motivo_rechazo_id}}</td>
        <td>{{$ref->observaciones}}</td>
        <td>
            <a href="{{ route('admin.gestion_requerimiento', $candidato->requerimiento_id) }}" class="btn btn-sm btn-info"> <i class="fa fa-arrow-circle-right"></i> Ir gestión Req</a>
        </td>
    </tr>
    @endforeach
</table>
<button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
@if (count($soporte_aprobacion) == 0)
    <button type="button" class="btn btn-info" id="nueva_documento">Documento Soporte Aprobación</button>
@endif

@if (count($soporte_aprobacion) > 0)
<div class="row">
    <div class="col-md-12">
        <h4 class="titulo1">Soporte Aprobación Cargado</h4>
        @foreach($soporte_aprobacion as $documento)
            @if($documento->nombre_archivo)
                <div class="container_referencia">
                    <div class="referencia">
                        <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <tr>
                                <th>Tipo Documento</th>
                                <td>{{$documento->tipo_doc}}</td>
                                <th>Fecha Vencimiento</th>
                                <td>{{$documento->fecha_vencimiento}}</td>
                            </tr>
                            <tr>
                                <th>Archivo</th>
                                <td><a href="{{url("recursos_documentos_verificados/".$documento->nombre_archivo)}}" target="_blank">Archivo</a></td>
                                <th>Ultima modificación</th>
                                <td>{{$documento->updated_at}}</td>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                                <td>{{$documento->descripcion_archivo}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
            @endif
        @endforeach
    </div>
</div>
@endif

<style>
    .badge-warning {
  background-color: #dd4b39;
}
</style>

<script>
    $(function () {

     var ruta = "{{route('admin.gestion_requerimiento',$candidato->requerimiento_id)}}";

        $("#cambiar_estado").on("click", function () {
            $.ajax({
                type: "POST",
                data: "ref_id={{$candidato->ref_id}}",
                url: "{{route('admin.cambiar_estado_view')}}",
                success: function (response) {
                  //  console.log("af");
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
                    if(response.success) {
                      
                      mensaje_success("Estado actualizado.. Espere sera redireccionado");
                       // window.location.href = "{{ route('admin.valida_documentos')}}";
                      setTimeout(function(){
                        location.href=ruta; }, 3000);

                    }else{
                     $("#modal_peq").find(".modal-content").html(response.view);
                    }

                }
            });
        });

        $("#nueva_documento").on("click", function () {
            $.ajax({
                type: "POST",
                data: "ref_id={{$candidato->ref_id}}",
                url: "{{ route('admin.nuevo_soporte_aprobacion',['ref_id'=>$candidato->ref_id]) }}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

        $(document).on("click", "#guardar_soporte_aprobacion", function () {
            if($('#fr_soporte_aprobacion').smkValidate()){
                $(this).prop("disabled", true);
                var formData = new FormData(document.getElementById("fr_soporte_aprobacion"));
                $.ajax({
                    url: "{{route('admin.guardar_soporte_aprobacion',['ref_id'=>$candidato->ref_id])}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#guardar_soporte_aprobacion").removeAttr("disabled");
                        var res = $.parseJSON(response);
                        if (res.success) {
                            mensaje_success("Se ha guardado correctamente el documento de soporte de aprobación del cliente!!");
                            window.location.href = '{{ route("admin.gestionar_aprobar_cliente_admin",[$candidato->ref_id]) }}'
                        } else {
                            $("#modal_peq").find(".modal-content").html(res.view);
                        }
                    }
                });
            }
        });
    });
</script>
@stop