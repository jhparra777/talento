<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
        Jefe inmediato @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
    </label>
    <div class="col-sm-12">
        {!! Form::select("jefe_inmediato",$jefes_inmediatos,null,["class"=>"form-control","id"=>"jefe_inmediato"]) !!}
    </div>
    <label id="jefe_inmediato" class="hidden text text-danger"> Este campo es Requerido</label>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
        Email jefe inmediato 
    </label>
    <div class="col-sm-12">
        {!! Form::text("email_jefe_inmediato",null,["class"=>"form-control","id"=>"email_jefe_inmediato","readonly"=>"readonly"]); !!}
    </div>
     <label id="email_jefe_inmediato" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
      Tipo Contrato @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
    </label>
    <div class="col-sm-12">
     {!! Form::select("tipo_contrato_id",$tipo_contrato,3,["class"=>"form-control","id"=>"tipo_contrato_id"]); !!}
    </div>
    <label id="tipo_contrato_id" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
        Tiempo contrato @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
    </label>
    <div class="col-sm-12">
     {!! Form::text("tiempo_contrato",NULL,["class"=>"form-control","id"=>"tiempo_contrato","readonly"=>"readonly","placeholder"=>"Solo para contrato temporal,fijo"]); !!}
    </div>
    <label id="tiempo_contrato" class="hidden text text-danger"> Este campo es Requerido</label>
</div>
<div class="col-md-6 form-group">
  <label class="col-sm-12" for="inputEmail3">
     Motivo de contrato @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
  </label>
  
  <div class="col-sm-12">
   {!! Form::select("motivo_requerimiento_id",$motivo,null,["class"=>"form-control","id"=>"motivo_contrato"]); !!}
  </div>
  <label id="motivo_requerimiento_id" class="hidden text text-danger"> Este campo es Requerido</label>
      @if($errors->has('motivo_requerimiento_id'))
       <span class="help-block"> <strong>{{$errors->first('motivo_requerimiento_id')}}</strong>
       </span>
      @endif
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
        Descripción motivo
    </label>
    <div class="col-sm-12">
        {!! Form::text("desc_motivo",NULL,["class"=>"form-control","id"=>"desc_motivo","readonly"=>"readonly","placeholder"=>"Solo para otro motivo contrato"]); !!}
    </div>
    <label id="desc_motivo" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-12" for="inputEmail3">
        Número Vacantes @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
    </label>
    <div class="col-sm-12">
        {!! Form::text("numero_vacante",1,["class"=>"form-control","id"=>"numero_vacante"]); !!}
    </div>
    <label id="numero_vacante" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-6 form-group" style="visibility: hidden;">
  <label class="col-sm-12" for="inputEmail3"> Número Vacantes </label>
    <div class="col-sm-12">
     {!! Form::text("numero_va",1,["class"=>"form-control","id"=>"numero_va"]); !!}
    </div>
</div>

<!-- Funciones -->
<div class="col-md-12 col-sm-12 form-group">
  <label class="col-sm-12" for="inputEmail3">
   Justificación @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif
  </label>
  
  <div class="col-sm-12">
   {!! Form::textarea("funciones_realizar",null,["class"=>"form-control","id"=>"funciones_realizar","rows"=>"3"]); !!}
  </div>
  <label id="funciones_realizar" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-12 col-sm-12 form-group">
  <label class="col-sm-12" for="inputEmail3">
   Observaciones  @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif</label>

    <div class="col-sm-12">
     {!! Form::textarea("observaciones",null,["class"=>"form-control","id"=>"observaciones","rows"=>"3"]); !!}
    </div>
  <label id="observaciones" class="hidden text text-danger"> Este campo es Requerido</label>
</div>

<div class="col-md-12 col-sm-12 form-group">
  <label class="col-sm-12" for="inputEmail3">
   Recursos necesarios @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
  </label>

  <div class="col-md-3 form-check form-check-inline">
    <input class="form-check-input" name="recurso[]" id="check_1" type="checkbox" value="Computador de mesa">
    <label class="form-check-label" for="check_1">Computador de mesa</label>
  </div>

  <div class="col-md-3 form-check form-check-inline">
   <input class="form-check-input" name="recurso[]" id="check_2" type="checkbox" value="Computador portatil">
   <label class="form-check-label" for="check_2">Computador portátil</label>
  </div>

   <div class="col-md-3 form-check form-check-inline">
    <input class="form-check-input" name="recurso[]" id="check_3" type="checkbox" value="Celular" >
    <label class="form-check-label" for="check_3">Celular</label>
   </div>

        <div class="col-md-3 form-check form-check-inline">
          <input class="form-check-input" name="recurso[]" id="check_4" type="checkbox" value="Licencia SAP" >
          <label class="form-check-label" for="check_4">Licencia SAP</label>
        </div>

        <div class="col-md-3 form-check form-check-inline">
         <input class="form-check-input" name="recurso[]" id="check_5" type="checkbox" value="Modem">
         <label class="form-check-label" for="check_5">Modem</label>
        </div>
        
        <div class="col-md-3 form-check form-check-inline">
          <input class="form-check-input" name="recurso[]" id="check_6" type="checkbox" value="Puesto de Trabajo" >
          <label class="form-check-label" for="check_6">Puesto de trabajo</label>
        </div>
        
        <div class="col-md-3 form-check form-check-inline">
          <input class="form-check-input" id="otro" id="otro" type="checkbox" value="otro">
         <label class="form-check-label" for="otro"> Otro</label>
        </div>
</div>

 <div class="col-md-6 form-group">
  <div class="col-sm-12">
    <input class="form-control hidden" name="recurso[]" id="NuevoRecurso" type="text" placeholder="Otro Recurso" value="">
  </div>
 </div>

<!-- Se cierra del otro lado -->
<div class="clear-fix"></div>
<div class="modal-footer">
  <button class="btn btn-default" data-dismiss="modal" type="button">
   <i class="fa fa-close"></i> Cerrar
  </button>
 <button class="btn btn-success" id="guardarSolicitud" type="button">
  <i class="fa fa-save"></i>Guardar solicitud
 </button>

</div>

<script>
 $(function(){

  $("#otro").on("click", function() {

    if($(this).is(':checked')){
         
      $('#NuevoRecurso').removeClass('hidden');
         
    }else{

      $('#NuevoRecurso').addClass('hidden');
      $('#NuevoRecurso').val('');
    }

  });

  $("#jefe_inmediato").change(function(){
    
    var valor = $(this).val();
    
    $.ajax({
      url: "{{ route('admin.selectEmailJefe') }}",
      type: 'POST',
      data: {id: valor},
      success: function(response){            
       $("#email_jefe_inmediato").val(response.email);
                    
      }
    });

  });
         //mostrar tiempo de contrato para contratos temporales
        $("#tipo_contrato_id").change(function(){

            if($(this).val()==7 || $(this).val()==2){
             
             $("#tiempo_contrato").attr("readonly",false);
             $("#tiempo_contrato").attr("placeholder","Ingrese tiempo del contrato");
             $("#tiempo_contrato").focus();

            }else{
              $("#tiempo_contrato").attr("readonly","readonly");
              $("#tiempo_contrato").val("");
            }
        });

        $("#motivo_contrato").change(function(){
            if($(this).val()==20){
             
             $("#desc_motivo").attr("readonly",false);
             $("#desc_motivo").attr("placeholder","Ingrese motivo");
             $("#desc_motivo").focus();
            
            }else{
             
             $("#desc_motivo").attr("readonly","readonly");
             $("#desc_motivo").val("");
            }
        });
        /**
         * Guardar solicitud
         **/
        $("#guardarSolicitud").on("click", function(){
           
          var formData = new FormData(document.getElementById("fr_nuevaSolicitud"));

            $.ajax({
                url: "{{ route('admin.solicitudGuardar') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    //imagen de carga
                  /*  $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    }); */
                   // $("#modal_gr").modal('toggle');
                },
                error: function (jqXHR, textStatus, data) {
                 //console.log(jqXHR.responseText[0]);
                 var valor = JSON.parse(jqXHR.responseText);
                 var mensaje = "";
                 $.each(valor, function (k, v) {
                  
                  mensaje += k + ": "+ v + " \n\n ";
                });

                 swal("Atencion",mensaje,"warning");
                // $("#modal_gr").modal('toggle');
                 return false;

                 //$("#modal_gr .close").click();

                 // setTimeout(function(){
                  //  window.location.reload();
                  //}, 3000);

                  //alert(mensaje); //error si hay datos obligatorios vacios
                 //  console.log(valor.motivo_requerimiento_id);
                },

                success: function(response){
                    //console.log("success");
                    $.blockUI({
                         message: $('div.mensajeNuevaSolicitud'),
                         fadeIn: 700,
                         fadeOut: 700,
                         timeout: 2000,
                         showOverlay: false,
                         centerY: false,
                         css: {
                           width: '350px',
                           button: '10px',
                           left: '',
                           right: '10px',
                           border: 'none',
                           padding: '5px',
                           backgroundColor: '#000',
                           '-webkit-border-radius': '10px',
                           '-moz-border-radius': '10px',
                           opacity: .6,
                           color: '#fff'
                         }
                     });

                    $("#modal_gr").modal('toggle');
                     location.reload();
                }
            });
        });
    });
</script>
