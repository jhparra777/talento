@extends("admin.layout.master")
@section('contenedor')


<h3>Candidatos validacion documentos</h3>
{!! Form::model(Request::all(),["id"=>"admin.valida_documentos","method"=>"GET"]) !!}
<div class="row">
    <div class="col-md-6  form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"># Requerimiento:</label>
        <div class="col-sm-8">
            {!! Form::text("codigo",null,["class"=>"form-control","placeholder"=>"#Requerimiento"]); !!}
        </div> 
    </div>
    <div class="col-md-6  form-group">
        <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
        <div class="col-sm-8">
            {!! Form::text("cedula",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
        </div> 
    </div>
</div>
<button type="submit" class="btn btn-warning">Buscar</button>
<a class="btn btn-warning" href="{{route("admin.valida_documentos")}}" >Limpiar</a>
<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this,'url')">Gestionar Documentación</a>
{!! Form::close() !!}

@if(route('home') != "http://soluciones3.t3rsc.co" || route('home') != "https://soluciones3.t3rsc.co")

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
                    {!! Form::checkbox("ref_id[]",$candidato->ref_id,null,["data-url"=>route('admin.gestionar_documentos',["ref_id"=>$candidato->ref_id])]) !!}

                </td>
                <td>{{$candidato->requerimiento_id}}</td>
                
                    <td>{{$candidato->getUbicacionReq()}}</td>
                
                <td>{{$candidato->numero_id}}</td>
                <td>{{$candidato->fullname()}}</td>
                <td>{{$candidato->proceso}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-md-12">
    <div class="showing" style="text-align: center;">
      {!! $candidatos->appends(Request::all())->render()!!}
    </div>                    
  </div>
</div>

@else

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
                    {!! Form::checkbox("ref_id[]",$candidato->ref_id,null,["data-url"=>route('admin.gestionar_documentos',["ref_id"=>$candidato->ref_id])]) !!}

                </td>
                <td>{{$candidato->requerimiento_id}}</td>
                @if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                    <td>{{$candidato->descripcion}}</td>
                @else
                    <td>{{$candidato->getUbicacionReq()}}</td>
                @endif
                <td>{{$candidato->numero_id}}</td>
                <td>{{$candidato->fullname()}}</td>
                <td>{{$candidato->proceso}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-md-12">
    <div class="showing" style="text-align: center;">
      {!! $pruebas->appends(Request::all())->render()!!}
    </div>                    
  </div>
</div>
@endif

@stop