@extends("admin.layout.master")
@section('contenedor')


<h3>Candidatos a Prueba de Tendencia</h3>
{!! Form::model(Request::all(),["id"=>"admin.pruebas_tendencia","method"=>"GET"]) !!}
<div class="row">
    <div class="col-md-12">
        <label for="inputEmail3" class="control-label"># Cédula:</label>
    </div>
    <div class="col-md-12  form-group">
            {!! Form::text("codigo",null,["class"=>"form-control","id"=>"codigo","placeholder"=>"#IDENTIFICACIÓN"]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
    </div>
</div>
<button class="btn btn-success">
    <span class="glyphicon glyphicon-search"></span> Buscar
</button>
<a class="btn btn-warning" href="{{route("admin.pruebas_tendencia")}}" >
    <span class="glyphicon glyphicon-trash"></span> Limpiar
</a>

{!! Form::close() !!}
@if($candidatos !== null)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Cédula</td>
                <td>Presento Prueba Tendencia</td>
                <td>Fecha Prueba</td>
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
                <td>{{ strtoupper($candidato->nombres) }}</td>
                <td>{{ $candidato->numero_id }}</td>
                <td>
                    @if ($presento === "SI")
                        {{ $presento }}
                    @else
                        <div class="col-md-12 center-block">
                            <button type="button" class="btn btn-primary realizar_prueba">Realizar Prueba</button>
                        </div>
                    @endif
                </td>
                <td>
                    @if ($presento === "SI")
                        {{ $candidato->created_at }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<script>
    $(function () {
        //Modal Prueba        
        $(document).on("click", ".realizar_prueba", function () {
            var identificacion = $("#codigo").val();
            if (identificacion){
                $.ajax({
                    type: "POST",
                    data: {hv_id: identificacion},
                    url: " {{route('admin.realizar_prueba')}} ",
                    success: function (response) {
                        $("#modal_peq ").find(".modal-content").html(response);
                        $("#modal_peq ").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se cargo la información, favor intentar nuevamente.");
            }
            
        });

        $(document).on("click", "#guardar_prueba_tendencia", function () {
            var formData = new FormData(document.getElementById("fr_nueva_prueba"));
            $.ajax({
                url: "{{ route('admin.guardar_prueba_tendencia') }}",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error) {
                        mensaje_success("Documentos no soportados.");
                    }
                    
                    if (response.success) {
                        $("#modal_peq ").modal("hide");
                        mensaje_success("Se guardo correctamente la prueba de tendencia.");
                        window.location.href = '{{route("admin.pruebas_tendencia")}}';
                    } else {
                        $("#modal_peq ").find(".modal-content").html(response.view);
                    }
                }
            });
        });
    });
</script>

@stop
