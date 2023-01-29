<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    
        <script src="{{ asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
          
        {{--<script src="{{ asset('public/js/jquery_custom.js') }}" type="text/javascript"></script>--}}

        <script src="{{ asset('js/cv/evaluacion_sst/evaluacion-sst-webcam.js') }}"></script>

         {{--<script src="https://code.jquery.com/jquery-1.12.0.js" type="text/javascript"></script>--}}
        <script src="{{ url('js/jquery-ui.js') }}" type="text/javascript"></script>

        {{-- SmokeJS --}}
        <script src="{{ asset("js/smoke/js/smoke.min.js") }}"></script>
        {{-- SmokeJS - Language --}}
        <script src="{{ asset("js/smoke/lang/es.min.js") }}"></script>

             {{-- Paginga Js --}}
        <script src="{{ asset('js/cv/paginator-js/visita-paginga.jquery.js') }}"></script>

        {{-- swal --}}
        <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>-->

        
        <script>

            const validateAnswers = (page) => {
                    
                    let form = $('.form-'+page);
                    if(form.smkValidate()){
                        return true;
                    }
                    else{
                        return false;
                    }
                 
            };

            

            $(document).on("keypress", ".solo_numeros", function (tecla) {
                console.log(tecla.charCode);
                if ((tecla.charCode < 48 || tecla.charCode > 57) && tecla.charCode != 0)
                    return false;
            });

            $(function () {

               
                $("#btn-guardar").hide();

                $( ".formulario" ).each(function(index) {
                    $( this ).addClass( "form-"+(index+1));
                });

                 $(document).on('click', '.add-item', function (e) {
                    fila_person = $(this).parents('.old').find('.item').eq(0).clone();
                    fila_person.find('input').val('');
                    fila_person.find(':selected').removeAttr('selected')
                    //fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person">-</button>');
                    fila_person.append('<div class="col-md-12 form-group last-child" style="display: block;text-align:center;"><button type="button" class="btn btn-danger rem-item | tri-px-2 tri-br-2 tri-border--none tri-transition-300"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar familiar</button></div>');

                    $(this).parents('.old').find('.padre').append(fila_person);
                });

             $(document).on('click', '.rem-item', function (e) {
                    $(this).parents('.item').remove();

                });
                //initWebcam()

                $(".question-paginate").paginga({
                    itemsPerPage: 1,
                    itemsContainer: '.question-items',
                    pageNumbers: '.question-page-numbers'
                });

                

                

                $(document).on('click', '.add-person', function (e) {
                    fila_person = $(this).parents('#nuevo_familiar').find('.grupos_fams').eq(0).clone();
                    fila_person.find('input').val('');
                    fila_person.find('.boton_aqui').append('<button type="button" class="btn btn-danger pull-right rem-person" title="Remover grupo">-</button>');

                    $('#nuevo_familiar').append(fila_person);
                });

                

                let firmBoard = new DrawingBoard.Board('firmBoard', {
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
                    $(".guardarFirma").attr("disabled", false);
                }

                function getResetDraw() {
                    $(".guardarFirma").attr("disabled", true);
                }

                $('input').click(function(){
                    _attr_id = $(this).parent().parent().parent().parent().attr('id');
                    $('#titulo_' + _attr_id).removeClass('preg-faltante');
                    $('#' + _attr_id).removeClass('preg-faltante');
                });

                $(document).on("click", ".guardarFirma", function() {
                    $('.drawing-board-canvas').attr('id', 'canvas');

                    var canvas1 = document.getElementById('canvas');
                    var canvas = canvas1.toDataURL();

                    var cand_id = $("#fr_id").val();
                    var token = ('_token', '{{ csrf_token() }}');
           
                    $.ajax({
                        type: 'POST',
                        data: {
                            visita_id : $("#fr_id").val(),
                            _token : token,
                            firma : canvas
                        },
                        url: "{{ route('save_firma_pre_form_visita') }}",
                        beforeSend: function(response) {
                            document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                            $.smkAlert({
                                text: 'Guardando su firma, por favor espere',
                                type: 'info'
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                let rutaDashboard = "{{ route('dashboard') }}";

                                swal("Felicitaciones", "Proceso de gestión de  formulario previo a la visita completado satisfactoriamente. ", "success", {
                                        buttons: {
                                            cancelar: {text: "Ok", className:'btn btn-success'}
                                        },
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then((value) => {
                                        switch (value) {
                                            case "cancelar":
                                               window.location.href = rutaDashboard;
                                            break;
                                        }
                                    });
                                

                                
                                /*
                                clearInterval(intervalWebcam)
                                stopWebcam()

                                document.querySelector(".guardarFirma").removeAttribute('disabled')

                                //
                                let rutaRedir = response.ruta

                                let rutaDashboard = "{{ route('dashboard') }}";

                                //Guardar fotos
                                let induccionImagenes = JSON.stringify(induccionPictures);

                                $.ajax({
                                    type: 'POST',
                                    data: {
                                        evaluacionId: $("#fr_id").val(),
                                        _token : token,
                                        induccionImagenes: induccionImagenes
                                    },
                                    url: "{{ route('save_fotos_sst') }}",
                                    beforeSend: function(response) {
                                        document.querySelector(".guardarFirma").setAttribute('disabled', 'disabled')
                                    },
                                    success: function(response) {
                                        swal("Felicitaciones", "Haz finalizado tu evaluación de inducción, el profesional de selección que está llevando tu proceso se contactará contigo para indicarte el paso a seguir.", "success", {
                                            buttons: {
                                                finalizar: {text: "Continuar", className:'btn btn-success'}
                                            },
                                            closeOnClickOutside: false,
                                            closeOnEsc: false,
                                            allowOutsideClick: false,
                                        }).then((value) => {
                                            switch (value) {
                                                case "finalizar":
                                                    window.open(rutaRedir, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
                                                    window.location.href = rutaDashboard;
                                                break;
                                            }
                                        });
                                    }
                                });
                            */}else{
                                document.querySelector(".guardarFirma").removeAttribute('disabled')
                            }
                        }
                    });
                });

                $(document).on("click", "#guardar_visita", function (e) {
                    e.preventDefault();

                    guardar = true;
                    preguntas = [];

                        $('.actual_motivo').prop('disabled', false);
                        $('#tipo_id').prop('disabled', false);
                        $('#guardar_visita').attr('disabled', true);
                        var formData = $(".question-items .formulario").serialize();
                        //var formData = new FormData(document.getElementsById("#form-1"));

                        
                        
                        //clearInterval(intervalWebcam);
                        $.smkAlert({
                            text: 'Guardando sus respuestas, por favor espere',
                            type: 'info'
                        });

                        $.ajax({
                            url: "{{ route('save_pre_visita') }}",
                            type: "post",
                            //dataType: "html",
                            data: formData,
                            cache: false,
                            //contentType: false,
                            //processData: false
                        }).done(function (res) {
                            //var res = $.parseJSON(res);
                            

                            if(res.success) {
                                    var id_c = res.visita_id;
                                    var formData = new FormData(document.getElementById("form-imagenes"));
                                    $.ajax({
                                       url: "{{ route('save_images_pre_visita') }}",
                                        type: "post",
                                        dataType: "html",
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        }).done(function (response) {
                                           
                                           var respuesta=$.parseJSON(response);
                                            
                                            var id_c = respuesta.visita_id;
                                            swal("Felicitaciones", "Ha realizado el formulario con éxito. Para finalizar debe firmar el documento.", "success", {
                                                buttons: {
                                                cancelar: {text: "Firmar", className:'btn btn-success'}
                                                },
                                                closeOnClickOutside: false,
                                                closeOnEsc: false,
                                                allowOutsideClick: false,
                                                }).then((value) => {
                                                    switch (value) {
                                                        case "cancelar":
                                                            $("#myModal").modal({
                                                                backdrop: 'static',
                                                                keyboard: false
                                                            });
                                                            $("#fr_id").val(id_c);
                                                        break;
                                                    }
                                                });

                                            
                                            
                                        
                                    });
                                    
                                    
                                
                            } else {
                                //$("#modal_peq").find(".modal-content").html(res.view);
                            }
                        });
                    

                    //return false;
                });

                
            });
        </script>
        <script>
            // var bPreguntar = true;
            // window.onbeforeunload = preguntarAntesDeSalir;

            // function preguntarAntesDeSalir () {
            //     var respuesta;
            //     if ( bPreguntar ) {
            //         respuesta = confirm ( '¿Seguro que quieres salir?' );

            //         if ( respuesta ) {
            //             window.onunload = function () {
            //                 return true;
            //             }
            //         } else {
            //             return false;
            //         }
            //     }
            // }
            var hook = true;
            window.onbeforeunload = function() {
                if (hook) {
                return "¿Seguro que quieres salir?"
                }
            }
            
            function unhook() {
                hook=false;
            }
        </script>