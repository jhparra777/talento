@extends("admin.layout.master")
@section("contenedor")

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Negocios"])

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
    @endif

    @if(Session::has("mensaje_error"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_error")}}
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <a class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right" href="{{ route("admin.nuevo_negocio") }}" >Nuevo Negocio <i class='fa fa-plus' aria-hidden='true'></i></a>
        <br>
    </div>

    {!! Form::model(Request::all(),["id"=>"admin.negocio_cliente","method"=>"GET"]) !!}

        <div class="col-md-6 ">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">Número negocio:</label>
                
                    {!! Form::text("negocio_id",null,["class"=>"form-control tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("negocio_id",$errors) !!}</p> 
            </div>   

        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">Nit:</label>
               
                    {!! Form::text("nit",null,["class"=>"form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nit"]); !!}
               
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
            </div>
        </div>

        <div class="col-md-6" id="filtro">
            <div class="form-group">
                <label for="inputEmail3">Cliente:</label>
            
                {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cliente_id" ]); !!}
            </div>
            
        </div>
        {{--<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">Nombre Cliente:</label>
                
                    {!! Form::text("nombre",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nombre"]); !!}
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
            </div>
        </div>--}}

        

        <div class="col-md-12 text-right">
            <button class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" >Buscar</button>
        
            <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route("admin.negocio_cliente")}}" >Limpiar</a>

        </div>

        
        <div class="clearfix"></div>
        <br>

    {!! Form::close() !!}
     <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                    
                        <th># negocio</th>
                        <th>Nit</th>
                        <th>Clientes</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Ciudad Negocio</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @if($negocios ->count() == 0)
                        <tr>
                            <td colspan="6">No se encontraron negocios.</td>
                        </tr>
                    @endif
                    @foreach($negocios as $negocio)
                        <tr>
                            
                            <td>{{$negocio->num_negocio}}</td>
                            <td>{{$negocio->nit}}</td>
                            <td>{{$negocio->nombre}}</td>
                            <td>{{$negocio->direccion}}</td>
                            <td>{{$negocio->telefono}}</td>
                            <td>{{$negocio->getUbicacion()->value}}</td>
                            <td>
                                <div class="btn-group-vertical">

                                    <a class="btn btn-default btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"  href="{{ route("admin.editar_negocio", ["negocio_id" => $negocio->negocio_id]) }}">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Editar
                                    </a>
                                    @if($user->hasAccess('admin.nuevo_centro_costo'))
                                        <a class="btn btn-info | btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{ route("admin.nuevo_centro_costo",['negocio_id'=>$negocio->negocio_id]) }}" >Nuevo Centro Costos +</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $negocios->appends(Request::all())->render() !!}
@stop