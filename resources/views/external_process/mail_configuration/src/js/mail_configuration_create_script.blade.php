<script>
	//Crear configuración
	const crearConfiguracion = document.querySelector('#crearConfiguracion')

	crearConfiguracion.addEventListener('click', () => {
		//Crear form para enviar datos
		let data = new FormData();

		data.append('_token', document.querySelector('meta[name="token"]').getAttribute('content'));
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
	    crearConfiguracion.setAttribute('disabled', true)
	    crearConfiguracion.innerText = 'Guardando ...'

		if ($('#frmCrearConfiguracion').smkValidate()) {
			fetch('{{ route('configuracion_correos_guardar') }}', {
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
			            text: 'Configuración creada correctamente.',
			            type: 'success',
			        })

			        setTimeout(() => {
			        	crearConfiguracion.removeAttribute('disabled')
	    				crearConfiguracion.innerText = 'Guardar'
			        }, 1000)

			        setTimeout(() => {
			        	window.location.href = "{{ route('configuracion_correos') }}"
			        }, 2000)
		        }
		    })
		    .catch(error => console.log(error))
		}else {
			crearConfiguracion.removeAttribute('disabled')
			crearConfiguracion.innerText = 'Guardar'
		}
	})
</script>