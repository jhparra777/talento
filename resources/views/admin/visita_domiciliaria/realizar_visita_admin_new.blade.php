@extends("admin.layout.master")
@section('contenedor')
<style type="text/css">
/* .panel-heading{
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
    } */
    .panel-heading{
        text-align: center;
    }

    /* CSS styles checkbox*/
    .inputc {
        -webkit-appearance: none;
        appearance: none;
        width: 64px;
        padding-left: 33px;
        margin: 0;
        border-radius: 16px;
        background: radial-gradient(circle 12px, white 100%, transparent calc(100% + 1px)) #ccc -16px;
        transition: 0.3s ease-in-out;
    }
    
    .inputc[type="checkbox"] {                 
        padding-left: 33px;                
        }

    .inputc::before {
        content: "NO";
        font: bold 12px/32px Verdana;
        color: white;
    }

    [type="checkbox"]:checked {
        padding-left: 8px;
        background-color: #742c88;
        background-position: 16px;
    }

    :checked::before {
        content: "SI";
    }
</style>

 <div class="container col-md-12" style="margin-top: 20px">
            <div class="row">
                        <div class="question-paginate">
                            <div id="" class="question-items">

                                
                                @include("cv.visita.include._datos_basicos_new")
                                @include("cv.visita.include._estructura_familiar_new")
                                @include("cv.visita.include._aspecto_general_vivienda_new")
                                @include("cv.visita.include._ingresos_egresos_new")
                                @include("cv.visita.include._bienes_inmuebles_new")
                                @include("cv.visita.include._formacion_academica_new")
                                @include("cv.visita.include._informacion_laboral_new")
                                @include("cv.visita.include._estado_salud_new")
                                @include("cv.visita.include._informacion_adicional_new")
                                {{-- Se presenta si la visita es periodica = 1 --}}
                                @if($candidatos->clase_visita_id == 1)
                                    @include("cv.visita.include._visita_periodica_new")
                                @endif
                                @include("cv.visita.include._registro_fotografico_new")
                                @if($current_user->inRole("admin"))
                                    @include("cv.visita.include._observaciones_generales_new")
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

            // se valida solo el form-11 que es el de las obs generales
            //ya que saltaba la validacion de los botones de flechas(solo admin)
            if ($('#form-11').smkValidate()) {
                guardar = true;
                preguntas = [];

                $('.actual_motivo').prop('disabled', false);
                $('#tipo_id').prop('disabled', false);
                $('#guardar_visita').attr('disabled', true);
                var formData = $(".question-items .formulario").serialize();

                $.ajax({
                    url: "{{ route('admin.visita.save_visita_admin') }}",
                    type: "post",
                    data: formData,
                    cache: false,
                }).done(function (res) {
                    if(res.success){

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
                    }else{
                        //$("#modal_peq").find(".modal-content").html(res.view);
                    }
                });
                return false;
            }
        });
 	});
 </script>

@stop