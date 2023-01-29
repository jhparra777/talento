@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de @if(route('home') =="https://gpc.t3rsc.co") Provincias @else Departamentos @endif</h3>
@if(Session::has("mensaje_success"))
  <div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get("mensaje_success")}}
    </div>
  </div>
@endif

{!!Form::model(Request::all(),["id"=>"admin.departamentos.index","method"=>"GET"])!!}
  
  <div class="row">
    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">nombre:</label>
      <div class="col-sm-9">
          {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"nombre" ]); !!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
    </div>

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">País:</label>
      <div class="col-sm-9">
       {!! Form::select("cod_pais",$paises,null,["class"=>"form-control selectpicker", "id"=>"cod_pais", "data-live-search" => "true" ]) !!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_pais",$errors) !!}</p>    
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Departamento:</label>
        <div class="col-sm-9">
            {!! Form::select("cod_departamento",isset($dptos)?$dptos:null,null,["class"=>"form-control selectpicker", "id"=>"cod_departamento", "data-live-search" => "true"]) !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_departamento",$errors) !!}</p>    
    </div>
  </div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.departamentos.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.departamentos.editar","Editar","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.departamentos.nuevo","Nuevo","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
           <th></th>
           <th>Departamento</th>
           <th>País</th>
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="4">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td class="text-center">{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.departamentos.editar',["id"=>$lista->id])]) !!}</td>
             <td class="text-center">{{$lista->nombre}}</td>
             <td class="text-center">{{$lista->pais}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!!  $listas->appends(Request::all())->render() !!}
<script>
    $(function(){

        $("#cod_pais").change(function(){
            let pais=$("#cod_pais").val();
            
            buscarDepartamentos(pais)
        });

        function buscarDepartamentos(pais)
        {
            $.ajax({
                url: "{{ route('cv.selctDptos') }}",
                type: 'POST',
                data: {
                    id:pais
                },
                success: function(response){
                    var data = response.dptos;

                    $('#cod_departamento').empty();
                    $('#cod_ciudad').empty();
                    $('#cod_departamento').append("<option value=''>Seleccionar</option>");
                    $('#cod_ciudad').append("<option value=''>Seleccionar</option>");

                    $.each(data, function(key, element) {
                        $('#cod_departamento').append("<option value='" + element.cod_departamento + "'>" + element.nombre + "</option>");
                    });

                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }

    })
</script>
@stop