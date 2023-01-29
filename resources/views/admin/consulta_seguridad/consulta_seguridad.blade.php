@extends("admin.layout.master")
@section("contenedor")


    @if(route("home") === "http://desarrollo.t3rsc.co" || route("home") === "https://desarrollo.t3rsc.co" ||
        route("home") === "http://asuservicio.t3rsc.co" || route("home") === "https://asuservicio.t3rsc.co" ||
        route("home") === "http://localhost:8000")

        <div class="col-md-12">
            <h3>Consulta Seguridad</h3>
        </div>

        <div class="col-md-6">
            <div class="form-group col-md-12">
                {!! Form::label('numero_cedula', 'Cédula') !!}
            
                {!! Form::number("numero_cedula",null,["class"=>"form-control","id"=>"numero_cedula"]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("numero_cedula",$errors) !!}</p>
            </div>
        </div>
        
        <div class="col-md-12">
            <button type="button" class="btn btn-info" name="consultaBtn" id="consultaBtn">
                CONSULTA DE SEGURIDAD
            </button>
        </div>

    @endif

<script>

    $(document).on("click", "#consultaBtn", function() {
            
        if($('#numero_cedula').val() == ''){
            alert('Recuerda digitar un número de cédula para la consulta.');
        }else{

            const numero_cedula = $('#numero_cedula').val();

            $.ajax({
                type: "POST",
                data: {
                    'numero_cedula' : numero_cedula
                },
                url: "{{ route('admin.consulta_seguridad_verifica_view') }}",
                success: function(response) {
                    if(response.limite === true){

                        alert("Has alcanzado el limite máximo de consultas, contacta con el administrador del sistema.");

                    }else{

                        const url = "{{ route('admin.consulta_seguridad_consulta') }}";

                        const urldef = url.concat("?a="+numero_cedula);

                        window.open(urldef, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600");
                    }
                }
            });
        }

    });

    
</script>

@stop