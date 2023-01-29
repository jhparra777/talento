@extends("admin.layout.master")
@section("contenedor")
    <style>
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }
    </style>

    <h3>Lista de citas</h3>

    {!! Form::model(Request::all(), ["route" => "admin.gestionar_citas", "method" => "GET"]) !!}
        <div class="form-group">
            <div class="col-md-6">
                <label for="nombre_clausula">Número req</label>
                {!! Form::number("num_req", null, ["class" => "form-control", "id" => "num_req", "placeholder" => "Número requerimiento"]); !!}
            </div>
        </div>

        <div class="col-md-12 mt-2 text-left">
            <button type="submit" class="btn btn-info" id="buscar_clausulas">Buscar <i class="fa fa-search"></i></button>
            <a href="{{ route('admin.gestionar_citas') }}" class="btn btn-warning">Limpiar</a>
        </div>
    {!! Form::close() !!}

    <div class="mt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Número requerimiento</th>
                    <th>Cargo</th>
                    <th>Asunto cita</th>
                    <th>Estado cita</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lista_citas as $lista)
                    <tr>
                        <td>{{ $lista->req_id }}</td>
                        <td>{{ $lista->cargo }}</td>
                        <td>{{ $lista->asunto_cita }}</td>
                        <td>{{ ($lista->estado_cita == 1) ? 'Activa' : 'Cancelada' }}</td>
                        <td>
                            <a href="{{ route('admin.gestionar_citas_detalle', [$lista->id]) }}" class="btn btn-primary">
                                Gestionar cita
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No se encontraron registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {!!  $lista_citas->appends(Request::all())->render() !!}
@stop