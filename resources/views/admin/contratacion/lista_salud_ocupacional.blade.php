@extends("admin.layout.master")
@section('contenedor')

    <h3>Candidatos salud ocupacional</h3>
    
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
        
        <button type="submit" class="btn btn-success">Buscar</button>
    
    {!! Form::close() !!}
    <br><br>
    
    <div class="table-responsive">
  
        <table class="table table-bordered">
            <thead>
                <tr>                
                    <th>Requerimiento</th>
                    <th>Orden</th>
                    <th>Cargo</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Acción</th>
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
                        <td>{{$candidato->requerimiento}}</td>
                        <td># {{$candidato->orden}}</td>
                        <td>{{$candidato->cargo}}</td>
                        <td>{{$candidato->numero_id}}</td>
                        <td>{{$candidato->candidato}}</td>
                        <td><a class="btn btn-warning" href="{{route("admin.gestion_salud_ocupacional",["orden"=>$candidato->orden])}}">Gestionar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop