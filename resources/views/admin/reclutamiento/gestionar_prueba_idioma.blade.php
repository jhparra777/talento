@extends("admin.layout.master")
@section('contenedor')

    <h3>Gestionar Prueba Idioma</h3>
    <br><br>
    <h4>Informacíon del requerimiento</h4>

    <table class="table table-bordered">
        <tr>
            <th>N° requerimiento</th>
            <td>{{ $prueba_idioma->req_id }}</td>
            <th>Persona quien creo la prueba</th>
            <td>{{ $prueba_idioma->user_gestion }}</td>
        </tr>

        <tr>
            <th>Fecha de creacion de la prueba</th>
            <td>{{ $prueba_idioma->fecha_creacion }}</td>
            <th>Cargo</th>
            <td>{{ $prueba_idioma->cargo_especifico }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.gestion_requerimiento', $prueba_idioma->req_id) }}" class="btn btn-sm btn-info"> <i class="fa fa-arrow-circle-right"></i> Ir gestión Req</a>

    @if($preguntas_prueba->count() != 3)
    
        <a class="btn btn-success crear_pregunta_prueba" data-entrevista_id ="{{ $prueba_idioma->id }}">Crear Pregunta</a>
        <a class="btn btn-warning" href="{{ route("admin.pruebas_idiomas") }}" >Atŕas</a>

    @else
    
        <a class="btn btn-success" data-entrevista_id ="{{ $prueba_idioma->id }}" disabled>Crear Pregunta</a>
        <a class="btn btn-warning" href="{{ route("admin.pruebas_idiomas") }}">Atŕas</a>

    @endif
    <br><br><br>

    <div class="row">
        <div class="box">
   	        <div class="box-header with-border">
                <h3 class="box-title">PREGUNTAS</h3>
                <br><br>
            </div>
     
            <div class="box-body table-responsive no-padding" style="height: 200px;">

                <div class="table-responsive">
    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>N°</td>
                                <td>Descripción</td>
                                <td style="text-align: center;">Acción</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if($preguntas_prueba->count() == 0)
                                <tr>
                                    <td colspan="4">No se encontraron registros</td>
                                </tr>
                            @endif
                            
                            @foreach($preguntas_prueba as $key => $pregu)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$pregu->descripcion}}</td>

                    	           @if($pregu->activo ==1)
                                        <td style="text-align: center;" >
                                            @if($pregu->preguntas_respuestas() > 0)

                    	                       <a class="btn btn-warning  gestionar_respuestas" id="" href="{{route("admin.gestionar_respuesta_idioma",["req_id"=>$req_id,"pregu_id"=>$pregu->id])}}">Gestionar Respuestas</a>

                    	                    @else

                    	                        <a class="btn btn-warning" id="" data-pregunta_id="{{$pregu->id}}" disabled>Gestionar Respuestas</a>

                                            @endif

                    	                        <a class="btn btn-info  editar_pregunta" id="" data-pregunta_id="{{$pregu->id}}"  >Editar Pregunta</a>
                                                <a class="btn btn-danger pregunta_activa_prueba" id="" data-pregunta_id="{{$pregu->id}}" >Inactivar Pregunta</a>

                                        </td>
                                            @else

                                                <td style="text-align: center;" >
                                                    <a class="btn btn-info editar_pregunta" id="" data-pregunta_id="{{$pregu->id}}" >Editar Pregunta</a>
                                                    <a class="btn btn-success pregunta_inactiva_prueba" id="" data-pregunta_id="{{$pregu->id}}" >Activar Pregunta</a>
                                                </td>

                    	                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
     	    </div>
        </div>
    </div>

    <script>
    	$(function () {

    		$(document).on("click",".pregunta_activa_prueba", function () {
                var pregunta_id = $(this).data("pregunta_id");

                $.ajax({
                    type: "POST",
                    data: {pregunta_id: pregunta_id},
                    url: "{{ route('admin.pregunta_activa_prueba_idioma') }}",
                    success: function (response) {
                       
                        mensaje_success("Pregunta inactiva");
                        location.reload();                    

                    }
                });
            });

            $(document).on("click",".pregunta_inactiva_prueba", function () {
                var pregunta_id = $(this).data("pregunta_id");

                $.ajax({
                    type: "POST",
                    data: {pregunta_id: pregunta_id},
                    url: "{{ route('admin.pregunta_inactiva_prueba_idioma') }}",
                    success: function (response) {
                       
                        mensaje_success("Pregunta activada");
                        location.reload();                    

                    }
                });
            });

            $(".editar_pregunta").on("click", function() {
                var pregunta_id = $(this).data("pregunta_id");

                $.ajax({
                    type: "POST",
                    data: {pregunta_id: pregunta_id},
                    url: "{{route('admin.editar_pregunta_prueba_idioma')}}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#actualizar_pregunta_idioma", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_editar_pregunta_prueba").serialize() + "&enviar=1",
                    url: "{{ route('admin.actualizar_pregunta_prueba') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                        mensaje_success("Se ha actualizado la pregunta");
                        location.reload();
                    }
                });
            });

            $(".crear_pregunta_prueba").on("click", function() {
                var entre_id = $(this).data("entrevista_id");

                $.ajax({
                    type: "POST",
                    data: {entrevista_id: entre_id},
                    url: "{{route('admin.crear_pregunta_prueba')}}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_pregunta_prueba_idioma", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_crear_pregunta_prueba_idioma").serialize() + "&enviar=1",
                    url: "{{ route('admin.guardar_pregunta_prueba') }}",
                    success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                        mensaje_success("Se ha guardado la pregunta con éxito.");
                        location.reload();
                    }
                });
            });

        });
    </script>

@stop