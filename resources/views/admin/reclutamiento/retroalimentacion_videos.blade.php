@extends("admin.layout.master")
@section('contenedor')
    <h3>Retroalimentación</h3>
    @if(Session::has("mensaje_warning"))
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_warning")}}
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["id" => "form_retroalimentacion", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="req_id" class="col-sm-4 control-label">
                    # Requerimiento:
                </label>
                <div class="col-sm-8">
                    {!! Form::text("req_id", null, ["class" => "form-control solo-numero", "placeholder" => ""]); !!}
                </div>  
            </div>

            <div class="col-md-6  form-group">
                <label for="cedula" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Cédula"]); !!}
                </div> 
            </div>
        </div>

        <button class="btn btn-warning" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.retroalimentacion_videos")}}" >Limpiar</a>
        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Retroalimentación</a>
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
                                "data-url" => route('admin.gestionar_retroalimentacion_video', ["ref_id" => $candidato->ref_id])
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