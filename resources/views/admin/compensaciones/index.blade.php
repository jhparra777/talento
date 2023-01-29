@extends("admin.layout.master")
@section('contenedor')

<h3>Gestión compensación</h3>

{!! Form::model(Request::all(),["route"=>"admin.lista_requerimientos","method"=>"GET"]) !!}

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label"># Req:</label>
    <div class="col-sm-10">
        {!! Form::text("num_req",null,null,["class"=>"form-control" ]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label ">Clientes:</label>
    <div class="col-sm-10">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label ">Agencia:</label>
    <div class="col-sm-10">
        {!! Form::select("agencia",[""=>"Seleccionar"]+$agencias,null,["class"=>"form-control" ]); !!}

    </div>
</div>

<div class="clearfix"></div>
{!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
<a class="btn btn-danger" href="{{route("admin.lista_requerimientos")}}">Cancelar</a>
{!! FuncionesGlobales::valida_boton_req("admin.requerimientos_prioritarios","Priorizar requerimientos","link","btn btn-warning",[],"btn_pri_req") !!}
{!! Form::close() !!}
<br>

<div class="clearfix"></div>
<div class="tabla table-responsive">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr> 
                <th># Req</th>
                <th>Cliente</th>
                <th>Tipo Proceso</th>
                <th># Vacantes</th>
                <th># Asociados</th>
                <th># Contratados</th>
                <th>Fecha Tentativa</th>
                <th>Fecha Cancelación</th>
                <th>Agencia</th>
                <th>Estado</th>
                <th>Acción/observaciones</th>
            </tr>
        </thead>
        <tbody>
            @if($requerimientos->count() == 0)
            <tr>
                <td colspan="5">No se encontraron registros</td>
            </tr>
            @endif

            @foreach($requerimientos as $requerimiento)
            <tr>

                <td>{{$requerimiento->id}}</td>
                <td>{{$requerimiento->nombre_cliente}}</td>
                <td>{{$requerimiento->tipo_proceso_desc}}</td>
                <td>{{$requerimiento->num_vacantes}}</td>
                <td>{{ \App\Models\Requerimiento::countVacantesAsociados($requerimiento->id) }}</td>
                <td>{{ \App\Models\Requerimiento::countVacantesContratados($requerimiento->id) }}</td>
                <td>{{$requerimiento->fecha_ingreso}}</td>
                <td>{{$requerimiento->fecha_retiro}}</td>
                <td>{{$requerimiento->getUbicacion()->ciudad}}</td>
                <td>{{ $requerimiento->estadoRequerimiento()->estado_nombre }}</td>
                <td style="text-align: center;">
                    
                 
                    
                    @if(in_array($requerimiento->ultimoEstadoRequerimiento()->id,[config("conf_aplicacion.C_EN_PROCESO_SELECCION"),config("conf_aplicacion.C_EN_PROCESO_CONTRATACION"),config("conf_aplicacion.C_EVALUACION_DEL_CLIENTE"),config("conf_aplicacion.C_RECLUTAMIENTO")])) 
                    <a class="btn btn-warning" href="{{route("admin.editar_compensacion",["req_id"=>$requerimiento->req_id])}}">Compensar</a>
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div>
    {!! $requerimientos->appends(Request::all())->render() !!}
</div>

<script>
    $(function () {

        $(".estados_requerimiento").on("click", function () {
            var req_id = $(this).data("req");
            //alert(req_id);
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
                url: "{{route('admin.terminar_requerimiento')}}",
                success: function (response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        mensaje_success("Se ha terminado el requerimiento.");
                        window.location.href = '{{route("admin.lista_requerimientos")}}';
                    }else{

                     
                        $("#modal_peq").modal("hide");
                     mensaje_danger("El requerimiento está en proceso de contratación.");
                     
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
