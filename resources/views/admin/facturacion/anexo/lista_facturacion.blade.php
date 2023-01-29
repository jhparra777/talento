@extends("admin.layout.master")
@section('contenedor')
<h3>Gestionar Facturación</h3>

{!! Form::model(Request::all(),["route"=>"admin.facturacion_anexo","method"=>"GET"]) !!}

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-12 control-label">Número Requerimiento:</label>
    <div class="col-sm-12">
        {!! Form::text("num_req",null,["class"=>"form-control" ]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-12 control-label">Clientes:</label>
    <div class="col-sm-12">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
    </div>
</div>

<div class="clearfix"></div>
{!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
<a class="btn btn-danger" href="{{route("admin.facturacion_anexo")}}">Limpiar</a>
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
                <th>Fecha Inicio</th>
                <th>Estado</th>
                <th></th>
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
                <td>{{$requerimiento->req_id}}</td>
                <td>{{$requerimiento->nombre_cliente}}</td>
                <td>{{$requerimiento->tipo_proceso_desc}}</td>
                <td>{{$requerimiento->num_vacantes}}</td>
                <td>{{$requerimiento->created_at}}</td>
                <td>
                    {{ \App\Models\Facturacion::estadoFacturacion($requerimiento->req_id) }}
                </td>
                <td>
                    @if(\App\Models\Facturacion::estadoFacturacion($requerimiento->req_id) == "Terminado")
                        FACTURADO / TERMINADO
                    @else
                        {!! Form::hidden("req_id",$requerimiento->req_id, ["id"=>"req_id"]) !!}
                        <button class="btn btn-small btn-warning facturar">FACTURAR</button>
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
<script type="text/javascript">

    $(document).on("click",".facturar", function() {
        var objButton = $(this);
        id = objButton.parent().find("input").val();
        if(id){
            $.ajax({
                type: "POST",
                data: {"req_id":id},
                url: "{{ route('admin.facturar_requerimiento') }}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        }else
        {
            mensaje_danger("Problemas al obtener el id del requerimiento, intentar nuevamente.");
        }
    });

    $(document).on("click","#guardar_factura_requerimiento", function() {
        $.ajax({
            type: "POST",
            data: $("#fr_facturacion").serialize(),
            url: "{{route('admin.ajax_guardar_facturacion_requerimiento')}}",
            success: function (response) {
                //Busca todos los input y lo pone a su color original
                $(document).ready(function(){
                    $("input").css({"border": "1px solid #ccc"});
                    $("select").css({"border": "1px solid #ccc"});
                    $("textarea").css({"border": "1px solid #ccc"});
                    $(".text").remove();
                  });
                mensaje_success(response.mensaje);
                location.reload(true);
            },
            error:function(response){
                $(document).ready(function(){
                    $("input").css({"border": "1px solid #ccc"});
                    $("select").css({"border": "1px solid #ccc"});
                    $("textarea").css({"border": "1px solid #ccc"});
                    $(".text").remove();
                });

                $.each(response.responseJSON, function(index, val){
                    $('input[name='+index+']').after('<span class="text">'+val+'</span>');
                    $('textarea[name='+index+']').after('<span class="text">'+val+'</span>');
                    $('select[name='+index+']').after('<span class="text">'+val+'</span>');
                    document.getElementById(index).style.border = 'solid red';
                });
                //mensaje_danger("Problemas al guardar la facturación");
            } 
        });
    });

    $(document).on("click","#actualizar_factura_requerimiento", function() {
        $.ajax({
            type: "POST",
            data: $("#fr_facturacion").serialize(),
            url: "{{route('admin.ajax_actualizar_facturacion_requerimiento')}}",
            success: function (response) {
                //Busca todos los input y lo pone a su color original
                $(document).ready(function(){
                    $("input").css({"border": "1px solid #ccc"});
                    $("select").css({"border": "1px solid #ccc"});
                    $("textarea").css({"border": "1px solid #ccc"});
                    $(".text").remove();
                  });
                mensaje_success(response.mensaje);
                location.reload(true);
            },
            error:function(response){
                $(document).ready(function(){
                    $("input").css({"border": "1px solid #ccc"});
                    $("select").css({"border": "1px solid #ccc"});
                    $("textarea").css({"border": "1px solid #ccc"});
                    $(".text").remove();
                });

                $.each(response.responseJSON, function(index, val){
                    $('input[name='+index+']').after('<span class="text">'+val+'</span>');
                    $('textarea[name='+index+']').after('<span class="text">'+val+'</span>');
                    $('select[name='+index+']').after('<span class="text">'+val+'</span>');
                    document.getElementById(index).style.border = 'solid red';
                });
                //mensaje_danger("Problemas al actualizar la facturación");
            } 
        });
    });
</script>


@stop