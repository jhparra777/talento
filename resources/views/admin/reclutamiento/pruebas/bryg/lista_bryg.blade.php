@extends("admin.layout.master")
@section("contenedor")
    <style>
        .m-0{ margin: 0; }
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }

        .pd-0{ padding: 0; }
        .pd-05{ padding: 0.5rem; }
        .pd-1{ padding: 1rem; }
        .pd-2{ padding: 2rem; }
        .pd-3{ padding: 3rem; }
        .pd-4{ padding: 4rem; }
    </style>

    <div class="row">
        <div class="col-md-12 mb-2">
            <h3>Lista de pruebas BRYG-A</h3>
        </div>

        {!! Form::model(Request::all(), ["route" => "admin.pruebas_bryg", "method" => "GET"]) !!}
            <div class="form-group">
                <div class="col-md-6">
                    <label for="requerimiento">Número REQ</label>
                    {!! Form::number("requerimiento", null, [
                        "class" => "form-control",
                        "id" => "requerimiento",
                        "placeholder" => "Buscar por requerimiento"
                    ]); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <label for="cedula">Cédula</label>
                    {!! Form::number("cedula", null, [
                        "class" => "form-control",
                        "id" => "cedula",
                        "placeholder" => "Buscar por cédula"
                    ]); !!}
                </div>
            </div>

            <div class="col-md-12 mt-2 text-left">
                <button type="submit" class="btn btn-info" id="buscar_pruebas_bryg">Buscar <i class="fa fa-search"></i></button>
                <a href="{{ route('admin.pruebas_bryg') }}" class="btn btn-warning">Limpiar</a>
            </div>
        {!! Form::close() !!}
    </div>

    <div class="mt-2">
        <table class="table table-striped">
            <thead>
                <th>Número REQ</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Fecha realización</th>
                <th>Proceso</th>
                <th>Acción</th>
            </thead>
            <tbody>
                @forelse ($lista_bryg as $lista)
                    <tr>
                        <td>{{ $lista->req_id }}</td>
                        <td>{{ $lista->nombre_completo }}</td>
                        <td>{{ $lista->cedula }}</td>
                        <td>
                            @if(!empty($lista->fecha_realizacion))
                                {{ $lista->fecha_realizacion }}
                            @else
                                Prueba sin responder
                            @endif
                        </td>
                        <td>ENVIO_PRUEBA_BRYG</td>
                        <td>
                            <a href="{{ route("admin.pruebas_bryg_gestion", [$lista->prueba_id]) }}" class="btn btn-primary">Gestionar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No se encontraron registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {!!  $lista_bryg->appends(Request::all())->render() !!}
@stop