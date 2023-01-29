<div class="modal-header">
    <h4 class="modal-title">Código validación</h4>
</div>

<div class="modal-body">
    <div>
        <p>Se ha enviado a tu dirección de correo electrónico y a tu teléfono móvil como mensaje de texto el código de validación</p>
    </div>

	{!! Form::open(["id" => "fr_verificacion_codigo", "route" => "verificar_codigo_contrato", "name" => "verificacion"]) !!}
        {!! Form::text("codigo",null,["class"=>"form-control","id"=>"codigo"]); !!}
   
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Código</label>
            
            <div class="col-sm-8">
                {{--{!! Form::text("codigo",null,["class"=>"form-control","id"=>"codigo"]); !!}--}}
            </div>
        </div>

        <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <input type="submit" class="btn btn-success"  id="verificar_codigo" value="Verificar">
</div>
{!! Form::close() !!}

<script>
    {{--$(function(){
        $("#verificar_codigo").click(function(){
            $.ajax({
                url: "{{ route('verificar_codigo_contrato') }}",
                type: "POST",
                data:{
                    codigo:$("#codigo").val(),
                    proceso:{{$proceso->id}}
                },
                beforeSend: function(){
                },
                success: function(response) {
                }
            });
        });
    });--}}
</script>