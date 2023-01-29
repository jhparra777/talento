@extends("admin.layout.master")
@section('contenedor')

    <h3>Candidatos Estudio de Seguridad</h3>

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
        <a class="btn btn-warning" href="{{ route("admin.estudios_seguridad") }}" >Limpiar</a>

        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this,'url')">Gestionar Documentación</a>
    {!! Form::close() !!}

<div class="table-responsive">
  @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="https://demo.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co")

    <table class="table table-bordered">
      <thead>
       <tr>
        <td></td>
        <td>Requerimiento</td>
        @if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
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
               {!! Form::checkbox("ref_id[]",$candidato->ref_id,null,["data-url" => route('admin.gestionar_documentos_estudio_seguridad',["ref_id"=>$candidato->ref_id])]) !!}
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
   
  @else

    <table class="table table-bordered">
        <thead>
            <tr>
                <td></td>
                <td>Requerimiento</td>
              
                 <td>Cargo</td>
                
                <td>Cedula</td>
                <td>Nombre</td>
                
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
                    {!! Form::checkbox("ref_id[]",$candidato->orden,null,["data-url"=>route('admin.gestionar_documentos_estudio_seguridad',["ref_id"=>$candidato->orden])]) !!}

                </td>
                <td>{{$candidato->requerimiento}}</td>
                
                <td>{{$candidato->cargo}}</td>
                
                <td>{{$candidato->numero_id}}</td>
                <td>{{$candidato->candidato}}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>

@stop