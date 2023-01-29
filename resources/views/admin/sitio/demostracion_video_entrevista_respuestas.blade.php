@extends("admin.layout.master")
@section('contenedor')


<h3>Respuestas</h3>
{!! Form::model(Request::all(),["id"=>"admin.lista_pruebas","method"=>"GET"]) !!}
<div class="row">
    
    <div class="col-md-6  form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"># Cédula:</label>
        <div class="col-sm-8">
            {!! Form::text("cedula",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
        </div> 
    </div>
</div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.gestionar_respuesta_entre")}}" >Limpiar</a>

{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>N°</td>
                <td>Correo</td>
                <td>Nombres</td>
                <td>Número de identificacion</td>
                <td style="text-align: center;">Acción</td>

            </tr>
        </thead>
        <tbody>
            @if($datos_temporales->count() == 0)
            <tr>
                <td colspan="4"> No se encontraron registros</td>
            </tr>
            @endif
            @foreach($datos_temporales as $key=>$datos)
            <tr>
                
                <td>{{++$key}}</td>
                <td>{{$datos->correo}}</td>
                <td>{{$datos->nombres}}</td>
                <td>{{$datos->numero_id}}</td>
                <td style="text-align: center;">
                       
  
   

                       
                       
                      <a type="button"  data-numero_id ="{{$datos->numero_id}}"  class="btn btn-success respuesta" id="respuesta">Video respuesta</a>

                      
                      
                      
                     
                </td>
               
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{!! $datos_temporales->appends(Request::all())->render() !!}

<script>
    

    $(function () {

            
        $(".respuesta").on("click", function () {
            var numero_id = $(this).data("numero_id");
            $.ajax({
                type: "POST",
                data:{numero_id: numero_id},
                url: "{{route('admin.video_respuesta_demo')}}",
                success: function (response) {
                    console.log("af");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");

                }
            });
        });

        

});
</script>
@stop