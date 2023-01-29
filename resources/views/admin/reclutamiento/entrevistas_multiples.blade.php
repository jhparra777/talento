@extends("admin.layout.master")
@section('contenedor')
    <h3>Entrevistas Múltiples</h3>

    {!! Form::model(Request::all(), ["id" => "listado_entrevistas_multiples", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="requerimiento_id" class="col-sm-4 control-label">
                        # Requerimiento:
                </label>
                <div class="col-sm-8">
                    {!! Form::text("requerimiento_id", null, ["class" => "form-control solo-numero", "placeholder" => ""]); !!}
                </div>  
            </div>

            {{--<div class="col-md-6  form-group">
                <label for="cedula" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Cédula"]); !!}
                </div> 
            </div>--}}
        </div>

        <button class="btn btn-warning" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.entrevistas_multiples")}}" >Limpiar</a>
        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Entrevista Múltiple</a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td></td>
                    <td>Requerimiento</td>
                    @if(route("home") != "http://komatsu.t3rsc.co" || route("home") != "https://komatsu.t3rsc.co")
                        <td>Ciudad</td>
                    @endif
                    <td>Título entrevista</td>
                    <td>Descripción</td>
                    <td>Ver entrevista</td>
                </tr>
            </thead>
            <tbody>
                @if($entrevistas->count() == 0)
                    <tr>
                        <td colspan="4"> No se encontraron registros</td>
                    </tr>
                @endif

                @foreach($entrevistas as $entrevista)
                    <tr>
                        <td>
                            {!! Form::checkbox("ref_id[]", $entrevista->id, null, [
                                "data-url" => route('admin.gestionar_entrevista_multiple', ["ref_id" => $entrevista->id])
                            ]) !!}
                        </td>
                        <td>{{ $entrevista->req_id }}</td>

                        @if(route("home") != "http://komatsu.t3rsc.co" || route("home") != "https://komatsu.t3rsc.co")
                            <td>{{ $entrevista->requerimiento->ciudad_req() }}</td>
                        @endif

                        <td>{{ $entrevista->titulo }}</td>
                        <td>{{ $entrevista->descripcion }}</td>
                        <td><a href="{{url('entrevista-multiple/'.$entrevista->id)}}" target="_blank" class="btn btn-sm btn-info">PDF</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {!! $entrevistas->appends(Request::all())->render() !!}
@stop