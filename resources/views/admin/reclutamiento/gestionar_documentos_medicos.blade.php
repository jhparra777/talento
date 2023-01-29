@extends("admin.layout.master")
@section('contenedor')

    <h3>Gestionar Documentos</h3>
    <h5 class="titulo1">Información Candidato</h5>

    <table class="table table-bordered">
        <tr>
            <th>Cargo</th>
            <td>{{ $candidato->cargo }}</td>
            <th>Cedula</th>
            <td>{{ $candidato->numero_id }}</td>
        </tr>

        <tr>
            <th>Nombres</th>
            <td>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</td>
            <th>Telefono</th>
            <td>{{ $candidato->telefono_fijo }}</td>
        </tr>

        <tr>
            <th>Movil</th>
            <td>{{ $candidato->telefono_movil }}</td>
            <th>Email</th>
            <td>{{ $candidato->email }}</td>
        </tr>
    </table>

    <?php $i = 0; ?>
    @if($sitioModulo->salud_ocupacional != 'si')

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
                    <td><div class="badge  badge-over">
                            <span>{{ $candidato->requerimiento_id }}</span>
                        </div>
                    </td>
                    <td>{{ $ref->name }}</td>
                    <td>{{ $ref->fecha_inicio }}</td>
                    <td>{{ $ref->proceso }}</td>
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
                    <td>{{ $ref->motivo_rechazo_id }}</td>
                    <td>{!! $ref->observaciones !!}</td>
                    <td>
                        <a href="{{ route('admin.gestion_requerimiento', $candidato->requerimiento_id) }}" class="btn btn-sm btn-info"> <i class="fa fa-arrow-circle-right"></i> Ir gestión Req</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h3>Orden #{{ (!empty($ordenes)) ? $ordenes->id : $i++ }}</h3>
        <h5>Examenes a realizar:</h5>

        <ul>
            @foreach($examenes as $examen)
                <li>{{$examen->nombre}}</li>
            @endforeach
        </ul>
    @endif

    @if($sitioModulo->salud_ocupacional != 'si')
        <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
    @endif

    <a class="btn btn-warning" href="{{ route('admin.examenes_medicos') }}" title="Volver">Volver</a>

    <button type="button" class="btn btn-info" id="nueva_documento">Nuevo Documento</button>
    {{--<button type="button" class="btn btn-info" id="nueva_documento">Nuevo Documento</button>--}}

    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
        <a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">Ficha PDF</a>
    @endif

    <div class="row">
        @if($sitioModulo->salud_ocupacional != 'si')
            @if(count($documento_verificados) > 0)
            <div class="col-md-7">
                <h4 class="titulo1">Documentos Verificados</h4>

                @foreach($documento_verificados as $documento)
                    <div class="container_referencia">
                        <div class="referencia">
                            <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                                <tr>
                                    <th>Tipo Documento</th>
                                    <td>{{ $documento->tipo_doc }}</td>
                                    <th>Fecha Realización</th>
                                    <td>{{ $documento->fecha_realizacion }}</td>
                                </tr>

                                <tr>
                                    <th>Archivo</th>
                                    <td><a href="{{ url("recursos_documentos_verificados/".$documento->nombre_archivo) }}" target="_blanck">Archivo</a></td>
                                    <th>Ultima modificación</th>
                                    <td>{{ $documento->updated_at }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="requerimientos">
                            <div class="btn_procesos">

                                @if($documento->fecha_vencimiento != "0000-00-00")
                                    @if($documento->diferencia_dias >= 0)
                                        @if(!in_array($documento->id, $req_prueba_gestionado))
                                            <a class="btn btn-success documento_utilizado " id="" data-documento="{{ $documento->id }}" data-req="{{ $candidato->requerimiento_id }}">Verificado</a>
                                        @endif
                                    @else
                                        <span style="" class="badge badge-warning">DOCUMENTO VENCIDO</span>  
                                    @endif
                                @endif
                            </div>

                            <h4 class="titulo1" style="margin: 0">Requerimientos</h4>

                            @foreach($documento->getRequerimientos() as $req)
                                <div class="badge  badge-over">
                                    <span>Req:{{ $req->requerimiento_id }} </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
            @if(count($documentos) > 0)
            <div class="col-md-9">
                <h4 class="titulo1">Documentos</h4>

                @foreach($documentos as $documento)
                    <div class="container_referencia">
                        <div class="referencia">
                            <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                                <tr>
                                    <th>Tipo Documento</th>
                                    <td>{{ $documento->tipo_doc }}</td>
                                    <th>Fecha Realización</th>
                                    <td>{{ $documento->fecha_realizacion }}</td>
                                </tr>
                                <tr>
                                    <th>Archivo</th>
                                    <td><a href="{{ url("recursos_documentos_verificados/".$documento->nombre_archivo) }}" target="_blanck">Archivo</a></td>
                                    <th>Ultima modificación</th>
                                    <td>{{ $documento->updated_at }}</td>
                                </tr>
                                <tr>
                                    <th>Observación</th>
                                    <td>{!! $documento->observacion !!}</td>
                                    <th>Resultado</th>
                                    <td>@if($documento->resultado == 1)
                                            Apto para el cargo
                                        @elseif($documento->resultado == 2)
                                            Aplazado
                                        @elseif($documento->resultado == 3)
                                            Apto con recomendaciones
                                        @elseif($documento->resultado == 4)
                                            Apto con restricciones
                                        @elseif($documento->resultado == 9)
                                            No apto
                                        @endif
                                    </td>
                            </table>
                        </div>

                        <div class="requerimientos">
                            {{--<div class="btn_procesos">

                                @if($documento->fecha_vencimiento != "0000-00-00")
                                    @if($documento->diferencia_dias >= 0)
                                        @if(!in_array($documento->id, $req_prueba_gestionado))
                                            <a class="btn btn-success documento_utilizado " id="" data-documento="{{ $documento->id }}" data-req="{{ $candidato->requerimiento_id }}">Verificado</a>
                                        @endif
                                    @else
                                        <span style="" class="badge badge-warning">DOCUMENTO VENCIDO</span>  
                                    @endif
                                @endif
                            </div>

                            <h4 class="titulo1" style="margin: 0">Requerimientos</h4>

                            <div class="badge  badge-over">
                                <span>Req:{{ $documento->requerimiento }} </span>
                            </div>--}}
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
            @endif
        @endif
    </div>

    <style>
        .badge-warning { background-color: #dd4b39; }
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
                        //console.log("af");
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
                         setTimeout(function(){
                           location.href="{{session('url_previa')}}"; }, 3000);
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }

                    }
                });
            });

            $("#nueva_documento").on("click", function () {
                <?php
                    $ref_id=(!empty($ordenes->id))?$ordenes->id:$candidato->ref_id;
                ?>
                $.ajax({
                    type: "POST",
                    data: "ref_id={{(!empty($ordenes->id))?$ordenes->id:$candidato->ref_id}}",
                    url: "{{ route('admin.nuevo_documento.medico',$ref_id) }}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_documento_verificado", function () {
                $(this).prop("disabled", true);
                var formData = new FormData(document.getElementById("fr_documento_verificado"));

                $.ajax({
                    url: "{{route('admin.guardar_documento_verificado')}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (res) {
                  
                  $("#guardar_documento_verificado").removeAttr("disabled");
                   
                    var res = $.parseJSON(res);
                    if (res.success) {
                        window.location.href = res.ruta;
                    } else {
                        $("#modal_peq").find(".modal-content").html(res.view);
                    }

                });
            });

            $(document).on("click", "#guardar_examen_medico", function () {
                $(this).prop("disabled", true);
                var formData = new FormData(document.getElementById("fr_documento_verificado"));

                $.ajax({
                    url: "{{ route('admin.guardar_examen_medico') }}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (res) {
                    $("#guardar_examen_medico").removeAttr("disabled");

                    var res = $.parseJSON(res);
                    
                    if(res.success){
                        window.location.href = res.ruta;
                    }else{
                        $("#modal_peq").find(".modal-content").html(res.view);
                    }

                });
            });

            $(".documento_utilizado").on("click", function () {
                var documento = $(this).data("documento");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, doc_id: documento},
                    url: "{{ route('admin.registra_documento_entidad') }}",
                    success: function (response) {
                        mensaje_success("Registro utilizado!!");
                        var div = btn.parent().parent();
                        btn.remove();
                        div.append('<div class="badge  badge-over"><span>Req : ' + req + '</span></div>');

                    }
                });
            });

            $(document).on("click", ".documento_gestionado_hv", function () {
                var documento = $(this).data("documento");
                var req = $(this).data("req");

                $.ajax({
                  type: "POST",
                  data: {req_id: req, documento_id: documento},
                  url: "{{ route('admin.agrega_doc_gestion') }}",
                  success: function () {
                    mensaje_success("Documento Verificado!!");
                    window.location.href = "{{route('admin.gestionar_documentos',[$candidato->ref_id])}}";
                  }
                });
            });

            $(document).on("change", "#tipo_documento", function () {
                $("#descripcion_documento").val($("#tipo_documento").find("option:selected").text())
            });
        });
    </script>
@stop