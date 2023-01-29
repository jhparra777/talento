@extends("admin.layout.master")
@section('contenedor')

    <h3>Gestionar Documentos</h3>
    
    <h5 class="titulo1">Información Candidato</h5>
    
    <table class="table table-bordered">
        <tr>
            <th>Cargo</th>
            <td>{{$candidato->cargo}}</td>
            <th>Cedula</th>
            <td>{{$candidato->numero_id}}</td>
        </tr>

        <tr>
            <th>Nombres</th>
            <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
            <th>Telefono</th>
            <td>{{$candidato->telefono_fijo}}</td>
        </tr>

        <tr>
            <th>Movil</th>
            <td>{{$candidato->telefono_movil}}</td>
            <th>Email</th>
            <td>{{$candidato->email}}</td>
        </tr>
    </table>

    @if(1==1)
        
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

    @else

        <h3>Orden #{{$ordenes->id}}</h3>
        <h5>Estudios a realizar:</h5>

        <ul>
            @foreach($estudiosSeg as $examen)
                <li>{{$examen->nombre}}</li>
            @endforeach
        </ul>

    @endif

    @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" || route("home")=="http://localhost:8000" ||  route("home")=="https://listos.t3rsc.co")
        <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
    @endif

    <a class="btn btn-warning" href="{{ route('admin.estudios_seguridad') }}" title="Volver">Volver</a>
    <button type="button" class="btn btn-info" id="nuevo_documento_estudio">Nuevo Documento</button>

    @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" || route("home")=="http://localhost:8000")
      
      <a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">Ficha PDF</a>
    @endif


    <div class="row">
        <div class="col-md-7">
            <h4 class="titulo1">Documentos Verificados</h4>
            @foreach($documento_verificados as $documento)
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
                                <td><a href="{{url("recursos_documentos_verificados/".$documento->nombre_archivo)}}" target="_blanck">Archivo</a></td>
                                <th>Ultima modificación</th>
                                <td>{{$documento->updated_at}}</td>
                            </tr>
                            
                            <tr>
                                <th>Descripcion</th>
                                <td>{{$documento->descripcion}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="requerimientos">
                        <div class="btn_procesos">
                            @if($documento->fecha_vencimiento != "0000-00-00")
                                @if($documento->diferencia_dias >= 0)
                                    @if(!in_array($documento->id,$req_prueba_gestionado))
                                        <a class="btn btn-success documento_utilizado " id="" data-documento="{{$documento->id}}" data-req="{{$candidato->requerimiento_id}}">Verificado</a>    
                                    @endif
                                @else
                                    <span style="" class="badge badge-warning">DOCUMENTO VENCIDO</span>  
                                @endif
                            @endif
                        </div>

                        <h4 class="titulo1" style="margin: 0">Requerimientos</h4>
                        
                        @foreach($documento->getRequerimientos() as $req)
                            <div class="badge  badge-over">
                                <span>Req:{{$req->requerimiento_id}} </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .badge-warning {background-color: #dd4b39;}
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
                            window.location.href = ruta;
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }

                    }
                });
            });

            $("#nuevo_documento_estudio").on("click", function () {
                <?php
                    $ref_id=(!empty($ordenes->id))?$ordenes->id:$candidato->ref_id;
                ?>
                $.ajax({
                    type: "POST",
                    data: "ref_id={{(!empty($ordenes->id))?$ordenes->id:$candidato->ref_id}}",
                    url: "{{route('admin.nuevo_documento_estudio_seguridad',$ref_id)}}",
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
                    var res = $.parseJSON(res);
                    console.log(res);
                    if (res.success) {
                      window.location.href = res.ruta;
                    }else{
                       $("#modal_peq").find(".modal-content").html(res.view);
                    }

                });
            });

            $(document).on("click", "#guardar_estudio_seguridad", function () {

                $(this).prop("disabled", true);
                 var formData = new FormData(document.getElementById("fr_documento_verificado_seguridad"));

                $.ajax({
                    url: "{{route('admin.guardar_estudio_seguridad')}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (res) {
                  
                  var res = $.parseJSON(res);
                   if(res.success){
                    mensaje_success("Candidato gestionado correctamente.");
                      console.log(res);
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
                    success: function (data) {
                       mensaje_success("Documento Verificado!!");
                       window.location.href = data.ruta;
                       console.log(data)
                    }
                });
            });

            $(document).on("change", "#tipo_documento", function () {
                $("#descripcion_documento").val($("#tipo_documento").find("option:selected").text())
            });

        });
    </script>

@stop