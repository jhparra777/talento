@extends("admin.layout.master")
@section('contenedor')
    <h3>Candidatos a Pruebas de {{ $tipo }}</h3>

    @if(session()->has('mensaje_danger'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {{ session()->get('mensaje_danger') }}
                </div>
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="req_id" class="control-label">Número de Requerimiento:</label>
                {!! Form::text("req_id", null, ["class" => "form-control solo-numero", "placeholder" => "Número de Requerimiento", "id" => "req_id"]); !!}
            </div>

            <div class="col-md-6  form-group">
                <label for="cedula" class="control-label">Número de Identificación:</label>
                {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "Número de Identificación", "id" => "cedula"]); !!}
            </div>
        </div>

        <button class="btn btn-info" >
            <span class="glyphicon glyphicon-search"></span> Buscar
        </button>

        <a class="btn btn-warning" href="{{ route('admin.pruebas_valores_1') }}">
            <span class="glyphicon glyphicon-trash"></span> Limpiar
        </a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Requerimiento</th>
                    <th>Ciudad</th>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Fecha Respuesta</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidatos as $candidato)
                    <tr>
                        <td>{{ $candidato->requerimiento_id }}</td>
                        <td>{{ $candidato->getUbicacionReq() }}</td>
                        <td>{{ $candidato->fullname() }}</td>
                        <td>{{ $candidato->numero_id }}</td>
                        <td>
                            @if($candidato->fecha_respuesta != '')
                                {{ $candidato->fecha_respuesta }}
                            @else
                                Prueba sin responder
                            @endif
                        </td>
                        <td>
                            <a href="{{ route($ruta_gestion, [$candidato->ref_id]) }}" class="btn btn-primary">Gestionar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"> No se encontraron registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="col-md-12">
            <div class="showing" style="text-align: center;">
                {!! $candidatos->appends(Request::all())->render() !!}
            </div>                    
        </div>
    </div>
@stop