@extends("admin.layout.master")
@section('contenedor')
    <h3>Candidatos a Pruebas</h3>

    {!! Form::model(Request::all(), ["id" => "admin.pruebas", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Requerimiento:</label>
                <div class="col-sm-8">
                    {!! Form::text("codigo", null, ["class" => "form-control solo-numero", "placeholder" => "# Requerimiento"]); !!}
                </div>
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Identificación"]); !!}
                </div>
            </div>
        </div>

        <button class="btn btn-warning" >
            <span class="glyphicon glyphicon-search"></span> Buscar
        </button>

        <a class="btn btn-warning" href="{{route("admin.pruebas")}}" >
            <span class="glyphicon glyphicon-trash"></span> Limpiar
        </a>

        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Pruebas</a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td></td>
                    <td>Requerimiento</td>
                    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                        <td>Sede</td>
                    @else
                        <td>Ciudad</td>
                    @endif
                    <td>Cédula</td>
                    <td>Nombre</td>
                    <td>Estado</td>
                </tr>
            </thead>
            <tbody>
                @if($candidatos->count() == 0)
                    <tr>
                        <td colspan="4"> No se encontraron registros</td>
                    </tr>
                @endif

                @if(route('home') == "http://soluciones3.t3rsc.co")
                    @foreach($candidatos as $candidato)
                        <tr>
                            <td>
                                {!! Form::checkbox("ref_id[]",$candidato->ref_id, null, ["data-url" => route('admin.gestionar_prueba', ["ref_id" => $candidato->ref_id])]) !!}
                            </td>
                            <td>{{ $candidato->requerimiento_id }}</td>
                            @if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                                <td>{{ $candidato->descripcion }}</td>
                            @else
                                <td>{{ $candidato->getUbicacionReq() }}</td>
                            @endif
                            <td>{{ $candidato->numero_id }}</td>
                            <td>{{ $candidato->nombres }}</td>
                            <td>{{ $candidato->proceso }}</td>
                        </tr>
                    @endforeach
                @else
                    @foreach($candidatos as $candidato)
                        <tr>
                            <td>
                                {!! Form::checkbox("ref_id[]", $candidato->ref_id, null, ["data-url" => route('admin.gestionar_prueba', ["ref_id" => $candidato->ref_id])]) !!}
                            </td>
                            <td>{{ $candidato->requerimiento_id }}</td>
                            @if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                                <td>{{ $candidato->descripcion }}</td>
                            @else
                                <td>{{ $candidato->getUbicacionReq() }}</td>
                            @endif
                            <td>{{ $candidato->numero_id }}</td>
                            <td>{{ $candidato->fullname() }}</td>
                            <td>{{ $candidato->proceso }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="col-md-12">
            <div class="showing" style="text-align: center;">
                {!! $candidatos->appends(Request::all())->render() !!}
            </div>                    
        </div>
    </div>
@stop