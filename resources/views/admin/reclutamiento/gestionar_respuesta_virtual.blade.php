@extends("admin.layout.master")
@section('contenedor')

<h3>Respuestas</h3>

{!! Form::model(Request::all(), ["id" => "admin.lista_pruebas", "method" => "GET"]) !!}
    <div class="row">
        <div class="col-md-6  form-group">
            <label for="inputEmail3" class="col-sm-2 control-label"># Cédula:</label>
            <div class="col-sm-8">
                {!! Form::text("cedula",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
            </div> 
        </div>
    </div>

    <button class="btn btn-warning" >Buscar</button>
    <button class="btn btn-warning" type="button" onclick="window.location.reload();">Limpiar</button>
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>N°</td>
                <td>Ciudad</td>
                <td>Cedula</td>
                <td>Nombre</td>
                <td>Fecha respuesta</td>
                <td>Estado</td>
                <td style="text-align: center;">Acción</td>
            </tr>
        </thead>

        <tbody>
            @if($candidatos->count() == 0)
                <tr>
                    <td colspan="4"> No se encontraron registros</td>
                </tr>
            @endif
            
            @foreach($candidatos as $key=>$candidato)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $candidato->getUbicacionReq() }}</td>
                    <td>{{ $candidato->numero_id }}</td>
                    <td>{{ $candidato->nombres }}</td>
                    <td>{{ $candidato->fecha_respuesta }}</td>
                    <td>{{ $candidato->proceso }}</td>
                    
                    <td style="text-align: center;">
                        @if($candidato->apto != 1)
                            <a
                                type="button"
                                data-pregunta_id="{{ $pregu_id }}"
                                data-candidato_id="{{ $candidato->user_id }}"
                                class="btn btn-success respuesta_candidato"
                                id="respuesta_candidato"
                            >
                                Video respuesta
                            </a>
                      
                            <button
                                type="button"
                                class="btn btn-warning cambiar_estado"
                                data-ref_id="{{ $candidato->ref_id }}"
                                data-candidato_id="{{ $candidato->user_id }}"
                            >
                                Cambiar Estado
                            </button>
                      
                            <a
                                type="button"
                                class="btn btn-info"
                                href="{{ route("admin.hv_pdf", ["ref_id" => $candidato->user_id]) }}"
                                target="_blank"
                            >
                                HV PDF
                            </a>

                            <button
                                type="button"
                                class="btn btn-danger eliminar_respuesta"
                                data-pregunta_id="{{ $pregu_id }}"
                                data-candidato_id="{{ $candidato->user_id }}"
                            >
                                Eliminar
                            </button>
                        @else
                            <a
                                type="button"
                                data-pregunta_id="{{ $pregu_id }}"
                                data-candidato_id="{{ $candidato->user_id }}"
                                class="btn btn-success respuesta_candidato"
                                id="respuesta_candidato"
                            >
                                Video respuesta
                            </a>
                            
                            <button type="button" class="btn btn-warning" disabled>Cambiar Estado</button>
                            
                            <a
                                type="button"
                                class="btn btn-info"
                                href="{{ route("admin.hv_pdf", ["ref_id" => $candidato->user_id]) }}"
                                target="_blank"
                            >
                                HV PDF
                            </a>

                            <button
                                type="button"
                                class="btn btn-danger eliminar_respuesta"
                                data-pregunta_id="{{ $pregu_id }}"
                                data-candidato_id="{{ $candidato->user_id }}"
                            >
                                Eliminar
                            </button>
                       @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{!! $candidatos->appends(Request::all())->render() !!}

<script>
    $(function () {
        var ruta = "{{ route('admin.gestion_requerimiento',$candidato->requerimiento_id) }}";

        $(".respuesta_candidato").on("click", function () {
            var candidato_id = $(this).data("candidato_id");
            var pregunta_id = $(this).data("pregunta_id");
            
            $.ajax({
                type: "POST",
                data:{pregunta_id:pregunta_id,candidato_id: candidato_id},
                url: "{{route('admin.video_respuesta_candidato')}}",
                success: function (response) {
                    console.log("af");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");

                }
            });
        });

        $(".eliminar_respuesta").on("click", function () {
            var candidato_id = $(this).data("candidato_id");
            var pregunta_id = $(this).data("pregunta_id");
            
            $.ajax({
                type: "POST",
                data:{pregunta_id:pregunta_id,candidato_id: candidato_id},
                url: "{{route('admin.eliminar_video_respuesta_candidato')}}",
                success: function (response) {
                    console.log("response:", response);
                    if(response.success) {
                      mensaje_success("Respuesta eliminada con exito");
                      window.location.reload();
                    }else{
                        mensaje_danger("Ocurrio un error al eliminar la respuesta");
                    }

                }
            });
        });
        
        $(".cambiar_estado").on("click", function () {
            var candidato_id = $(this).data("candidato_id");
            //var pregunta_id = $(this).data("pregunta_id");
            var ref_id = $(this).data("ref_id");
            
            $.ajax({
                type: "POST",
                data:{candidato_id:candidato_id,pregunta_id:{{$pregu_id}},ref_id:ref_id},
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
                    if(response.success) {
                      mensaje_success("Estado actualizado sera redireccionado .....");
                      window.location.href = ruta;
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });
        });
    });
</script>
@stop