<script>
	//Actualizar configuración
	const actualizarConfiguracion = document.querySelector('#actualizarConfiguracion')

	actualizarConfiguracion.addEventListener('click', () => {
		//Crear form para enviar datos
		let data = new FormData();

		data.append('_token', document.querySelector('meta[name="token"]').getAttribute('content'));
		data.append('configuracion_id', document.querySelector('#configuracion_id').value)
	    data.append('nombre_configuracion', document.querySelector('#nombre_configuracion').value)

	    data.append('imagen_header', document.querySelector('#imagenHeader').files[0])
	    data.append('imagen_fondo_header', document.querySelector('#imagenFondoHeader').files[0])
	    data.append('imagen_footer', document.querySelector('#imagenFooter').files[0])
	    data.append('imagen_sub_footer', document.querySelector('#imagenSubFooter').files[0])

	    data.append('color_principal', document.querySelector('#color_principal').value)
	    data.append('color_secundario', document.querySelector('#color_secundario').value)

	    data.append('social_facebook', document.querySelector('#socialFacebook').checked)
	    data.append('social_twitter', document.querySelector('#socialTwitter').checked)
	    data.append('social_linkedin', document.querySelector('#socialLinkedIn').checked)
	    data.append('social_instagram', document.querySelector('#socialInstagram').checked)
	    data.append('social_whatsapp', document.querySelector('#socialWhatsapp').checked)

	    //Modificar botón
	    actualizarConfiguracion.setAttribute('disabled', true)
	    actualizarConfiguracion.innerText = 'Guardando ...'

		if ($('#frmActualizarConfiguracion').smkValidate()) {
			fetch('{{ route('configuracion_correos_modificar') }}', {
		        method : 'post',
		        body : data,
		        headers :{
		            'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
		        }
		    })
		    .then(content => {
		        //console.log(content)

		        if (content.status === 200) {
		        	$.smkAlert({
			            text: 'Configuración gestionada correctamente.',
			            type: 'success',
			        })

			        setTimeout(() => {
			        	actualizarConfiguracion.removeAttribute('disabled')
	    				actualizarConfiguracion.innerText = 'Guardar'
			        }, 1000)
		        }
		    })
		    .catch(error => console.log(error))
		}else {
			actualizarConfiguracion.removeAttribute('disabled')
			actualizarConfiguracion.innerText = 'Guardar'
		}
	})
</script>