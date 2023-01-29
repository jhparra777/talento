<style>
    .mt-1{ margin-top: 1rem; }

    .text-center{ text-align: center; }
</style>
<div class="clearfix"></div>
{!! Form::open(["id" => "frm_reestablecer_clave", "method" => "POST"]) !!}
    {!! Form::hidden("user_id", $candidato->user_id, ["id" => "user_id"]) !!}

    <div class="row">
        <div class="col-md-6 col-md-offset-1 mt-1">
            <h4>Cambiar la Contraseña del Candidato <b>{{ $candidato->nombres . ' ' . $candidato->primer_apellido . ' ' . $candidato->segundo_apellido }}</b></h4>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6 col-md-offset-1">
                <div class="form-group">
                    <label for="correo" class="control-label">Correo:</label>
                    <input type="text" class="form-control" id="correo" readonly="readonly" value="{{ $candidato->email }}">
                </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="col-md-6 col-md-offset-1">
                <div class="form-group">
                    <label for="cedula" class="control-label">Cédula:</label>
                    <input type="text" class="form-control" id="cedula" readonly="readonly" value="{{ $candidato->numero_id }}">
                </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="col-md-6 col-md-offset-1">
                <div class="form-group">
                    <label class="control-label" for="clientes_asociar">Nueva Contraseña *</label>
                    <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese la nueva contraseña" required="required">
                </div>
            </div>
        </div>

        <div class="row col-md-6 col-md-offset-1">
            <div class="text-center mt-1">
                <button type="button" class="btn btn-success" id="modificar">Modificar <i class="fa fa-key"></i></button>
            </div>
        </div>
    </div>
{!! Form::close() !!}
<div class="clearfix"></div>

<script type="text/javascript">
    $('#modificar').click(function() {
        if ($('#frm_reestablecer_clave').smkValidate()) {
            let dataForm = $('#frm_reestablecer_clave').serialize()
            console.log(dataForm);
            $.ajax({
                url: "{{ route('admin.usuarios.guardar_nueva_clave') }}",
                type: 'POST',
                data: dataForm,
                beforeSend: function(){
                    $.smkAlert({
                        text: 'Guardando información...',
                        type: 'info'
                    })
                },
                success: function(response){
                    if (response.success) {
                        swal({
                            text: 'Contraseña modificada exitosamente.',
                            icon: 'success'
                        })
                        $('#put-here-ajax').html('');
                        $('#buscar').show();
                        $('#limpiar').hide();
                        $('#usuario').val('');
                        $('#usuario').removeAttr('readonly');
                    } else {
                        swal({
                            text: response.mensaje,
                            icon: "warning"
                        })
                    }
                },
                error: function(response){
                    $.smkAlert({
                        text: 'Ha ocurrido un error, intente nuevamente.',
                        type: 'danger'
                    });
                }
            });
        }
    })

    $('#clave').smkShowPass();
</script>