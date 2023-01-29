@extends("cv.layouts.master_out")
@section('content')
	<style>
		.typeText{ user-select: none; font-size: 18px; line-height: 32px; }
		
		.typeInput { border-color: gray; }
		.typeInput:focus { box-shadow: none; border-color: gray; }

		.typeBold{ font-weight: 600; }

		.panel-body{ padding: 3rem; }
		.label { user-select: none; padding: .2em .8em .4em; }

		.custom-badge {
			color: #333;
			background-color: transparent;
			font-size: 15px;
		}

		.btn-default{ border: none; border-radius: 4px; font-size: 16px; background-color: #f9ca24; color: white; font-weight: bold; }
		
		.btn-default:hover{ background-color: #ebbd17; color: white; }
		.btn-default:focus{ background-color: #ebbd17; color: white; border: none; }

		.wcorrect{ color: #2ecc71; }
		.wwrong{ color: #e74c3c; }
        .wactual{ background-color: #f0f0f0; border-radius: 0.2rem; }

		.mr-5{ margin-right: 5px; }

		.m-0{ margin: 0; }	
        .m-1{ margin: 1rem; }
        .m-2{ margin: 2rem; }
        .m-3{ margin: 3rem; }
        .m-4{ margin: 4rem; }

        .p-0{ padding: 0; }	
        .p-1{ padding: 1rem; }
        .p-2{ padding: 2rem; }
        .p-3{ padding: 3rem; }
        .p-4{ padding: 4rem; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .m-auto{ margin: auto; }
	</style>

	<nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Prueba" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="60">
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <p class="navbar-text navbar-right">{{ $user->name }}</p>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
        	{{-- Panel resultados --}}
			@include('cv.pruebas.digitacion.includes._panel_digitacion_resultados')

            <div class="col-md-12 text-center mb-3" id="btnFinalizarBox" hidden>
                <a class="btn btn-default btn-lg" href="{{ route('dashboard') }}">FINALIZAR</a>
            </div>

        	{{-- Id del usuario y del requerimiento --}}
            <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
            <input type="hidden" name="requerimientoId" id="requerimientoId" value="{{ $requerimientoId }}">

            <div class="col-md-10 col-md-offset-1">
            	<div class="panel panel-default | typeText">
            		<div class="panel-body | typeBold" id="mainTxt">
            			@foreach($textArray as $index => $word)
            				<span class="wdefault" id="word{{ $index }}" data-word="{{ $index }}">{!! $word !!}</span>
            			@endforeach
            		</div>
            	</div>
            </div>

            <div class="col-md-9 col-md-offset-1">
            	<input type="text" class="form-control input-lg | typeInput" id="inputDigitacion" autofocus autocomplete="off">
            </div>

            <div class="col-md-1" style="margin: inherit;">
            	<h2 class="m-0">
            		<span class="label label-default" id="countdownLabel">1:00</span>
            	</h2>
            </div>
        </div>

        {{-- Webcam --}}
        @include('cv.pruebas.digitacion.includes._section_webcam')

        {{-- Modal --}}
		@include('cv.pruebas.digitacion.includes.modal._modal_digitacion_start')
		@include('cv.pruebas.digitacion.includes.modal._modal_digitacion_end')
    </div>

    {{-- Texto de la prueba convertido a json, viene del contralador. --}}
    <script>
    	let redir = "{{ route('dashboard') }}";
    	const mainTxtJson = {!! $textJson !!};
    </script>

    {{-- swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="{{ asset('js/cv/digitacion/prueba-digitacion-webcam.js') }}"></script>
    <script src="{{ asset('js/cv/digitacion/prueba-digitacion.js') }}"></script>
    <script>
    	$(function () {
    		//Ejecuta modal para avisar al usuario
    		$('#digitacionModal').modal({backdrop: 'static', keyboard: false, show: true});

    		//Al cerrar el modal se ejecuta todo
    		$('#digitacionModal').on('hidden.bs.modal', function (e) {
    			document.querySelector('#inputDigitacion').focus()

    			initWebcam()

    			//Espera a que den permiso a la camara
    			setTimeout(() => {
    				initCountdown()
    			}, 1000)
			});

			$("#panelResultados").smkPanel({
			  	hide: 'remove'
			});
    	});
    </script>
@stop