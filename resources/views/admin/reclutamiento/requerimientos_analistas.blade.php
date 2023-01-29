@extends("admin.layout.master")
@section('contenedor')
<h3>Requerimientos</h3>

{!! Form::model(Request::all(),["route"=>"admin.reclutamiento","method"=>"GET"]) !!}

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">@if(route('home')=="https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif:</label>
    <div class="col-sm-10">
        {!! Form::text("num_req",null,["class"=>"form-control" ]); !!}
    </div>
</div>
@if(route('home')!="http://localhost/desarrollo-T3RS/public")
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Clientes:</label>
    <div class="col-sm-10">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
    </div>
</div>
@else
  <div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Areas:</label>
    <div class="col-sm-10">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
    </div>
</div>
@endif

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Cedula:</label>
    <div class="col-sm-10">
        {!! Form::text("cedula",null,["class"=>"form-control" ]); !!}
    </div>
</div>

<div class="clearfix"></div>
{!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
<a class="btn btn-danger" href="{{route("admin.reclutamiento")}}">Limpiar</a>
{!! Form::close() !!}
<br>



<div class="clearfix"></div>
<div class="tabla table-responsive">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th>@if(route('home')=="https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>Sub-área</th>
                <th>Sede</th>
                <th>Vacantes</th>
                <th>Fecha Oportuna</th>
                <th>Dias gestión</th>
                <th>Estado</th>
                  @if(route('home')=="http://vym.t3rsc.co") 
                <th># Aplicaciones</th>
                  @endif 
                <th>Tarea</th>
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
                 <td>{{$requerimiento->cargo}}</td>
                <td>{{$requerimiento->solicitud->area->descripcion}}</td>

                <td>{{$requerimiento->solicitud->subarea->descripcion}}</td>
                 <td>{{$requerimiento->solicitud->sede->descripcion}}</td>
                <td style="text-align: center;">{{$requerimiento->num_vacantes}}</td>
                <td>{{$requerimiento->fecha_ingreso}}</td>
                <td style="text-align: center;">{{$requerimiento->dias_gestion}}</td>
                
                <td>{{$requerimiento->estadoRequerimiento()->estado_nombre}}</td>
                 @if(route('home')=="http://vym.t3rsc.co") 
                  @if($requerimiento->numeroAplicados() !=0)
                   <td style="text-align: center;">
                    {{$requerimiento->numeroAplicados()}}
                </td>
                @else
                <td style="text-align: center;">
                    No tiene aplicantes
                </td>
                    
                  @endif
               
                  @endif 
                @if($requerimiento->estadoRequerimiento()->estado_id!=22 and $requerimiento->estadoRequerimiento()->estado_id!= 2 and $requerimiento->estadoRequerimiento()->estado_id!= 1 and $requerimiento->estadoRequerimiento()->estado_id!= 16 and $requerimiento->estadoRequerimiento()->estado_id!= 19 )
                <td>
                     
                    <a class="btn btn-warning btn-sm" href="{{route("admin.gestion_requerimiento",["req_id"=>$requerimiento->req_id])}}">Gestionar</a></td>

                </td>
                @else
                 <td> CERRADO</td>
                @endif
                
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div>
    {!! $requerimientos->appends(Request::all())->render() !!}
</div>

<script type="text/javascript">

    $(function () {
   $(document).on("click",".asignar_psicologo", function () {

        var req_id = $(this).data("req_id");
        var cliente_id = $(this).data("cliente_id");
            $.ajax({
                data: {req_id: req_id, cliente_id: cliente_id},
                url: "{{route('admin.asignar_psicologo')}}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        }); 
   
    $(document).on("click", "#guardar_asignacion", function () {
            $(this).prop("disabled", false)
            
            $.ajax({
                type: "POST",
                data: $("#fr_asig").serialize(),
                url: "{{ route('admin.asignar_psicologo_guardar')}}",
                success: function(response) {

                    if(response.success){
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                         mensaje_success("Asignación realizada");
                         location.reload();
                     }else{

                         //alert('lol')
                     $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                     mensaje_danger("Ya se le hizo la asignación al analista");
                     }
                }


               

            });


        });


   });
 
</script>


@stop