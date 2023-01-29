<script>
	let imagenHeader = document.getElementById("imagenHeader")
	let imagenFondoHeader = document.getElementById("imagenFondoHeader")
	let imagenFooter = document.getElementById("imagenFooter")
	let imagenSubFooter = document.getElementById("imagenSubFooter")

	//Imagen header
	imagenHeader.addEventListener('change', function () {
		let extensonesPermitidas = ["jpg", "jpeg", "png"]
		validateFileExtension(this, extensonesPermitidas, 'imgHeader')
		validateFileSize(this, 3000, 3000, 'imgHeader')
	})

	//Imagen fondo header
	imagenFondoHeader.addEventListener('change', function () {
		let extensonesPermitidas = ["jpg", "jpeg", "png"]
		validateFileExtension(this, extensonesPermitidas, 'imgFondoHeader')
		validateFileSize(this, 680, 400, 'imgFondoHeader') //1200 x 500
	})

	//Imagen footer
	imagenFooter.addEventListener('change', function () {
		let extensonesPermitidas = ["jpg", "jpeg", "png"]
		validateFileExtension(this, extensonesPermitidas, 'imgFooter')
		validateFileSize(this, 3000, 3000, 'imgFooter')
	})

	//Imagen sub footer
	imagenSubFooter.addEventListener('change', function () {
		let extensonesPermitidas = ["jpg", "jpeg", "png"]
		validateFileExtension(this, extensonesPermitidas, 'imgSubFooter')
		validateFileSize(this, 3000, 3000, 'imgSubFooter')
	})

	function validateFileExtension(input, exts, imgId){
		let out = input.parentNode.parentNode.querySelector('.file-path-wrapper output')
		let file = input.files[0]
		let ext = file.name.split('.').pop()

		out.innerText = file.name

		let res = exts.filter(extension => extension === ext )

		if(res.length === 0 ){
			$.smkAlert({
                text: 'La extensión es incorrecta.',
                type: 'danger'
            })

			input.value = ""
			out.innerHTML = ""
		}
	}

	function validateFileSize(input, maxWidth, maxHeight, imgId) {
		let _URL = window.URL || window.webkitURL
		let out = input.parentNode.parentNode.querySelector('.file-path-wrapper output')
		let image
		let file = input.files[0]

		if (file) {
			image = new Image()
			image.src = _URL.createObjectURL(file)

			image.onload = function() {
				if(image.height > maxHeight) {
					input.value = ""
					out.innerHTML = ""

					$.smkAlert({
		                text: `El alto de la imagen tiene que ser menor a <b>${maxHeight}</b>`,
		                type: 'danger'
		            })
				}

				if(image.width > maxWidth) {
					input.value = ""
					out.innerHTML = ""

					$.smkAlert({
		                text: `El ancho de la imagen tiene que ser menor a <b>${maxWidth}</b>`,
		                type: 'danger'
		            })
				}else {
					$.smkAlert({
		                text: 'Imagen correcta',
		                type: 'info'
		            })

		            document.getElementById(`${imgId}`).src = window.URL.createObjectURL(input.files[0])
				}
			}
		}
	}
</script>