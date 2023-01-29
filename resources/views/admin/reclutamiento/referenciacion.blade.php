@extends("admin.layout.master")
@section('contenedor')
    <h3>Candidatos a referenciar</h3>
    {!! Form::model(Request::all(),["id"=>"admin.lista_clientes","method"=>"GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Requerimiento:</label>
                <div class="col-sm-8">
                    {!! Form::text("codigo",null,["class"=>"form-control solo-numero","placeholder"=>"# Requerimiento"]); !!}
                </div>
            </div>
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula",null,["class"=>"form-control solo-numero","placeholder"=>"# Cédula"]); !!}
                </div>
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Ciudad:</label>
                <div class="col-sm-8">
                  {!!Form::select("ciudad_trabajo",$ciudad_trabajo,null,["class"=>"form-control","id"=>"ciudad_trabajo"]) !!}
                    <p class="text-danger">
                    {!! FuncionesGlobales::getErrorData("ciudad_trabajo",$errors) !!}
                    </p>
                </div>
            </div>
        </div>
        
        <button class="btn btn-warning">Buscar</button>
        
        <a class="btn btn-warning" href="{{route("admin.referenciacion")}}" >Limpiar</a>
        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this,'url')">Gestionar Referencia</a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td></td>
                    <td>Requerimiento</td>
                    <td>Ubicación</td>
                    @if (route('home') == 'https://gpc.t3rsc.co')
                        <td>CI</td>
                    @else
                        <td>Cédula</td>
                    @endif
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
                     {!!Form::radio("ref_id[]",$candidato->ref_id,null,["data-url"=>route('admin.gestionar_referencia',["ref_id"=>$candidato->ref_id])])!!}

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

    <script>
        $(function(){

            $('#txt_residencia').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_residencia").val(suggestion.cod_pais);
                    $("#departamento_residencia").val(suggestion.cod_departamento);
                    $("#ciudad_residencia").val(suggestion.cod_ciudad);
                }
            });
        })
    </script>
@stop