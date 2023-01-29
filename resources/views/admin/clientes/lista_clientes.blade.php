@extends("admin.layout.master")
@section("contenedor")

{{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Lista de clientes"])

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.lista_clientes","method"=>"GET"]) !!}

<div class="col-md-6">

  <div class="form-group">
        <label for="inputEmail3" class="control-label">Nombre Cliente:</label>
        {!! Form::text("nombre",null,["class"=>"form-control s-select-2-basic | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nombre"]); !!}
  </div>
    
</div>
<div class="col-md-6">
  <div class="form-group">
      @if(route("home")=="https://gpc.t3rsc.co")
        <label for="inputEmail3" class="control-label">RUC:</label>
      @else
        <label for="inputEmail3" class="control-label">Nit:</label>
      @endif
      {!! Form::text("nit",null,["class"=>"form-control solo-numero tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nit"]); !!}
  </div>
</div>
  
<div class="col-md-12 text-right">
  <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green">
                Buscar <i class="fa fa-search" aria-hidden="true"></i>
  </button>

  <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{ route('admin.lista_clientes') }}">Limpiar</a>
</div>

{!! Form::close() !!}

<div class="col-md-12 mt-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive ">
                    <table class="table table-striped table-hover text-center">
                      <thead>
                        @if(route("home")=="https://gpc.t3rsc.co")
                          <th>RUC</th>
                        @else
                          <th>Nit</th>
                        @endif
                        <th>Clientes</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Ubicación</th>
                        <th>Acción</th>
                      </thead>
                      <tbody>
                      @foreach($clientes as $cliente)
                          <tr>
                              {{--<td>
                              {!! Form::checkbox("cliente_id[]",$cliente->id,null,["data-url"=>route('admin.editar_cliente',["cliente_id"=>$cliente->id])]) !!}
                              </td>--}}
                              <td>{{$cliente->nit}}</td>
                              <td>{{$cliente->nombre}}</td>
                              <td>{{$cliente->direccion}}</td>
                              <td>{{$cliente->telefono}}</td>
                              <td>{{$cliente->getUbicacion()->value}}</td>
                              <td>
                                  <a class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple" href="{{route('admin.editar_cliente',['cliente_id'=>$cliente->id])}}">
                                    Editar <i class="fa fa-pen" aria-hidden="true"></i>
                                  </a>
                                  @if($eliminar)
                                    <a class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple" href="{{route('admin.eliminar_cliente',['id'=>$cliente->id])}}">Eliminar Cliente</a>
                                  @endif
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

{!! $clientes->appends(Request::all())->render() !!}

<script>
    $(function () {

       $("#eliminar-c").on("click", function () {
        
         var checks = $("input[name='cliente_id[]']:checked").val();
         var url = $(this).data('url');
         //console.log(checks);
                
          if(checks.length == 0) {

            mensaje_success("Debe seleccionar un item de la tabla.");
            
          }else{

            // var valor = checks.value();
            $.ajax({
                type: "GET",
                url:url+'/'+checks,
                success: function (response) {
                  mensaje_success("Registro Eliminado");

                 $("input[name='cliente_id[]']:checked").parent('td').parent('tr').remove();    
                
          }
            });

           }
        });

    });

</script>

@stop