@extends("admin.layout.master")
@section("contenedor")
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Cargar Usuarios Masivos
                </h3>
                <h5>
                    Se realiza la carga de todos los usuarios que se encuentren en el archivo plano, donde se valida si el número de identificación cuenta con algun tipo de seguridad.
                        Una vez se registra el usuario se envia un email (notificación) para pedir actualización de contraseña.
                </h5>
            </div>
            {!! Form::open(["id" => "fr_carga_usuario", "role" => "form", "files"=>true]) !!}
            <div class="box-body">
                <div style="display: none;" id="mensaje">
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible" id="errores_global">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h5><i class="icon fa fa-ban"></i> Alerta!</h5>
                        </div>
                        <div class="alert alert-success alert-dismissible" id="mensaje_success">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h5><i class="icon fa fa-check"></i> Alerta!</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="archivo">
                            Archivo Plano
                        </label>
                        {!! Form::file("archivo", ["id"=>"archivo"]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button class="btn btn-primary">
                            Descargar Formato
                        </button>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" id="procesar_archivo" type="button">
                    Procesar Carga
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(function () {
		$(document).on("click", "#procesar_archivo", function (){
            var formData = new FormData(document.getElementById("fr_carga_usuario"));
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('admin.procesar_archivo_cmu')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                }
            }).done(function (response, data) {
                if (response.success) {
                    document.getElementById('mensaje').style.display = 'block';
                    $("#errores_global").html(response.errores_global);
                    $("#mensaje_success").html(response.mensaje_success);
                }
            });
        });
	});
</script>
@stop
