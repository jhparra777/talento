@extends("cv.layouts.master_out")
@section('content')
	<style>
		.color-field{ padding: 0; }
	</style>

	@include('external_process.mail_configuration.src.css.inputs_styles')
	@include('external_process.mail_configuration.src.css.mail_configuration_style')

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
				  	<h3>Crear configuración</h3>
				</div>
			</div>

			<form 
				method="post" 
				enctype="multipart/form-data" 
				id="frmCrearConfiguracion" 
				data-smk-icon="glyphicon-remove-sign"
			>
				{{ csrf_field() }}

				{{-- Nombre configuración --}}
			  	<div class="col-md-12 mb-2">
			  		<div class="form-group">
				    	<label for="nombre_configuracion">Nombre configuración *</label>
				    	<input 
				    		type="text" 
				    		class="form-control" 
				    		name="nombre_configuracion" 
				    		id="nombre_configuracion" 
				    		placeholder="Nombre de la configuración"
				    		required 
				    	>
				  	</div>
			  	</div>

			  	{{-- Imagen header --}}
			  	<div class="col-md-12">
			  		<div class="form-group">
			  			<label for="imagenHeader">Imagen header *</label>

			  			<div class="panel panel-default">
						  	<div class="panel-body">
						  		<div class="file-button">
									<span>Imagen</span>
									<input type="file" name="imagen_header" id="imagenHeader" required>
								</div>

								<div class="file-path-wrapper">
									<output id="Output-Thumbnail"></output>
									<span class="helper-text">
										La imagen debe ser JPG, JPEG o PNG y no superar las medidas de <b>600</b> de ancho y <b>260</b> de alto
									</span>
								</div>

								<div class="text-center mt-3">
									<img 
										id="imgHeader" 
										alt="🖼️" 
										width="300"
									>
								</div>
						  	</div>
						</div>
				  	</div>
			  	</div>

			  	{{-- Imagen fondo header --}}
			  	<div class="col-md-12">
			  		<div class="form-group">
			  			<label for="imagenFondoHeader">Imagen fondo header *</label>

			  			<div class="panel panel-default">
						  	<div class="panel-body">
						    	<div class="file-button">
									<span>Imagen</span>
									<input type="file" name="imagen_fondo_header" id="imagenFondoHeader" required>
								</div>

								<div class="file-path-wrapper">
									<output id="Output-Thumbnail"></output>
									 <span class="helper-text">
										La imagen debe ser JPG, JPEG o PNG y no superar las medidas de <b>680</b> de ancho y <b>400</b> de alto
									</span>
								</div>

								<div class="text-center mt-3">
									<img 
										id="imgFondoHeader" 
										alt="🖼️" 
										width="300"
									>
								</div>
							</div>
						</div>
				  	</div>
			  	</div>

			  	{{-- Imagen footer --}}
			  	<div class="col-md-12">
			  		<div class="form-group">
			  			<label for="imagenFooter">Imagen footer *</label>

			  			<div class="panel panel-default">
						  	<div class="panel-body">
						    	<div class="file-button">
									<span>Imagen</span>
									<input type="file" name="imagen_footer" id="imagenFooter" required>
								</div>

								<div class="file-path-wrapper">
									<output id="Output-Thumbnail"></output>
									 <span class="helper-text">
										La imagen debe ser JPG, JPEG o PNG y no superar las medidas de <b>600</b> de ancho y <b>260</b> de alto
									</span>
								</div>

								<div class="text-center mt-3">
									<img 
										id="imgFooter" 
										alt="🖼️" 
										width="300"
									>
								</div>
							</div>
						</div>
				  	</div>
			  	</div>

			  	{{-- Imagen sub footer --}}
			  	<div class="col-md-12 mb-2">
			  		<div class="form-group">
			  			<label for="imagenSubFooter">Imagen sub footer *</label>

			  			<div class="panel panel-default">
						  	<div class="panel-body">
						    	<div class="file-button">
									<span>Imagen</span>
									<input type="file" name="imagen_sub_footer" id="imagenSubFooter" required>
								</div>

								<div class="file-path-wrapper">
									<output id="Output-Thumbnail"></output>
									 <span class="helper-text">
										La imagen debe ser JPG, JPEG o PNG y no superar las medidas de <b>250</b> de ancho y <b>110</b> de alto
									</span>
								</div>

								<div class="text-center mt-3">
									<img 
										id="imgSubFooter" 
										alt="🖼️" 
										width="300"
									>
								</div>
							</div>
						</div>
				  	</div>
			  	</div>

			  	{{-- Color principal --}}
			  	<div class="col-md-6 mb-2">
			  		<div class="form-group">
				    	<label for="color_principal">Color principal *</label>
				    	<input 
				    		type="color" 
				    		class="form-control color-field" 
				    		name="color_principal" 
				    		id="color_principal"
				    		value="#000000" 
				    		required 
				    	>
				  	</div>
			  	</div>

			  	{{-- Color secundario --}}
			  	<div class="col-md-6 mb-2">
			  		<div class="form-group">
				    	<label for="color_secundario">Color secundario *</label>
				    	<input 
				    		type="color" 
				    		class="form-control color-field" 
				    		name="color_secundario" 
				    		id="color_secundario"
				    		value="#000000" 
				    		required 
				    	>
				  	</div>
			  	</div>

			  	{{-- Facebook --}}
			  	<div class="col-md-1">
			    	{{-- Facebook --}}
	                <label class="toggle" for="socialFacebook">
	                    <p>Facebook</p>

	                    <input
	                        type="checkbox"
	                        class="toggle__input"
	                        name="social_facebook"
	                        id="socialFacebook"
	                        value="1"
	                    >
	                    <div class="toggle__fill toggle__fill_fb"></div>
	                </label>
	            </div>

	            {{-- Twitter --}}
	            <div class="col-md-1">
	                {{-- Twitter --}}
	                <label class="toggle" for="socialTwitter">
	                    <p>Twitter</p>

	                    <input
	                        type="checkbox"
	                        class="toggle__input"
	                        name="social_twitter"
	                        id="socialTwitter"
	                        value="1"
	                    >
	                    <div class="toggle__fill toggle__fill_tw"></div>
	                </label>
	            </div>

	            {{-- LinkedIn --}}
	            <div class="col-md-1">
	                {{-- LinkedIn --}}
	                <label class="toggle" for="socialLinkedIn">
	                    <p>LinkedIn</p>

	                    <input
	                        type="checkbox"
	                        class="toggle__input"
	                        name="social_linkedin"
	                        id="socialLinkedIn"
	                        value="1"
	                    >
	                    <div class="toggle__fill toggle__fill_ln"></div>
	                </label>
	            </div>

	            {{-- Instagram --}}
	            <div class="col-md-1">
	                {{-- Instagram --}}
	                <label class="toggle" for="socialInstagram">
	                    <p>Instagram</p>

	                    <input
	                        type="checkbox"
	                        class="toggle__input"
	                        name="social_instagram"
	                        id="socialInstagram"
	                        value="1"
	                    >
	                    <div class="toggle__fill toggle__fill_in"></div>
	                </label>
	            </div>

	            {{-- Whatsapp --}}
	            <div class="col-md-1">
	                {{-- Whatsapp --}}
	                <label class="toggle" for="socialWhatsapp">
	                    <p>Whatsapp</p>

	                    <input
	                        type="checkbox"
	                        class="toggle__input"
	                        name="social_whatsapp"
	                        id="socialWhatsapp"
	                        value="1"
	                    >
	                    <div class="toggle__fill toggle__fill_wp"></div>
	                </label>
	            </div>
			</form>

			<div class="col-md-12 mt-3 mb-4">
		  		<button type="button" class="btn btn-success" id="crearConfiguracion">Guardar</button>
		  		<a href="{{ route('configuracion_correos') }}" class="btn btn-default">Volver</a>
		  	</div>
		</div>

		{{-- Botón flotante --}}
		@include('external_process.mail_configuration.includes.mail_configuration_float_button')

		{{-- Modal preview --}}
		<div id="modalPreviewBox"></div>
	</div>

	{{-- Scripts --}}
	@include('external_process.mail_configuration.src.js.mail_configuration_all_script')
	@include('external_process.mail_configuration.src.js.input_file_script')
	@include('external_process.mail_configuration.src.js.mail_configuration_create_script')
@stop