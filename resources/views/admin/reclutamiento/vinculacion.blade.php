@extends("admin.layout.master")
@section('contenedor')


<h3>Candidatos a Vinculación</h3>
{!! Form::model(Request::all(),["id"=>"admin.vinculacion_lista","method"=>"GET"]) !!}
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
            {!! Form::text("codigo",null,["class"=>"form-control","placeholder"=>"# Requerimiento"]); !!}
        </div> 
    </div>

    <div class="col-md-6  form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
        <div class="col-sm-8">
            {!! Form::text("cedula",null,["class"=>"form-control","placeholder"=>"# Identificación"]); !!}
        </div>
    </div>
</div>
<button class="btn btn-warning" >
    <span class="glyphicon glyphicon-search"></span> Buscar
</button>
<a class="btn btn-warning" href="{{route("admin.vinculacion_lista")}}" >
    <span class="glyphicon glyphicon-trash"></span> Limpiar
</a>
<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this,'url')">Gestionar Vinculación</a>
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td></td>
                <td>Requerimiento</td>
                <td>Ciudad</td>
                <td>Cedula</td>
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
            @foreach($candidatos as $candidato)
            <tr>
                <td>
                    {!! Form::checkbox("ref_id[]",$candidato->ref_id,null,["data-url"=>route('admin.gestionar_vinculacion',["ref_id"=>$candidato->ref_id])]) !!}

                </td>
                <td>{{$candidato->requerimiento_id}}</td>
                <td>{{$candidato->getUbicacionReq()}}</td>
                <td>{{$candidato->numero_id}}</td>
                <td>{{strtoupper($candidato->nombres)}}</td>
                <td>
                    @if ($candidato->proceso == "ENVIO_VALIDACION")
                        <p>ENVIO VINCULACIÓN</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop