@extends("admin.layout.master")
@section('contenedor')

{!! Form::model($sitio,["method"=>"POST", "role"=>"form", "id"=>"fr_sitio", "files"=>true]) !!}
		{!! Form::hidden("id") !!}
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-info">
	            <div class="box-header with-border">
	                <h3 class="box-title">CONFIGURACIÓN DEL SITIO</h3>
	            </div>
	            <h4 class="box-header with-border">INFORMACIÓN GENERAL</h4>
	            <div class="row">
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Nombre</label>
	                    <div class="col-sm-8">
	                    	{!! Form::text("nombre", null,["class"=>"form-control", "placeholder"=>"Ingresa nombre de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Teléfono</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("telefono", null,["class"=>"form-control", "placeholder"=>"Ingresa teléfono de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Celular</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("celular", null,["class"=>"form-control", "placeholder"=>"Ingresa celular de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Web Corporativa</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("web_corporativa", null,["class"=>"form-control", "placeholder"=>"Ingresa la URL de la paginá de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Color Corporativo</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("color", null,["class"=>"form-control my-colorpicker1 colorpicker-element", "placeholder"=>"Color corporativo"]) !!} 
	                    </div>
	                </div>
	            </div>

	            <h4 class="box-header with-border">DESCRIPCIÓN</h4>
	            <div class="row">
	            	<div class="col-md-12 form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Quiénes Somos?</label>
	                    <div class="col-sm-10">
	                        {!! Form::textarea("quienes_somos", null,["class"=>"form-control", "placeholder"=>"Ingresa la descripción de quienes somos."]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Visión</label>
	                    <div class="col-sm-10">
	                        {!! Form::textarea("vision", null,["class"=>"form-control", "placeholder"=>"Ingresa la descripción de visión de la empresa."]) !!} 
	                    </div>
	                </div>
	                 <div class="col-md-12 form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Misión</label>
	                    <div class="col-sm-10">
	                        {!! Form::textarea("mision", null,["class"=>"form-control", "placeholder"=>"Ingresa la descripción de misión de la empresa."]) !!} 
	                    </div>
	                </div>
	            </div>

	            <h4 class="box-header with-border">IMAGENES</h4>
	            <div class="row">
	                <div class="col-md-12 form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Logo</label>
	                    <div class="col-sm-6">
	                        {!! Form::file("logo", null,["class"=>"form-control", "placeholder"=>"Subir logo corporativo"]) !!} 
	                    </div>
	                     <div class="col-sm-4">
	                     	@if(isset($sitio->logo))
	                        	<img width="107px" src="{{ url('configuracion_sitio/'.$sitio->logo)}}">
	                        @endif
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label for="inputEmail3" class="col-sm-2 control-label">Favicon</label>
	                    <div class="col-sm-6">
	                        {!! Form::file("favicon", null,["class"=>"form-control", "placeholder"=>"Subir favicon corporativo"]) !!} 
	                    </div>
	                    <div class="col-sm-4">
	                    	@if(isset($sitio->favicon))
	                        	<img width="32px" src="{{ url('configuracion_sitio/'.$sitio->favicon)}}">
	                        @endif
	                    </div>
	                </div>
	            </div>

	            <h4 class="box-header with-border">Audio llamada Virtual    (El audio tiene que ser  con formato .wav) </h4>
	            <br>
	            <div class="row">
	            

	                <div class="col-md-12 form-group">

	                    <label for="inputEmail3" class="col-sm-2 control-label">Audio</label>

	                    <div class="col-sm-6">
	                        {!! Form::file("audio", null,["class"=>"form-control", "placeholder"=>"Subir Audio Llamada Virtual"]) !!} 
	                    </div>
	                     <div class="col-sm-4">
	                     	@if(isset($sitio->audio))
	                        	<audio width="107px" controls src="{{ url('configuracion_sitio/'.$sitio->audio)}}">
	                        @endif
	                    </div>
	                </div>
	               
	            </div>
<br><br>
	            <h4 class="box-header with-border">REDES SOCIALES</h4>
	            <div class="row">
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Facebook</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_facebook", null,["class"=>"form-control", "placeholder"=>"Ingresa URL de la red facebook de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Twitter</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_twitter", null,["class"=>"form-control", "placeholder"=>"Ingresa URL de la red Twitter de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Youtube</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_youtube", null,["class"=>"form-control", "placeholder"=>"Ingresa URL de la red Youtube de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Whatsapp</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_whatsapp", null,["class"=>"form-control", "placeholder"=>"Ingresa número de Whatsapp de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Linkedin</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_linkedin", null,["class"=>"form-control", "placeholder"=>"Ingresa URL de la red Linkedin de la empresa"]) !!} 
	                    </div>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label for="inputEmail3" class="col-sm-4 control-label">Instagram</label>
	                    <div class="col-sm-8">
	                        {!! Form::text("social_instagram", null,["class"=>"form-control", "placeholder"=>"Ingresa URL de la red instagram de la empresa"]) !!} 
	                    </div>
	                </div>
	            </div>
	            <button type="button" class="btn btn-small btn-success guardar_sitio">Guardar</button>
	        </div>
	    </div>
	</div>
{!! Form::close() !!}

<script>
	 $(function () {
        $(".guardar_sitio").on("click", function () {
            var formData = new FormData(document.getElementById("fr_sitio"));
            mensaje_success("Espere mientras se suben las actualizaciones");
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{route('admin.guardar_configuracion_sitio')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    mensaje_success(response.mensaje_success);
                },
                error:function(response)
                { 
                	mensaje_danger("Problemas al guardar la configuración.");
                }
            }).done(function (response, data) {
                location.reload(true);
            });
        });

        $('.my-colorpicker1').colorpicker()
    });
</script>
@stop