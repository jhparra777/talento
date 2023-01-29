<script>
	//Float button init
	$('.fab-button').click(function(){
	  	$('.floating-menus').toggle()
	  	$('.fab-button i').toggleClass('fa-times fa-caret-up')
	})

	//Previsualizar modal
	const previsualizarCorreos = document.querySelector('#previsualizarCorreos')
	previsualizarCorreos.addEventListener('click', () => {
		$.ajax({
            type: "POST",
            url: "{{ route('configuracion_correos_previsualizar_modal') }}",
            success: function(response){
              	document.querySelector('#modalPreviewBox').innerHTML = response
	        	$('#previsualizarModal').modal('show')
            }
        })
	})

	const previsualizarCorreoVentana = () => {
        let mailTemplate = document.querySelector('#plantilla')
        let mailConfiguration = document.querySelector('#configuracion')

        if ($('#frmPrevisualizarCorreo').smkValidate()) {
        	let url = '{{ route("configuracion_correos_previsualizar", [":mailTemplate", ":mailConfiguration"]) }}';
	        url = url.replace(':mailTemplate', mailTemplate.value)
	        url = url.replace(':mailConfiguration', mailConfiguration.value)

	        window.open(url)
        }
    }
</script>