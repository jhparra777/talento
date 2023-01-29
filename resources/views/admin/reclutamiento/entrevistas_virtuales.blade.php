@extends("admin.layout.master")
@section('contenedor')


<h3>Entrevistas Virtuales</h3>
{!! Form::model(Request::all(),["id"=>"admin.lista_pruebas","method"=>"GET"]) !!}
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
            {!! Form::text("codigo",null,["class"=>"form-control","placeholder"=>""]); !!}
        </div>  
    </div>
   
</div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.entrevistas_virtuales")}}" >Limpiar</a>
<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('req_id[]', this,'url')">Gestionar Entrevista</a>
{!! Form::close() !!}
<br><br>
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
                <td>Fecha Ingreso</td>
                <td>Fecha Terminación</td>
                <td>Cargo</td>
                <td>Estado</td>
               

            </tr>
        </thead>
        <tbody>
             @if($entrevistas_virtuales->count() == 0)
            <tr>
                <td colspan="4"> No se encontraron registros</td>
            </tr>
            @endif
            @foreach($entrevistas_virtuales as $entre)
            <tr>
                <td>
                    {!! Form::checkbox("req_id[]",$entre->req_id,null,["data-url"=>route('admin.gestionar_entrevista_virtual',["req_id"=>$entre->req_id])]) !!}

                </td>
                <td>{{$entre->req_id}}</td>
                @if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                    {{$entre->sede }}
                @else
                    <td>{{$entre->ciudad}}</td>
                @endif
                <td>{{$entre->fecha_ingreso}}</td>
                <td>{{$entre->fecha_terminacion}}</td>
                <td>{{$entre->cargo_especifico}}</td>
                <td>{{$entre->estado}}</td>
                
            </tr>
            @endforeach 
        </tbody>
    </table>
</div>
{{-- {!! $candidatos->appends(Request::all())->render() !!} --}}
@stop