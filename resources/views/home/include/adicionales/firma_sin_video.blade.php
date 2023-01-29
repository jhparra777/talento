<div>
	<div class="encabezado">
		{{--<p>Ciudad y Fecha : {{$requerimiento->ciudad}} {{$fecha}}</p>
		
		<p style="text-transform: uppercase;">{{$user->name}}</p>
		
		<p>Identificado con CÉDULA CIUDADANÍA :{{$user->numero_id}}</p>--}}

		<table style="width: 100%;border: none;padding: 1em;border-collapse: collapse;text-align: center;">
			<tr>
				<td rowspan="2" style="width: 100px;border: none;">
					@if($requerimiento->logo!=null)
						<img style="max-width: 100px" src='{{ asset("configuracion_sitio/$requerimiento->logo") }}'>
					@else

					@if(isset(FuncionesGlobales::sitio()->logo))
                                        @if(FuncionesGlobales::sitio()->logo != "")

                                            <img 
                                                class="img-fluid"
                                                width="75"
                                                height="75" 
                                                src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                                
                                            >
                                        @else
                                            <img 
                                                class="img-fluid"
                                               
                                                src="{{ url("img/logo.png")}}"
                                                 width="75"
                                                height="75" 
                                            >
                                        @endif
                                    @else
                                        <img
                                            class="img-fluid"
                                           
                                            src="{{ url("img/logo.png")}}"
                                             width="75"
                                                height="75" 
                                        >
                       @endif
                    @endif

				</td>
				<td style="font-weight: bold;padding: .5em;border: none;">Aceptación preguntas</td>
			</tr>
		</table>
	</div>
	
	<br>
     {!!Form::open(["id"=>"fr_confirmacion",'enctype' => 'multipart/form-data'])!!}
      {!! Form::hidden("contrato_id",$contratoId,["id"=>"candidato_req_fr"]) !!}
      {!! Form::hidden("req_id",$reqId,["id"=>"candidato_req_fr"]) !!}
	<div>
	<p style="font-weight: bold;text-align: center;font-size: 1.6em;">Yo {{$user->name}}, identificado con documento {{$user->numero_id}} manifiesto que no cuento con cámara y/o video para realizar la confirmación biométrica del contrato que acabo de firmar, por lo cual manifiesto expresamente lo siguiente:
	    <ul>
		  <li> Las condiciones señaladas en el contrato de trabajo referentes a: Cargo a desempeñar, el valor del salario, su forma y períodos de pago, la duración del contrato y terminación. </li>
		  <li> Certifico que ha leído, comprendido y acepta en su totalidad las cláusulas del contrato de trabajo </li>
		  <li> Acepta la afiliación a las entidades del sistema de seguridad social en EPS, AFP y fondo de cesantías señalados en el contrato </li>
		  <li> Autoriza el uso y tratamiento de sus datos personales de conformidad con la cláusula de protección de datos que ratifica haber leído y comprendido </li>
	    </ul>
	</p>

    <p> En constancia de lo anterior es mi voluntad la cual ha sido concertada con la empresa @if(isset($funcionesGlobales->sitio()->nombre))
         @if($funcionesGlobales->sitio()->nombre != "")
            {{$funcionesGlobales->sitio()->nombre;}}
         @else
              Desarrollo
            @endif
    @endif

	 firmar el presente documento de forma electrónica mediante el dibujo de mi firma en señal de aceptación. </p>

     <p> <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime(" %d de %B de %Y") ?>. </p>
	<br>

  @if(!isset($firma))
  
    <br>
     <p>Firma en el recuadro en señal de aceptacion</p>

              <table class="col-md-12 col-xs-12 col-sm-12 center table" bgcolor="#f1f1f1">
                  <tr>
                      <td width="30%"></td>
                      <td>
                          <div>
                              <div>
                                <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                              </div>
                          </div>
                      </td>
                  </tr>
              </table>

          <hr>
          <br>
     @endif    
	
    <p style="font-weight: bold;">Firma:@if(isset($firma))<img src="{{$firma}}" style="width: 30%;">
	@else ________________________ @endif</p>
	<br>
     <p> {{$user->name}}</p>  
	 <p style="font-weight: bold;">C.C:{{$user->numero_id}}</p>
	</div>
<br>
@if(!isset($firma))
   <br>
    <p class="direction-botones-center set-margin-top">
      <button class="btn btn-success" id="guardar_evaluacion" type="submit">
       <i class="fa fa-floppy-o"></i>&nbsp;Finalizar </button>
    </p>
    
       <div class="text-center mt-4">
        <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
       </div>
@endif

</div>


 <script>
        
        const $btnCancelarContrato = document.querySelector('#btnCancelarContrato');
        var tokenvalue = $('meta[name="token"]').attr('content');

        let dashboardRedir = '{{ route('dashboard') }}';
        let routeCancel = '{{ route('cancelar_contratacion_candidato') }}';
        let contratoId  = '{{ $contratoId }}';
        let userId  = '{{ $userId }}';
        let reqId  = '{{ $reqId }}';

        const ToastNoTime = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true
        });
        
        const cancelContract = () => {
            Swal.fire({
                title: '¿Estas seguro/a?',
                text: "Esta acción es irreversible.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, cancelar',
                cancelButtonText: 'No, continuar'
            }).then((result) => {
                if (result.value) {
                    //$('#observeModal').modal('show');
                    Swal.fire({
                        title: 'Cancelación de contrato',
                        input: 'textarea',
                        inputPlaceholder: 'Describe la razón por la que quieres cancelar el contrato',
                        inputAttributes: {
                            'aria-label': 'Describe la razón por la que quieres cancelar el contrato'
                        },
                        inputValidator: (field) => {
                            if (!field) {
                                return 'Debes completar el campo'
                            }
                        },
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Enviar y cancelar',
                        cancelButtonText: 'Cancelar'
                    }).then((cancelation) => {
                        $.ajax({
                            type: 'POST',
                            data: {
                                _token : tokenvalue,
                                user_id : userId,
                                req_id : reqId,
                                contrato_id : contratoId,
                                observacion : cancelation.value
                            },
                            url: routeCancel,
                            beforeSend: function() {
                                ToastNoTime.fire({
                                    icon: 'info',
                                    title: 'Validando y guardando ...'
                                });
                            },
                            success: function(response) {
                                if(response.success == true){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Contrato cancelado.',
                                        showConfirmButton: false
                                    });

                                    setTimeout(() => {
                                        window.location.href = dashboardRedir
                                    }, 1000)
                                }
                            }
                        });
                    })
                }
            });
        }

        $btnCancelarContrato.addEventListener('click', () => {
            cancelContract()
        });
        
        
        $(function (){
            //Define the swal toast
            var firmBoard = new DrawingBoard.Board('firmBoard', {
                controls: [
                    { DrawingMode: { filler: false, eraser: false,  } },
                    { Navigation: { forward: false, back: false } }
                    //'Download'
                ],
                size: 2,
                webStorage: 'session',
                enlargeYourContainer: true
            });

            //listen draw event
            firmBoard.ev.bind('board:stopDrawing', getStopDraw);
            firmBoard.ev.bind('board:reset', getResetDraw);

            function getStopDraw() {
                $("#guardar_evaluacion").attr("disabled", false);
            }

            function getResetDraw() {
                $("#guardar_evaluacion").attr("disabled", true);
            }
        });  

      $("#fr_confirmacion").on("click", "#guardar_evaluacion", function (e) {
                e.preventDefault();

        if($("#acpt1").is(':checked') && $("#acpt2").is(':checked') && $("#acpt3").is(':checked') && $("#acpt4").is(':checked')){
            //$(this).prop("disabled", true)
            var formData = new FormData(document.getElementById("fr_confirmacion"));

            var canvas1 = document.getElementById('canvas');
            var canvas = canvas1.toDataURL();

            formData.append('firma',canvas);

            $.ajax({
                url: "{{route('guardar_confirmacion_manual')}}",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (res) {
                var res = $.parseJSON(res);
               if(res.success){
              //$("#guardar_nueva_prueba").removeAttr("disabled");     
                window.location.href="{{route('dashboard') }}";
               }
           });

        }else{
          
          Swal.fire({
            position: 'top-end',
            icon: 'danger',
            title: 'Debe aceptar todos los terminos.',
            showConfirmButton: false
          });
        }
         return false;
      });
    
    </script>
    </body>
</html>