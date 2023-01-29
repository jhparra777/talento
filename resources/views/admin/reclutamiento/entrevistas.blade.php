@extends("admin.layout.master")
@section('contenedor')
    <h3>Entrevistas</h3>

    {!! Form::model(Request::all(), ["id" => "admin.lista_pruebas", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">
                    @if (route("home") == "https://gpc.t3rsc.co")
                        Nombre del Proceso
                    @else
                        # Requerimiento:
                    @endif
                </label>
                <div class="col-sm-8">
                    {!! Form::text("codigo", null, ["class" => "form-control solo-numero", "placeholder" => ""]); !!}
                </div>  
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Cédula"]); !!}
                </div> 
            </div>
        </div>

        <button class="btn btn-warning" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.entrevistas")}}" >Limpiar</a>
        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Entrevista</a>
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
                    <td>Cedula</td>
                    <td>Nombre</td>
                    <td>Estado</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
                @if($candidatos->count() == 0)
                    <tr>
                        <td colspan="4"> No se encontraron registros</td>
                    </tr>
                @endif

                @foreach($candidatos as $candidato)
                    <tr>
                        <td>
                            {!! Form::checkbox("ref_id[]", $candidato->ref_id, null, [
                                "data-url" => route('admin.gestionar_entrevista', ["ref_id" => $candidato->ref_id])
                            ]) !!}
                        </td>
                        <td>{{ $candidato->requerimiento_id }}</td>

                        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                            <td>{{ $candidato->descripcion }}</td>
                        @else
                            <td>{{ $candidato->getUbicacionReq() }}</td>
                        @endif

                        <td>{{ $candidato->numero_id }}</td>
                        <td>{{ $candidato->fullname() }}</td>
                        <td>{{ $candidato->proceso }}</td>
                        <td>
                            <a
                                type="button"
                                class="btn btn-sm btn-info"
                                href="{{(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")?route("admin.informe_seleccion",["user_id"=>$candidato->req_cand_id]): route("admin.hv_pdf",["ref_id"=>$candidato->user_id])}}"
                                target="_blank"
                            >
                                HV PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {!! $candidatos->appends(Request::all())->render() !!}
@stop