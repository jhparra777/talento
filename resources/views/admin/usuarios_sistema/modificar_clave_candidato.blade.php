@extends("admin.layout.master")
@section('contenedor')
<h3>Modificar Contraseña Candidatos</h3>

<div class="col-md-6">
    <div class="form-group">
        <label for="usuario" class="control-label">Usuario:</label>
        <div class="input-group">
            {!! Form::text("usuario",null,["class"=>"form-control","placeholder"=>"Ingrese correo o cédula", "id" => "usuario"]); !!}
            <span class="input-group-btn">
                <button class="btn btn-warning" id="buscar" type="button">Buscar</button>
                <button class="btn btn-default" id="limpiar" type="button" style="display: none;">Limpiar</button>
            </span>
        </div>
    </div>
</div>

<div id="put-here-ajax" class="col-md-12">
    
</div>

<div class="clearfix"></div>

<script type="text/javascript">
    $(function() {
        $('#buscar').click(function() {
            $.ajax({
                url: "{{ route('admin.usuarios.buscar_datos') }}",
                type: 'POST',
                data: {
                        usuario: $('#usuario').val()
                    },
                beforeSend: function(){
                    $.smkAlert({
                        text: 'Consultando información...',
                        type: 'info'
                    })

                    $('#buscar').hide();
                    $('#limpiar').show();
                    $('#usuario').prop('readonly', true);
                },
                success: function(response){
                    if (response.success) {
                        $.smkAlert({
                            text: 'Consulta exitosa',
                            type: 'success'
                        })
                        $('#put-here-ajax').html(response.view);
                    } else {
                        swal({
                            text: response.mensaje,
                            icon: "warning"
                        })
                        $('#buscar').show();
                        $('#limpiar').hide();
                        $('#usuario').removeAttr('readonly');
                    }
                },
                error: function(response){
                    $.smkAlert({
                        text: 'Ha ocurrido un error, intente nuevamente.',
                        type: 'danger'
                    });
                    $('#buscar').show();
                    $('#limpiar').hide();
                    $('#usuario').removeAttr('readonly');
                }
            });
        })

        $('#limpiar').click(function() {
            $('#buscar').show();
            $('#limpiar').hide();
            $('#usuario').removeAttr('readonly');
            $('#put-here-ajax').html('');
        })
    })
</script>
@stop