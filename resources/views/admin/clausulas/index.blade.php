@extends("admin.layout.master")
@section("contenedor")
    <div class="row">
        <div class="col-md-12 mb-2">
            <h3>Lista de cláusulas</h3>
        </div>

        {!! Form::model(Request::all(), ["route" => "admin.clausulas.lista", "method" => "GET"]) !!}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre_clausula">Nombre cláusula</label>
                    {!! Form::text("nombre_clausula", null, ["class" => "form-control", "id" => "nombre_clausula", "placeholder" => "Nombre de la cláusula"]); !!}
                </div>
            </div>

            <div class="col-md-12 mt-1 mb-3 text-right">
                <button type="submit" class="btn btn-info" id="buscar_clausulas">Buscar <i class="fa fa-search"></i></button>
                <a href="{{ route('admin.clausulas.lista') }}" class="btn btn-warning">Limpiar</a>
                <a href="{{ route('admin.clausulas.crear') }}" class="btn btn-primary">Nueva cláusula <i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
        {!! Form::close() !!}

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-responsive table-border">
                        <thead>
                            <tr>
                                <th>Nombre cláusula</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($lista_cargos) <= 0)
                                <tr>
                                    <td colspan="3">No se encontraron registros</td>
                                </tr>
                            @endif
            
                            @foreach ($lista_cargos as $lista)
                                <tr>
                                    <td>{{ $lista->nombre_clausula }}</td>
                                    <td>{{ ($lista->estado_clausula == 1) ? 'Activa' : 'Inactiva' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.clausulas.editar', [$lista->adicional_id]) }}" class="btn btn-primary">Editar cláusula</a>
            
                                        <a href="{{ route('admin.clausulas.asociar_cargos', [$lista->adicional_id]) }}" class="btn btn-primary">Asociar cargos</a>
            
                                        <a href="{{ route('admin.visualizar_clausula', [$lista->adicional_id]) }}" class="btn btn-primary" target="_blank">Visualizar cláusula <i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {!!  $lista_cargos->appends(Request::all())->render() !!}
    </div>
@stop