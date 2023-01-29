@extends("admin.layout.master")
@section('contenedor')


<h3>Candidatos enviados a aprobar por el cliente</h3>
{!! Form::model(Request::all(),["id"=>"aprobar_cliente_admin","method"=>"GET"]) !!}
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
<a class="btn btn-warning" href="{{route("admin.aprobar_cliente_admin")}}" >Limpiar</a>
<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this,'url')">Gestionar Aprobar Cliente</a>
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
                    {!! Form::checkbox("ref_id[]",$candidato->ref_id,null,["data-url"=>route('admin.gestionar_aprobar_cliente_admin',["ref_id"=>$candidato->ref_id])]) !!}

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

@stop