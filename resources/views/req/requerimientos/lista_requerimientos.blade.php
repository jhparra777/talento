@extends("req.layout.master")
@section('contenedor')
    <h3>Gestión Requerimientos</h3>

    {!!Form::model(Request::all(), ["route" => "req.lista_requerimientos", "method" => "GET"]) !!}
        
        @include('admin.requerimientos.includes._inputs_buscar_editar_requerimiento')

        <a class="btn btn-info" href="{{ route("req.lista_requerimientos") }}">Limpiar</a>
    
    {!! Form::close() !!}
    
    <br>

    @include('admin.requerimientos.includes._table_editar_requerimientos', ['modulo' => 'req'])

@stop
