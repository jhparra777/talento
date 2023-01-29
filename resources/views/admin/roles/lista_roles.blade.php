@extends("admin.layout.master")
@section('contenedor')
{{-- Header --}}
@include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Roles"])

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif


{!! Form::model(Request::all(),["id"=>"admin.lista_roles","method"=>"GET"]) !!}
<div class="col-md-6">
    <div class="form-group">
        <label for="inputEmail3" class="control-label">Nombre:</label>
        
            {!! Form::text("name",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nombre"]); !!}
       
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
    </div>
</div>


<div class="col-md-12 text-right">
    <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green" >Buscar
        <i class="fa fa-search" aria-hidden="true"></i>
    </button>
    <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{route("admin.lista_roles")}}" >Limpiar</a>
    
</div>
{!! Form::close() !!}
  <div class="col-md-12 mt-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive ">
                    <div class="table-responsive ">


                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($lista_roles as $rol)
                                <tr>
                                    
                                    <td>{{$rol->name}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"  href="{{ route('admin.editar_rol', ['rol_id' => $rol->id]) }}">
                                            Editar rol <i class="fa fa-pen" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! $lista_roles->appends(Request::all())->render() !!}
@stop