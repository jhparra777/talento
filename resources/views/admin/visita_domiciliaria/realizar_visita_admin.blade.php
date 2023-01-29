@extends("admin.layout.master")
@section('contenedor')
<style type="text/css">
	.panel-heading{
            text-align: center;
        }
        h4{
            text-align: center;
            
            font-weight: bold;
            background: #f5f5f5;
            padding: .5em;
        }

        .checkbox-preferencias + .slide:after {
   		 position: absolute;
    	content: "NO" !important;
 		}

		.checkbox-preferencias:checked + .slide:after {
   		content: "SI"  !important;
		}
</style>

 <div class="container">
            <div class="row">
                        <div class="question-paginate">
                            <div id="" class="question-items">

                                
                                @include("cv.visita.include._datos_basicos")
                                @include("cv.visita.include._estructura_familiar")
                                @include("cv.visita.include._aspecto_general_vivienda")
                                @include("cv.visita.include._ingresos_egresos")
                                @include("cv.visita.include._bienes_inmuebles")
                                @include("cv.visita.include._informacion_tributaria")
                                @include("cv.visita.include._estado_salud")
                                @if($candidatos->clase_visita_id!=1)
                                    @include("cv.visita.include._aspectos_familiares")
                                    @include("cv.visita.include._recreacion")
                                    @include("cv.visita.include._referencia_vecinal")
                                @else
                                    @include("cv.visita.include._informacion_laboral")
                                @endif
                                @include("cv.visita.include._registro_fotográfico")
                                @if($current_user->inRole("admin"))

                                    @include("cv.visita.include._observaciones_generales")
                                    
                                @endif



                            </div>
                             <div class="pager mt-3 mb-3" id="paginationButtonBox">
                                <div class="btn-group btn-group-lg" role="group" aria-label="...">
                                    <button type="button" class="previousPage btn btn-default">
                                        <i class="fa fa-chevron-circle-left"></i> Anterior
                                    </button>
                                    <button type="button" class="nextPage btn btn-default">
                                        Siguiente <i class="fa fa-chevron-circle-right"></i>
                                    </button>
                                </div>

                                {{--<div class="question-page-numbers mt-1"></div>--}}
                            </div>
                        </div>
          </div>
 </div>

               

                    
              
                

                


         <div id="btn-guardar" class="col-md-12 text-center" style="margin-bottom: 2rem;">
               <button class="btn btn-success" id="guardar_visita_admin" type="submit">
                        <i class="fa fa-floppy-o"></i> Guardar
               </button>
         </div>
                <br>

 <script src="{{ asset('js/cv/paginator-js/visita-paginga.jquery.js') }}"></script>
 <script type="text/javascript">

 	const validateAnswers = (page) => {
                    
                    let form = $('.form-'+page);
                    if(form.smkValidate()){
                        return true;
                    }
                    else{
                        return false;
                    }
a                 
            };
 	$(function(){
 		$("#btn-guardar").hide();

        $( ".formulario" ).each(function(index) {
                    $( this ).addClass( "form-"+(index+1));
                });

 		$(".question-paginate").paginga({
        	itemsPerPage: 1,
         	itemsContainer: '.question-items',
         	pageNumbers: '.question-page-numbers'
         });

 		$(document).on('click', '.add-item', function (e) {
                    fila_person = $(this).parents('.old').find('.item').eq(0).clone();
                    fila_person.find('input').val('');
                    //fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person">-</button>');
                    fila_person.append('<div class="col-md-12 form-group last-child" style="display: block;text-align:center;"><button type="button" class="btn btn-danger rem-item">-</button></div>');

                    $(this).parents('.old').find('.padre').append(fila_person);
                });

          $(document).on('click', '.rem-item', function (e) {
                $(this).parents('.item').remove();

            });


 		$(document).on("click", "#guardar_visita_admin", function (e) {
                    e.preventDefault();

                    guardar = true;
                    preguntas = [];

                    /*$('.preguntas').each(function (index, item){
                        if ($('#' + item.id).hasClass('seleccion_simple') || $('#' + item.id).hasClass('seleccion_multiple')) {
                            respta = false;
                            $('#' + item.id + ' input').each(function (_index, input) {
                                if (input.checked) {
                                    respta = true;
                                    $('#titulo_' + item.id).removeClass('preg-faltante');
                                    $('#' + item.id).removeClass('preg-faltante');
                                }
                            });
                            if (!respta) {
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                preguntas.push(parseInt(index)+1);
                                guardar = false;
                            }
                        } else {
                            if ($('#' + item.id + ' textarea').val() == '' || $('#' + item.id + ' textarea').val() == undefined || $('#' + item.id + ' textarea').val() == null) {
                                preguntas.push(parseInt(index)+1);
                                $('#titulo_' + item.id).addClass('preg-faltante');
                                $('#' + item.id).addClass('preg-faltante');
                                guardar = false;
                            } else {
                                $('#titulo_' + item.id).removeClass('preg-faltante');
                                $('#' + item.id).removeClass('preg-faltante');
                            }
                        }
                    });

                    if (!guardar) {
                        mensaje = 'Debes responder todas las preguntas. Verifica la ';
                        preguntas.forEach(element => mensaje += ' pregunta ' + element + ', ');
                        $.smkAlert({
                            text: mensaje,
                            type: 'danger'
                        });
                    }*/

                        $('#guardar_visita').attr('disabled', true);
                        var formData = $(".question-items .formulario").serialize();
                        //var formData = new FormData(document.getElementsById("#form-1"));

                        
                        
                        //clearInterval(intervalWebcam);
                        /*$.smkAlert({
                            text: 'Guardando respuestas de visita, por favor espere',
                            type: 'info'
                        });*/

                        $.ajax({
                            url: "{{ route('admin.visita.save_visita_admin') }}",
                            type: "post",
                            //dataType: "html",
                            data: formData,
                            cache: false,
                            //contentType: false,
                            //processData: false
                        }).done(function (res) {
                            //var res = $.parseJSON(res);
                            
                            
                            if(res.success) {

                                var formData2 = new FormData(document.getElementById("form-imagenes"));
                                 $.ajax({
                                       url: "{{ route('save_images_pre_visita') }}",
                                        type: "post",
                                        dataType: "html",
                                        data: formData2,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            var respuesta=$.parseJSON(response);
                                            if(respuesta.success){
                                                $.smkAlert({
                                                    text: 'Visita gestionada con éxito',
                                                    type: 'success',
                                                    position:'top-right',
                                                    time:3
                                                });


                                                setTimeout(()=>{
                                                    window.location.href = '{{route("admin.gestionar_visita_domiciliaria",["id"=>$candidatos->id_visita])}}';
                                                },2500);

                                            }

                                        }

                                    });

                            	


                            } else {
                                //$("#modal_peq").find(".modal-content").html(res.view);
                            }
                        });
                    

                    return false;
                });
 	});
 </script>

@stop