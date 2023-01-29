@extends("admin.layout.master")
@section('contenedor')

<h3>Gestionar Documentos</h3>
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
<button type="button" class="btn btn-info" id="nueva_documento">Nuevo Documento</button>
{{--@if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
    <a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">
        Ficha PDF
    </a>
@endif--}}

<br><br>
<div class="row">
    <div class="col-md-12">
        <h4 class="titulo1">Documentos HV</h4>
        <div class="table-responsive">
            <table class="table table-bordered data-table" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Tipo Documento</th>
                        <th>Fecha Vencimiento</th>
                        <th>Archivo</th>
                        <th>Ultima modificación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentos as $documento)
                        <tr>
                            <td>{{$documento->tipo_doc}}</td>
                            <td>
                                @if ($documento->fecha_vencimiento != null && $documento->fecha_vencimiento != '' && $documento->fecha_vencimiento != '0000-00-00')
                                    {{ $documento->fecha_vencimiento }}
                                @else
                                    No aplica
                                @endif
                            </td>
                            <td><a href="{{url('recursos_documentos/'.$documento->nombre_archivo)}}" target="_blank">Archivo</a></td>
                            <td>{{$documento->updated_at}}</td>
                            <td>
                                @if($documento->diferencia_dias >= 0 || $documento->fecha_vencimiento == '0000-00-00')
                                    <?php
                                        $doc_verificado = $documento_verificados->where('documento_id_asociado', $documento->id)->first();
                                    ?>
                                    @if (is_null($doc_verificado))
                                        <a class="btn btn-success documento_gestionado_hv" data-tipo="{{$documento->tipo_doc}}" data-fecha="{{$documento->fecha_vencimiento}}" data-documento="{{$documento->id}}" data-req="{{$candidato->requerimiento_id}}">Verificar documento</a>
                                    @else
                                        <div class="badge badge-over">
                                            <span>Verificado</span>
                                        </div>
                                    @endif
                                @else
                                    <a class="btn btn-danger">Documento vencido</a>    
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@if (count($documento_verificados) > 0)
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <h4 class="titulo1">Documentos Verificados</h4>
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead style="text-align: center;">
                        <tr>
                            <th>Tipo Documento</th>
                            <th>Fecha Vencimiento</th>
                            <th>Archivo</th>
                            <th>Ultima modificación</th>
                            <th>Requerimientos</th>
                            <th>Observación</th>
                            <th>Resultado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documento_verificados as $documento)
                            @if($documento->nombre_archivo)
                                <?php
                                    $proceso_requerimientos = $documento->getRequerimientos();
                                    $proceso_req = $proceso_requerimientos->where('requerimiento_id', $candidato->requerimiento_id)->first();
                                ?>
                                <tr>
                                    <td>{{$documento->tipo_doc}}</td>
                                    <td>
                                        @if ($documento->fecha_vencimiento != null && $documento->fecha_vencimiento != '' && $documento->fecha_vencimiento != '0000-00-00')
                                            {{ $documento->fecha_vencimiento }}
                                        @else
                                            No aplica
                                        @endif
                                    </td>
                                    <td><a href="{{url('recursos_documentos_verificados/'.$documento->nombre_archivo)}}" target="_blank">Archivo</a></td>
                                    <td>{{$documento->updated_at}}</td>
                                    <td>
                                        @foreach($proceso_requerimientos as $req)
                                            <div class="badge badge-over">
                                                <span>Req:{{$req->requerimiento_id}}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($proceso_req != null && $proceso_req->observacion != null)
                                            {!! $proceso_req->observacion !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($proceso_req != null && $proceso_req->resultado != null)
                                            @if ($proceso_req->resultado == '1')
                                                Apto
                                            @else
                                                No apto
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($documento->fecha_vencimiento != "0000-00-00")
                                            @if($documento->diferencia_dias >= 0)
                                                @if(!in_array($documento->id,$req_prueba_gestionado))
                                                    <a class="btn btn-success documento_utilizado" data-tipo="{{$documento->tipo_doc}}" data-fecha="{{$documento->fecha_vencimiento}}" data-documento="{{$documento->id}}" data-req="{{$candidato->requerimiento_id}}">Verificar documento</a>
                                                @else
                                                    <div class="badge badge-over">
                                                        <span>Verificado</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span style="" class="badge badge-warning">Documento vencido</span>  
                                            @endif
                                        @else
                                            @if(!in_array($documento->id,$req_prueba_gestionado))
                                                <a class="btn btn-success documento_utilizado" data-tipo="{{$documento->tipo_doc}}" data-fecha="" data-documento="{{$documento->id}}" data-req="{{$candidato->requerimiento_id}}">Verificar documento</a>
                                            @else
                                                <div class="badge badge-over">
                                                    <span>Verificado</span>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
@endif

    <div class="modal fade" id="verificarDocumentoSeleccion" tabindex="-1" role="dialog" aria-labelledby="verificarDocumentoSeleccion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Documento a verificar</h4>
                </div>

                <div class="modal-body">
                    <form id="fr_documento_seleccion_verificar">
                        <input type="hidden" id="req_id_verificar">
                        <input type="hidden" id="documento_id_verificar">

                        <div class="col-md-12 form-group">
                            <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:</label>
                            <div class="col-md-6"> 
                                <label id="tipo_documento_seleccion"></label>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="resultado_verificar" class="col-md-4 control-label">Resultado:<span class='text-danger sm-text-label'>*</span> </label>
                            <div class="col-md-6">
                                {!! Form::select("resultado_verificar", [""=>"Seleccione",1=>"Apto", 2=>"No apto"], null,["class"=>"form-control","id"=>"resultado_verificar", "required" => "required"]) !!}
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="observacion_verificar" class="col-md-4 control-label">Observación:<span class='text-danger sm-text-label'>*</span> </label>
                            <div class="col-md-6">
                                {!! Form::textarea("observacion_verificar", null, ["class"=>"form-control", "id"=>"observacion_verificar", "rows"=>"4", "required" => "required"]); !!}
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="fecha_vencimiento" class="col-md-4 control-label">Fecha Vencimiento:</label>
                            
                            <div class="col-md-6">
                                <label id="fecha_vencimiento_verificar"></label>
                            </div>
                        </div>
                    </form>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="verificar_documento_seleccion">Guardar</button>
                    <button type="button" class="btn btn-success" id="reutilizar_documento_seleccion">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .badge-warning {
  background-color: #dd4b39;
}
</style>

<script>
    $(function () {
        var ruta = "{{route('admin.gestion_requerimiento',$candidato->requerimiento_id)}}";

        $('.data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
        });

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
                url: "{{ route('admin.nuevo_documento',['ref_id'=>$candidato->ref_id]) }}",
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
                    window.location.href = '{{ route("admin.gestionar_documentos",[$candidato->ref_id]) }}'
                } else {
                    $("#modal_peq").find(".modal-content").html(res.view);
                }

            });
        });

        $(".documento_utilizado").on("click", function () {
            var documento = $(this).data("documento");
            var req = $(this).data("req");
            var tipo_doc = $(this).data("tipo");
            var fecha_ven = $(this).data("fecha");
            if (fecha_ven == '0000-00-00') {
                fecha_ven = '';
            }

            $('#documento_id_verificar').val(documento);
            $('#req_id_verificar').val(req);
            $('#tipo_documento_seleccion').text(tipo_doc);
            $('#fecha_vencimiento_verificar').text(fecha_ven);

            $('#verificar_documento_seleccion').hide();
            $('#reutilizar_documento_seleccion').show();

            $('#verificarDocumentoSeleccion').modal('show');
        });

        $("#reutilizar_documento_seleccion").on("click", function () {
            if ($('#fr_documento_seleccion_verificar').smkValidate()) {
                $(this).prop("disabled", true);
                var documento = $('#documento_id_verificar').val();
                var req = $('#req_id_verificar').val();
                var obs = $('#observacion_verificar').val();
                var resul = $('#resultado_verificar').val();

                $.ajax({
                    type: "POST",
                    data: {
                        ref_id: "{{$candidato->ref_id}}",
                        req_id: req,
                        doc_id: documento,
                        observacion: obs,
                        resultado: resul
                    },
                    url: "{{ route('admin.registra_documento_entidad') }}",
                    success: function (response) {
                        mensaje_success("Registro utilizado!!");
                        window.location.href = "{{ route('admin.gestionar_documentos',[$candidato->ref_id]) }}";
                    }
                });
            }
        });

        $(document).on("click", ".documento_gestionado_hv", function () {
            var documento = $(this).data("documento");
            var req = $(this).data("req");
            var tipo_doc = $(this).data("tipo");
            var fecha_ven = $(this).data("fecha");
            if (fecha_ven == '0000-00-00') {
                fecha_ven = '';
            }

            $('#documento_id_verificar').val(documento);
            $('#req_id_verificar').val(req);
            $('#tipo_documento_seleccion').text(tipo_doc);
            $('#fecha_vencimiento_verificar').text(fecha_ven);

            $('#verificar_documento_seleccion').show();
            $('#reutilizar_documento_seleccion').hide();

            $('#verificarDocumentoSeleccion').modal('show');
        });

        $("#verificar_documento_seleccion").on("click", function () {
            if ($('#fr_documento_seleccion_verificar').smkValidate()) {
                $(this).prop("disabled", true);
                var documento = $('#documento_id_verificar').val();
                var req = $('#req_id_verificar').val();
                var obs = $('#observacion_verificar').val();
                var resul = $('#resultado_verificar').val();

                $.ajax({
                    type: "POST",
                    data: {
                        ref_id: "{{$candidato->ref_id}}",
                        req_id: req,
                        documento_id: documento,
                        observacion: obs,
                        resultado: resul
                    },
                    url: "{{ route('admin.agrega_doc_gestion') }}",
                    success: function () {
                        mensaje_success("Documento Verificado!!");
                        window.location.href = "{{ route('admin.gestionar_documentos',[$candidato->ref_id]) }}";
                    }
                });
            }
        });

        $(document).on("change", "#tipo_documento", function () {
            $("#descripcion_documento").val($("#tipo_documento").find("option:selected").text())
        });
    });
</script>
@stop