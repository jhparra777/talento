@extends("admin.layout.master")
@section('contenedor')
    <h3>Candidatos a Pruebas de Excel {{ $tipo }}</h3>

    @if(session()->has('mensaje_danger'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {{ session()->get('mensaje_danger') }}
                </div>
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["id" => "{{ $ruta_listado }}", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="req_id" class="col-sm-4 control-label"># Requerimiento:</label>
                <div class="col-sm-8">
                    {!! Form::text("req_id", null, ["class" => "form-control solo-numero", "placeholder" => "# Requerimiento", "id" => "req_id"]); !!}
                </div>
            </div>

            <div class="col-md-6  form-group">
                <label for="cedula" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Identificación", "id" => "cedula"]); !!}
                </div>
            </div>
        </div>

        <button class="btn btn-warning" >
            <span class="glyphicon glyphicon-search"></span> Buscar
        </button>

        <a class="btn btn-warning" href="{{ route('admin.pruebas_excel_basico') }}">
            <span class="glyphicon glyphicon-trash"></span> Limpiar
        </a>

        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Prueba</a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Requerimiento</th>
                    <th>Ciudad</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Fecha Respuesta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidatos as $candidato)
                    <tr>
                        <td>
                            {!! Form::checkbox("ref_id[]", $candidato->ref_id, null, ["data-url" => route($ruta_gestion, ["ref_id" => $candidato->ref_id])]) !!}
                        </td>
                        <td>{{ $candidato->requerimiento_id }}</td>
                        <td>{{ $candidato->getUbicacionReq() }}</td>
                        <td>{{ $candidato->numero_id }}</td>
                        <td>{{ $candidato->fullname() }}</td>
                        <td>
                            @if ($candidato->fecha_respuesta != '' && $candidato->fecha_respuesta != null)
                                {{ $candidato->fecha_respuesta }}
                            @else
                                Prueba sin respuesta
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"> No se encontraron registros</td>
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